<?php

namespace App\Services;

use App\Models\Category;
use App\Services\ImageOptimizationService;
use Illuminate\Http\UploadedFile;

class CategoryService
{
    protected $imageOptimizationService;

    public function __construct(ImageOptimizationService $imageOptimizationService)
    {
        $this->imageOptimizationService = $imageOptimizationService;
    }
    public function getAllCategories($filters = [], $paginate = false, $perPage = 10)
    {
        $query = Category::query();

        if (!empty($filters['name'])) {
            $query->where('title', 'LIKE', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        $query->orderBy('order', 'asc');

        if ($paginate) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }

    public function createCategory($data)
    {
        // Processar imagem se fornecida
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $imageResult = $this->processCategoryImage($data['image']);
            if ($imageResult['success']) {
                $data['image'] = $imageResult['data']['original']['path'];
                $data['image_webp'] = $imageResult['data']['original']['path'];
                $data['image_fallback'] = $imageResult['data']['fallback']['path'];
                $data['image_responsive'] = json_encode($imageResult['data']['responsive'] ?? []);
            }
        }
        
        return Category::create($data);
    }

    public function updateCategory($id, $data)
    {
        $model = Category::findOrFail($id);
        
        // Processar imagem se fornecida
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Remover imagem antiga se existir
            if ($model->image) {
                $this->imageOptimizationService->deleteImage($model->image);
            }
            
            $imageResult = $this->processCategoryImage($data['image']);
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

    public function deleteCategory($id)
    {
        $model = Category::findOrFail($id);
        return $model->delete();
    }

    public function getActiveCategories()
    {
        return Category::active()->ordered()->get();
    }
    
    /**
     * Processa e otimiza imagem da categoria
     *
     * @param UploadedFile $image
     * @return array
     */
    private function processCategoryImage(UploadedFile $image)
    {
        // Definir tamanhos responsivos para categorias
        $responsiveSizes = [
            ['width' => 300, 'height' => 200, 'suffix' => 'medium'],
            ['width' => 150, 'height' => 100, 'suffix' => 'small'],
            ['width' => 75, 'height' => 50, 'suffix' => 'thumb']
        ];
        
        return $this->imageOptimizationService->convertToWebP(
            $image, 
            'categories', 
            'category',
            $responsiveSizes
        );
    }
}