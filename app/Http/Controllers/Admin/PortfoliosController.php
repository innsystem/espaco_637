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

class PortfoliosController extends Controller
{
    public $name = 'Portfólio'; //  singular
    public $folder = 'admin.pages.portfolios';

    protected $portfolioService;

    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
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
            if ($request->hasFile('images')) {
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
            if ($request->hasFile('images')) {
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
}
