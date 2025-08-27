<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Admin\PortfoliosController;
use App\Models\Portfolio;
use App\Models\PortfolioImage;
use App\Services\PortfolioService;
use App\Services\ImageOptimizationService;
use Illuminate\Support\Facades\Storage;

class TestPortfolioImageUpload extends Command
{
    protected $signature = 'test:portfolio-upload {portfolio_id?}';
    protected $description = 'Test portfolio image upload functionality';

    public function handle()
    {
        $this->info('=== TESTE DE UPLOAD DE IMAGEM DO PORTFÓLIO ===');
        
        // Get or create a test portfolio
        $portfolioId = $this->argument('portfolio_id');
        
        if ($portfolioId) {
            $portfolio = Portfolio::find($portfolioId);
            if (!$portfolio) {
                $this->error("Portfólio com ID {$portfolioId} não encontrado!");
                return 1;
            }
        } else {
            // Create a test portfolio
            $portfolio = Portfolio::create([
                'title' => 'Teste Portfolio Upload',
                'slug' => 'teste-portfolio-upload-' . time(),
                'description' => 'Portfolio criado para teste de upload',
                'status' => 1,
                'sort_order' => 0
            ]);
            $this->info("Portfolio de teste criado com ID: {$portfolio->id}");
        }

        $this->info("Usando Portfolio: {$portfolio->title} (ID: {$portfolio->id})");

        // Check current images
        $currentImages = $portfolio->images()->count();
        $this->info("Imagens atuais no portfólio: {$currentImages}");

        // Create a test image file
        $testImagePath = $this->createTestImage();
        
        if (!$testImagePath) {
            $this->error('Falha ao criar imagem de teste!');
            return 1;
        }

        $this->info("Imagem de teste criada: {$testImagePath}");

        // Create UploadedFile instance
        $uploadedFile = new UploadedFile(
            $testImagePath,
            'test-image.jpg',
            'image/jpeg',
            null,
            true
        );

        // Create mock request
        $request = new Request();
        $request->files->set('image', $uploadedFile);
        $request->merge(['portfolio_id' => $portfolio->id]);

        $this->info('=== EXECUTANDO UPLOAD ===');

        try {
            // Initialize services
            $portfolioService = app(PortfolioService::class);
            $imageOptimizationService = app(ImageOptimizationService::class);
            
            // Create controller instance
            $controller = new PortfoliosController($portfolioService, $imageOptimizationService);
            
            // Execute upload
            $response = $controller->uploadImage($request);
            
            $this->info('=== RESULTADO DO UPLOAD ===');
            $this->info("Status Code: " . $response->getStatusCode());
            
            $responseData = json_decode($response->getContent(), true);
            $this->info("Response: " . json_encode($responseData, JSON_PRETTY_PRINT));

            // Check if image was created in database
            $newImagesCount = $portfolio->fresh()->images()->count();
            $this->info("Imagens após upload: {$newImagesCount}");

            if ($newImagesCount > $currentImages) {
                $this->info('✅ SUCESSO: Relação criada na tabela portfolio_images!');
                
                // Show the created image details
                $latestImage = $portfolio->fresh()->images()->latest()->first();
                if ($latestImage) {
                    $this->info("Imagem criada:");
                    $this->info("  - ID: {$latestImage->id}");
                    $this->info("  - Path: {$latestImage->image_path}");
                    $this->info("  - Featured: " . ($latestImage->featured ? 'Sim' : 'Não'));
                    $this->info("  - Sort Order: {$latestImage->sort_order}");
                }
            } else {
                $this->error('❌ FALHA: Relação NÃO foi criada na tabela portfolio_images!');
            }

        } catch (\Exception $e) {
            $this->error('❌ ERRO durante upload: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
        }

        // Cleanup test image
        if (file_exists($testImagePath)) {
            unlink($testImagePath);
            $this->info('Imagem de teste removida.');
        }

        $this->info('=== TESTE CONCLUÍDO ===');
        return 0;
    }

    private function createTestImage()
    {
        // Create a simple test image
        $width = 400;
        $height = 300;
        
        $image = imagecreatetruecolor($width, $height);
        
        // Fill with blue background
        $blue = imagecolorallocate($image, 0, 100, 200);
        imagefill($image, 0, 0, $blue);
        
        // Add some text
        $white = imagecolorallocate($image, 255, 255, 255);
        $text = 'TEST IMAGE ' . date('H:i:s');
        imagestring($image, 5, 50, 150, $text, $white);
        
        // Save to temporary file
        $tempPath = sys_get_temp_dir() . '/test_portfolio_image_' . time() . '.jpg';
        
        if (imagejpeg($image, $tempPath, 90)) {
            imagedestroy($image);
            return $tempPath;
        }
        
        imagedestroy($image);
        return false;
    }
}
