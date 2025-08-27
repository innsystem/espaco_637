<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Status;
use App\Models\Portfolio;
use App\Models\PortfolioImage;
use App\Models\Category;
use Carbon\Carbon;
use App\Services\PortfolioService;
use App\Services\ImageOptimizationService;

class PortfoliosController extends Controller
{
    public $name = 'Portfólio'; //  singular
    public $folder = 'admin.pages.portfolios';

    protected $portfolioService;
    protected $imageOptimizationService;

    public function __construct(PortfolioService $portfolioService, ImageOptimizationService $imageOptimizationService)
    {
        $this->portfolioService = $portfolioService;
        $this->imageOptimizationService = $imageOptimizationService;
    }

    public function index()
    {
        return view($this->folder . '.index');
    }

    public function load(Request $request)
    {
        $query = [];
        $filters = $request->only(['name', 'status', 'category_id', 'date_range']);
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        if (!empty($filters['name'])) {
            $query['name'] = $filters['name'];
        }

        if (!empty($filters['status'])) {
            $query['status'] = $filters['status'];
        }

        if (!empty($filters['category_id'])) {
            $query['category_id'] = $filters['category_id'];
        }

        if (!empty($filters['date_range'])) {
            [$startDate, $endDate] = explode(' até ', $filters['date_range']);
            $query['start_date'] = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $query['end_date'] = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');
        }

        $results = $this->portfolioService->getAllPortfolios($query, true, $perPage);

        if ($request->ajax()) {
            return view($this->folder . '.index_load', compact('results'));
        }

        return view($this->folder . '.index_load', compact('results'));
    }

    public function create()
    {
        $statuses = Status::default();
        $categories = $this->portfolioService->getAllCategories();

        return view($this->folder . '.form', compact('statuses', 'categories'));
    }

