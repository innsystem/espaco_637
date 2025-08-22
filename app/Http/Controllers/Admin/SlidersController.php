<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Status;
use App\Models\Slider;
use Carbon\Carbon;
use App\Services\SliderService;
use App\Services\ImageOptimizationService;

class SlidersController extends Controller
{
    public $name = 'Slider'; //  singular
    public $folder = 'admin.pages.sliders';

    protected $sliderService;
    protected $imageOptimizationService;

    public function __construct(SliderService $sliderService, ImageOptimizationService $imageOptimizationService)
    {
        $this->sliderService = $sliderService;
        $this->imageOptimizationService = $imageOptimizationService;
    }

    public function index()
    {
        return view($this->folder . '.index');
    }

    public function load(Request $request)
    {
        $query = [];
        $filters = $request->only(['name', 'status', 'date_range', 'date_start', 'date_end']);
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
        if (!empty($filters['date_start'])) {
            $query['date_start'] = $filters['date_start'];
        }
        if (!empty($filters['date_end'])) {
            $query['date_end'] = $filters['date_end'];
        }

        $results = $this->sliderService->getAllSliders($query, true, $perPage);

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
            'title' => 'required',
            'subtitle' => 'nullable',
            'image' => 'required',
            'status' => 'required',
        );
        $messages = array(
            'title.required' => 'title é obrigatório',
            'subtitle.nullable' => 'subtitle pode ser nulo',
            'image.required' => 'image é obrigatório',
            'status.required' => 'status é obrigatório',
        );

        $validator = Validator::make($result, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageResult = $this->processSliderImage($image);
            if ($imageResult['success']) {
                $result['image'] = $imageResult['data']['original']['path'];
                $result['image_webp'] = $imageResult['data']['original']['path'];
                $result['image_fallback'] = $imageResult['data']['fallback']['path'];
                $result['image_responsive'] = json_encode($imageResult['data']['responsive'] ?? []);
            }
        }

        $slider = $this->sliderService->createSlider($result);

        return response()->json($this->name . ' adicionado com sucesso', 200);
    }

    public function edit($id)
    {
        $result = $this->sliderService->getSliderById($id);
        $statuses = Status::default();

        return view($this->folder . '.form', compact('result', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $result = $request->all();

        // 'email'         => "unique:sliders,email,$id,id",
        $rules = array(
            'title' => 'required',
            'subtitle' => 'nullable',
            'href' => 'nullable',
            'target' => 'required',
            'image' => 'required',
            'status' => 'required',
        );
        $messages = array(
            'title.required' => 'title é obrigatório',
            'subtitle.nullable' => 'subtitle pode ser nulo',
            'href.required' => 'href é obrigatório',
            'href.nullable' => 'href pode ser nulo',
            'target.required' => 'target é obrigatório',
            'image.required' => 'image é obrigatório',
            'status.required' => 'status é obrigatório',
        );

        $validator = Validator::make($result, $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        if ($request->hasFile('image')) {
            $slider = $this->sliderService->getSliderById($id);
            
            // Remover imagem antiga se existir
            if ($slider->image) {
                $this->imageOptimizationService->deleteImage($slider->image);
            }
            
            $image = $request->file('image');
            $imageResult = $this->processSliderImage($image);
            if ($imageResult['success']) {
                $result['image'] = $imageResult['data']['original']['path'];
                $result['image_webp'] = $imageResult['data']['original']['path'];
                $result['image_fallback'] = $imageResult['data']['fallback']['path'];
                $result['image_responsive'] = json_encode($imageResult['data']['responsive'] ?? []);
            }
        }
        $slider = $this->sliderService->updateSlider($id, $result);

        return response()->json($this->name . ' atualizado com sucesso', 200);
    }

    public function delete($id)
    {
        $this->sliderService->deleteSlider($id);

        return response()->json($this->name . ' excluído com sucesso', 200);
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'image.required' => 'A imagem é obrigatória.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.mimes' => 'Apenas imagens JPG, PNG, GIF e WebP são permitidas.',
            'image.max' => 'A imagem não pode ser maior que 5MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $image = $request->file('image');
            
            $result = $this->processSliderImage($image);
            
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
    
    /**
     * Processa e otimiza imagem do slider
     *
     * @param UploadedFile $image
     * @return array
     */
    private function processSliderImage($image)
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
