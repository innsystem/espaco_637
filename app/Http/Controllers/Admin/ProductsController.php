<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Status;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use App\Services\ProductService;
use App\Services\ImageOptimizationService;

class ProductsController extends Controller
{
    public $name = 'Produto';
    public $folder = 'admin.pages.products';

    protected $productService;
    protected $imageOptimizationService;

    public function __construct(ProductService $productService, ImageOptimizationService $imageOptimizationService)
    {
        $this->productService = $productService;
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

        $results = $this->productService->getAllProducts($query, true, $perPage);

        if ($request->ajax()) {
            return view($this->folder . '.index_load', compact('results'));
        }

        return view($this->folder . '.index_load', compact('results'));
    }

    public function create()
    {
        $statuses = Status::default();
        $categories = Category::active()->ordered()->get();

        return view($this->folder . '.form', compact('statuses', 'categories'));
    }

    public function store(Request $request)
    {
        $result = $request->all();

        $rules = array(
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:products,slug',
            'description' => 'nullable',
            'image' => 'nullable|string',
            // 'price' => 'required|numeric|min:0',
            // 'stock' => 'required|integer|min:0',
            'status' => 'required|exists:statuses,id',
        );
        $messages = array(
            'category_id.required' => 'categoria é obrigatória',
            'category_id.exists' => 'categoria selecionada não existe',
            'title.required' => 'título do produto é obrigatório',
            'slug.required' => 'url amigável é obrigatório',
            'slug.unique' => 'url amigável já existe',
            'description.nullable' => 'descrição pode ser nula',
            'image.nullable' => 'imagem pode ser nula',
            'price.required' => 'preço é obrigatório',
            'price.numeric' => 'preço deve ser um número',
            'price.min' => 'preço deve ser maior ou igual a 0',
            'stock.required' => 'estoque é obrigatório',
            'stock.integer' => 'estoque deve ser um número inteiro',
            'stock.min' => 'estoque deve ser maior ou igual a 0',
            'status.required' => 'status é obrigatório',
        );

        $validator = Validator::make($result, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $result['price'] = 0;
        $result['stock'] = 0;

        $product = $this->productService->createProduct($result);

        return response()->json($this->name . ' adicionado com sucesso', 200);
    }

    public function edit($id)
    {
        $result = $this->productService->getProductById($id);
        $statuses = Status::default();
        $categories = Category::active()->ordered()->get();

        return view($this->folder . '.form', compact('result', 'statuses', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $result = $request->all();

        $rules = array(
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => "required|unique:products,slug,$id,id",
            'description' => 'nullable',
            'image' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|exists:statuses,id',
        );
        $messages = array(
            'category_id.required' => 'categoria é obrigatória',
            'category_id.exists' => 'categoria selecionada não existe',
            'title.required' => 'título do produto é obrigatório',
            'slug.required' => 'url amigável é obrigatório',
            'slug.unique' => 'url amigável já existe',
            'description.nullable' => 'descrição pode ser nula',
            'image.nullable' => 'imagem pode ser nula',
            'price.required' => 'preço é obrigatório',
            'price.numeric' => 'preço deve ser um número',
            'price.min' => 'preço deve ser maior ou igual a 0',
            'stock.required' => 'estoque é obrigatório',
            'stock.integer' => 'estoque deve ser um número inteiro',
            'stock.min' => 'estoque deve ser maior ou igual a 0',
            'status.required' => 'status é obrigatório',
        );

        $validator = Validator::make($result, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $product = $this->productService->updateProduct($id, $result);

        return response()->json($this->name . ' atualizado com sucesso', 200);
    }

    public function delete($id)
    {
        $this->productService->deleteProduct($id);

        return response()->json($this->name . ' excluído com sucesso', 200);
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Aumentado para 5MB e adicionado WebP
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Arquivo inválido. Apenas imagens JPG, PNG, GIF e WebP são permitidas (máx. 5MB).'
            ], 422);
        }

        try {
            $image = $request->file('image');
            
            // Definir tamanhos responsivos para produtos
            $responsiveSizes = [
                ['width' => 400, 'height' => 340, 'suffix' => 'medium'],
                ['width' => 200, 'height' => 170, 'suffix' => 'small'],
                ['width' => 141, 'height' => 141, 'suffix' => 'thumb']
            ];
            
            // Converter para WebP com versões responsivas
            $result = $this->imageOptimizationService->convertToWebP(
                $image, 
                'products', 
                'product',
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