    public function store(Request $request)
    {
        $result = $request->all();

        $rules = array(
            'title' => 'required|unique:portfolios,title',
            'slug' => 'required|unique:portfolios,slug',
            'description' => 'nullable',
            'status' => 'required',
            'category_id' => 'nullable|exists:categories,id',
        );
        $messages = array(
            'title.required' => 'título é obrigatório',
            'title.unique' => 'título já existe',
            'slug.required' => 'url amigável é obrigatório',
            'slug.unique' => 'url amigável já existe',
            'description.nullable' => 'descrição pode ser nulo',
            'status.required' => 'status é obrigatório',
            'category_id.exists' => 'categoria selecionada não existe',
        );

        $validator = Validator::make($result, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $portfolio = $this->portfolioService->createPortfolio($result);

        if (isset($portfolio) && isset($portfolio->id)) {
            // Handle uploaded images from cropper (priority)
            if ($request->has('uploaded_images') && !empty($request->input('uploaded_images'))) {
                $uploadedImages = json_decode($request->input('uploaded_images'), true);
                $thumbIndex = $request->input('thumb');

                if (is_array($uploadedImages)) {
                    foreach ($uploadedImages as $index => $imageData) {
                        $portfolio->images()->create([
                            'image_path' => $imageData['image_path'],
                            'featured' => $index == $thumbIndex,
                            'sort_order' => $index,
                        ]);
                    }
                }
            }
            // Handle traditional file uploads (fallback - only if no cropper images)
            elseif ($request->hasFile('images')) {
                $images = $request->file('images');
                $thumbIndex = $request->input('thumb');

                foreach ($images as $index => $image) {
                    $path = $image->store('portfolios', 'public');
                    $portfolio->images()->create([
                        'image_path' => $path,
                        'featured' => $index == $thumbIndex,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return response()->json($this->name . ' adicionado com sucesso', 200);
    }

    public function edit($id)
    {
        $result = $this->portfolioService->getPortfolioById($id);
        $statuses = Status::default();
        $categories = $this->portfolioService->getAllCategories();

        return view($this->folder . '.form', compact('result', 'statuses', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $result = $request->all();

        $rules = array(
            'title'         => "unique:portfolios,title,$id,id",
            'slug'         => "unique:portfolios,slug,$id,id",
            'description' => 'nullable',
            'status' => 'required',
            'category_id' => 'nullable|exists:categories,id',
        );
        $messages = array(
            'title.required' => 'título é obrigatório',
            'title.unique' => 'título já existe',
            'slug.required' => 'url amigável é obrigatório',
            'slug.unique' => 'url amigável já existe',
            'description.nullable' => 'descrição pode ser nulo',
            'status.required' => 'status é obrigatório',
            'category_id.exists' => 'categoria selecionada não existe',
        );

        $validator = Validator::make($result, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $portfolio = $this->portfolioService->updatePortfolio($id, $result);

        if (isset($portfolio) && isset($portfolio->id)) {
            // Handle uploaded images from cropper (priority)
            if ($request->has('uploaded_images') && !empty($request->input('uploaded_images'))) {
                $uploadedImages = json_decode($request->input('uploaded_images'), true);
                $thumbIndex = $request->input('thumb');
                $maxOrder = $portfolio->images()->max('sort_order') ?? -1;

                if (is_array($uploadedImages)) {
                    foreach ($uploadedImages as $index => $imageData) {
                        $portfolio->images()->create([
                            'image_path' => $imageData['image_path'],
                            'featured' => $index == $thumbIndex,
                            'sort_order' => $maxOrder + $index + 1,
                        ]);
                    }
                }
            }
            // Handle traditional file uploads (fallback - only if no cropper images)
            elseif ($request->hasFile('images')) {
                $images = $request->file('images');
                $thumbIndex = $request->input('thumb');

                // Pegar o maior sort_order atual
                $maxOrder = $portfolio->images()->max('sort_order') ?? -1;

                foreach ($images as $index => $image) {
                    $path = $image->store('portfolios', 'public');
                    $portfolio->images()->create([
                        'image_path' => $path,
                        'featured' => $index == $thumbIndex,
                        'sort_order' => $maxOrder + $index + 1,
                    ]);
                }
            }
        }

        return response()->json($this->name . ' atualizado com sucesso', 200);
    }

    public function delete($id)
    {
        $this->portfolioService->deletePortfolio($id);

        return response()->json($this->name . ' excluído com sucesso', 200);
    }

    public function deleteImage($image_id)
    {
        $this->portfolioService->deleteImagePortfolio($image_id);

        return response()->json('Imagem do ' . $this->name . ' excluído com sucesso', 200);
    }

    public function defineImageThumb(Request $request, $portfolio_id)
    {
        $image_id = $request->input('image_id');
        
        // Remove destaque de todas as imagens do portfólio
        PortfolioImage::where('portfolio_id', $portfolio_id)->update(['featured' => 0]);
        
        // Define a nova imagem destacada
        PortfolioImage::where('id', $image_id)->update(['featured' => 1]);
        
        return response()->json('Imagem destacada definida com sucesso', 200);
    }

    public function reorderImages(Request $request, $portfolio_id)
    {
        $imageOrders = $request->input('image_orders', []);
        
        if (empty($imageOrders)) {
            return response()->json('Nenhuma ordem de imagem fornecida', 422);
        }

        $this->portfolioService->reorderImages($portfolio_id, $imageOrders);
        
        return response()->json('Ordem das imagens atualizada com sucesso', 200);
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'portfolio_id' => 'nullable|exists:portfolios,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Arquivo inválido. Apenas imagens JPG, PNG, GIF e WebP são permitidas (máx. 5MB).'
            ], 422);
        }

        try {
            $image = $request->file('image');
            
            \Log::info('Portfolio Upload Debug', [
                'has_portfolio_id' => $request->has('portfolio_id'),
                'portfolio_id_value' => $request->portfolio_id,
                'image_name' => $image->getClientOriginalName(),
                'image_size' => $image->getSize()
            ]);
            
            // Definir tamanhos responsivos para portfólios
            $responsiveSizes = [
                ['width' => 800, 'height' => 600, 'suffix' => 'large'],
                ['width' => 400, 'height' => 300, 'suffix' => 'medium'],
                ['width' => 200, 'height' => 150, 'suffix' => 'small'],
                ['width' => 141, 'height' => 141, 'suffix' => 'thumb']
            ];
            
            // Converter para WebP com versões responsivas
            $result = $this->imageOptimizationService->convertToWebP(
                $image, 
                'portfolios', 
                'portfolio',
                $responsiveSizes
            );
            
            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 500);
            }
            
            $imageData = $result['data'];
            
            // Create portfolio image record if portfolio_id is provided
            $portfolioImage = null;
            if ($request->has('portfolio_id') && $request->portfolio_id) {
                \Log::info('Attempting to create portfolio image relationship', [
                    'portfolio_id' => $request->portfolio_id
                ]);
                
                $portfolio = Portfolio::find($request->portfolio_id);
                if ($portfolio) {
                    \Log::info('Portfolio found', ['portfolio_title' => $portfolio->title]);
                    
                    // Get the highest sort_order for this portfolio
                    $maxOrder = $portfolio->images()->max('sort_order') ?? -1;
                    
                    $portfolioImage = $portfolio->images()->create([
                        'image_path' => $imageData['original']['path'],
                        'featured' => false, // Will be set manually later
                        'sort_order' => $maxOrder + 1,
                    ]);
                    
                    \Log::info('Portfolio image created', [
                        'portfolio_image_id' => $portfolioImage->id,
                        'image_path' => $portfolioImage->image_path,
                        'sort_order' => $portfolioImage->sort_order
                    ]);
                } else {
                    \Log::error('Portfolio not found', ['portfolio_id' => $request->portfolio_id]);
                }
            } else {
                \Log::info('No portfolio_id provided or empty', [
                    'has_portfolio_id' => $request->has('portfolio_id'),
                    'portfolio_id_value' => $request->portfolio_id
                ]);
            }
            
            return response()->json([
                'success' => true,
                'image_path' => $imageData['original']['path'],
                'image_url' => $imageData['original']['url'],
                'webp_url' => $imageData['original']['url'],
                'fallback_url' => $imageData['fallback']['url'],
                'responsive' => $imageData['responsive'] ?? [],
                'portfolio_image_id' => $portfolioImage ? $portfolioImage->id : null,
                'optimization_info' => [
                    'original_size' => $imageData['original']['size'],
                    'fallback_size' => $imageData['fallback']['size'],
                    'savings' => $imageData['fallback']['size'] - $imageData['original']['size']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao fazer upload da imagem: ' . $e->getMessage()
            ], 500);
        }
    }
}
