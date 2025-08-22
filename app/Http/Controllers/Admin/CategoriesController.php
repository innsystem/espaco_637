<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Status;
use App\Models\Category;
use Carbon\Carbon;
use App\Services\CategoryService;
use App\Services\ImageOptimizationService;

class CategoriesController extends Controller
{
    public $name = 'Categoria';
    public $folder = 'admin.pages.categories';

    protected $categoryService;
    protected $imageOptimizationService;

    public function __construct(CategoryService $categoryService, ImageOptimizationService $imageOptimizationService)
    {
        $this->categoryService = $categoryService;
        $this->imageOptimizationService = $imageOptimizationService;
    }

    public function index()
    {
        return view($this->folder . '.index');
    }

    public function load(Request $request)
    {
        $query = [];
        $filters = $request->only(['name', 'status', 'date_range']);
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        if (!empty($filters['name'])) {
            $query['name'] = $filters['name'];
        }

        if (!empty($filters['status'])) {
            $query['status'] = $filters['status'];
        }

        if (!empty($filters['date_range'])) {
            [$startDate, $endDate] = explode(' até ', $filters['date_range']);
            $query['start_date'] = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $query['end_date'] = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');
        }

        $results = $this->categoryService->getAllCategories($query, true, $perPage);

        if ($request->ajax()) {
            return view($this->folder . '.index_load', compact('results'));
        }

        return view($this->folder . '.index_load', compact('results'));
    }

    public function create()
    {
        $statuses = Status::default();

        return view($this->folder . '.form', compact('statuses'));
    }

    public function store(Request $request)
    {
        $result = $request->all();

        $rules = array(
            'title' => 'required|unique:categories,title',
            'slug' => 'required|unique:categories,slug',
            'description' => 'nullable',
            'image' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'required',
        );
        $messages = array(
            'title.required' => 'título da categoria é obrigatório',
            'title.unique' => 'título da categoria já existe',
            'slug.required' => 'url amigável é obrigatório',
            'slug.unique' => 'url amigável já existe',
            'description.nullable' => 'descrição pode ser nula',
            'image.nullable' => 'imagem pode ser nula',
            'order.integer' => 'ordem deve ser um número inteiro',
            'status.required' => 'status é obrigatório',
        );

        $validator = Validator::make($result, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $category = $this->categoryService->createCategory($result);

        return response()->json($this->name . ' adicionada com sucesso', 200);
    }

    public function edit($id)
    {
        $result = $this->categoryService->getCategoryById($id);
        $statuses = Status::default();

        return view($this->folder . '.form', compact('result', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $result = $request->all();

        $rules = array(
            'title' => "required|unique:categories,title,$id,id",
            'slug' => "required|unique:categories,slug,$id,id",
            'description' => 'nullable',
            'image' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'required',
        );
        $messages = array(
            'title.required' => 'título da categoria é obrigatório',
            'title.unique' => 'título da categoria já existe',
            'slug.required' => 'url amigável é obrigatório',
            'slug.unique' => 'url amigável já existe',
            'description.nullable' => 'descrição pode ser nula',
            'image.nullable' => 'imagem pode ser nula',
            'order.integer' => 'ordem deve ser um número inteiro',
            'status.required' => 'status é obrigatório',
        );

        $validator = Validator::make($result, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $category = $this->categoryService->updateCategory($id, $result);

        return response()->json($this->name . ' atualizada com sucesso', 200);
    }

    public function delete($id)
    {
        $this->categoryService->deleteCategory($id);

        return response()->json($this->name . ' excluída com sucesso', 200);
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Arquivo inválido. Apenas imagens JPG, PNG, GIF e WebP são permitidas (máx. 5MB).'
            ], 422);
        }

        try {
            $image = $request->file('image');
            
            // Definir tamanhos responsivos para categorias
            $responsiveSizes = [
                ['width' => 300, 'height' => 200, 'suffix' => 'medium'],
                ['width' => 150, 'height' => 100, 'suffix' => 'small'],
                ['width' => 75, 'height' => 50, 'suffix' => 'thumb']
            ];
            
            // Converter para WebP com versões responsivas
            $result = $this->imageOptimizationService->convertToWebP(
                $image, 
                'categories', 
                'category',
                $responsiveSizes
            );
            
            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 500);
            }
            
            $imageData = $result['data'];
            
            return response()->json([
                'success' => true,
                'image_path' => $imageData['original']['path'],
                'image_url' => $imageData['original']['url'],
                'webp_url' => $imageData['original']['url'],
                'fallback_url' => $imageData['fallback']['url'],
                'responsive' => $imageData['responsive'] ?? [],
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