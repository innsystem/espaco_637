<?php

namespace App\Services;

use App\Models\Product;
use App\Services\ImageOptimizationService;
use Illuminate\Http\UploadedFile;

class ProductService
{
    protected $imageOptimizationService;

    public function __construct(ImageOptimizationService $imageOptimizationService)
    {
        $this->imageOptimizationService = $imageOptimizationService;
    }
    public function getAllProducts($filters = [], $paginate = false, $perPage = 10)
    {
        $query = Product::with(['category', 'statusRelation']);

        if (!empty($filters['name'])) {
            $query->where('title', 'LIKE', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        $query->orderBy('created_at', 'desc');

        if ($paginate) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    public function getProductById($id)
    {
        return Product::with(['category', 'statusRelation'])->findOrFail($id);
    }

    public function createProduct($data)
    {
        // Processar imagem se fornecida
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $imageResult = $this->processProductImage($data['image']);
            if ($imageResult['success']) {
                $data['image'] = $imageResult['data']['original']['path'];
                $data['image_webp'] = $imageResult['data']['original']['path'];
                $data['image_fallback'] = $imageResult['data']['fallback']['path'];
                $data['image_responsive'] = json_encode($imageResult['data']['responsive'] ?? []);
            }
        }
        
        return Product::create($data);
    }

    public function updateProduct($id, $data)
    {
        $model = Product::findOrFail($id);
        
        // Processar imagem se fornecida
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Remover imagem antiga se existir
            if ($model->image) {
                $this->imageOptimizationService->deleteImage($model->image);
            }
            
            $imageResult = $this->processProductImage($data['image']);
            if ($imageResult['success']) {
                $data['image'] = $imageResult['data']['original']['path'];
                $data['image_webp'] = $imageResult['data']['original']['path'];
                $data['image_fallback'] = $imageResult['data']['fallback']['path'];
                $data['image_responsive'] = json_encode($imageResult['data']['responsive'] ?? []);
            }
        }
        
        $model->update($data);
        return $model;
    }

    public function deleteProduct($id)
    {
        $model = Product::findOrFail($id);
        return $model->delete();
    }

    public function getActiveProducts()
    {
        return Product::active()->with(['category', 'statusRelation'])->get();
    }

    public function getProductsByCategory($categoryId)
    {
        return Product::active()->byCategory($categoryId)->with(['category', 'statusRelation'])->get();
    }
    
    /**
     * Processa e otimiza imagem do produto
     *
     * @param UploadedFile $image
     * @return array
     */
    private function processProductImage(UploadedFile $image)
    {
        // Definir tamanhos responsivos para produtos
        $responsiveSizes = [
            ['width' => 400, 'height' => 340, 'suffix' => 'medium'],
            ['width' => 200, 'height' => 170, 'suffix' => 'small'],
            ['width' => 141, 'height' => 141, 'suffix' => 'thumb']
        ];
        
        return $this->imageOptimizationService->convertToWebP(
            $image, 
            'products', 
            'product',
            $responsiveSizes
        );
    }
}