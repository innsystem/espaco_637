<?php

namespace App\Services;

use App\Models\Slider;
use App\Services\ImageOptimizationService;
use Illuminate\Http\UploadedFile;

class SliderService
{
    protected $imageOptimizationService;

    public function __construct(ImageOptimizationService $imageOptimizationService)
    {
        $this->imageOptimizationService = $imageOptimizationService;
    }
	public function getAllSliders($filters = [], $paginate = false, $perPage = 10)
	{
		$query = Slider::query();

		if (!empty($filters['name'])) {
			$query->where('title', 'LIKE', '%' . $filters['name'] . '%');
		}

		if (!empty($filters['status'])) {
			$query->where('status', $filters['status']);
		}

		if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
			$query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
		}

		if (!empty($filters['date_start'])) {
			$query->whereDate('date_start', '>=', $filters['date_start']);
		}
		if (!empty($filters['date_end'])) {
			$query->whereDate('date_end', '<=', $filters['date_end']);
		}

		if ($paginate) {
			return $query->paginate($perPage);
		}

		return $query->get();
	}

	public function getSliderById($id)
	{
		return Slider::findOrFail($id);
	}

	public function createSlider($data)
	{
        // Processar imagem se fornecida
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $imageResult = $this->processSliderImage($data['image']);
            if ($imageResult['success']) {
                $data['image'] = $imageResult['data']['original']['path'];
                $data['image_webp'] = $imageResult['data']['original']['path'];
                $data['image_fallback'] = $imageResult['data']['fallback']['path'];
                $data['image_responsive'] = json_encode($imageResult['data']['responsive'] ?? []);
            }
        }
        
		return Slider::create($data);
	}

	public function updateSlider($id, $data)
	{
		$model = Slider::findOrFail($id);
        
        // Processar imagem se fornecida
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Remover imagem antiga se existir
            if ($model->image) {
                $this->imageOptimizationService->deleteImage($model->image);
            }
            
            $imageResult = $this->processSliderImage($data['image']);
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

	public function deleteSlider($id)
	{
		$model = Slider::findOrFail($id);
		return $model->delete();
	}
    
    /**
     * Processa e otimiza imagem do slider
     *
     * @param UploadedFile $image
     * @return array
     */
    private function processSliderImage(UploadedFile $image)
    {
        // Definir tamanhos responsivos para sliders - 1920px (principal), 1600px, 768px
        // Mantendo proporção 16:9 para hero sliders
        $responsiveSizes = [
            ['width' => 1920, 'height' => 1080, 'suffix' => 'xl'],     // Principal - Desktop
            ['width' => 1600, 'height' => 900, 'suffix' => 'large'],   // Desktop médio
            ['width' => 768, 'height' => 432, 'suffix' => 'mobile']    // Mobile/Tablet
        ];
        
        return $this->imageOptimizationService->convertToWebP(
            $image, 
            'sliders', 
            'slider',
            $responsiveSizes
        );
    }

}
