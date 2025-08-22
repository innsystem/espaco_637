<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageOptimizationService
{
    /**
     * Converte e otimiza uma imagem para WebP
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $prefix
     * @param array $sizes - Array de tamanhos para gerar versões responsivas
     * @return array
     */
    public function convertToWebP(UploadedFile $file, string $directory, string $prefix = '', array $sizes = []): array
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $timestamp = time();
        $baseFilename = $prefix ? "{$prefix}_{$timestamp}" : "{$originalName}_{$timestamp}";
        
        $results = [];
        
        try {
            // Criar imagem usando Intervention Image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            
            // Salvar versão original em WebP
            $webpFilename = "{$baseFilename}.webp";
            $webpPath = "{$directory}/{$webpFilename}";
            
            // Otimizar e salvar WebP
            $webpImage = $image->toWebp(95); // Aumentado de 85% para 95% para melhor qualidade
            Storage::disk('public')->put($webpPath, $webpImage);
            
            $results['original'] = [
                'path' => $webpPath,
                'url' => Storage::url($webpPath),
                'width' => $image->width(),
                'height' => $image->height(),
                'size' => strlen($webpImage)
            ];
            
            // Gerar versões responsivas se especificado
            if (!empty($sizes)) {
                $results['responsive'] = [];
                
                foreach ($sizes as $size) {
                    $width = $size['width'] ?? null;
                    $height = $size['height'] ?? null;
                    $suffix = $size['suffix'] ?? $width;
                    
                    $responsiveFilename = "{$baseFilename}_{$suffix}.webp";
                    $responsivePath = "{$directory}/{$responsiveFilename}";
                    
                    // Redimensionar mantendo proporção
                    $resizedImage = $image->scale($width, $height);
                    
                    $resizedWebp = $resizedImage->toWebp(95); // Aumentado para 95% para versões responsivas
                    Storage::disk('public')->put($responsivePath, $resizedWebp);
                    
                    $results['responsive'][] = [
                        'path' => $responsivePath,
                        'url' => Storage::url($responsivePath),
                        'width' => $resizedImage->width(),
                        'height' => $resizedImage->height(),
                        'size' => strlen($resizedWebp),
                        'suffix' => $suffix
                    ];
                }
            }
            
            // Salvar versão fallback (JPEG otimizado) para compatibilidade
            $fallbackFilename = "{$baseFilename}.jpg";
            $fallbackPath = "{$directory}/{$fallbackFilename}";
            
            $fallbackImage = $image->toJpeg(95); // Aumentado de 80% para 95% para melhor qualidade
            Storage::disk('public')->put($fallbackPath, $fallbackImage);
            
            $results['fallback'] = [
                'path' => $fallbackPath,
                'url' => Storage::url($fallbackPath),
                'width' => $image->width(),
                'height' => $image->height(),
                'size' => strlen($fallbackImage)
            ];
            
            return [
                'success' => true,
                'data' => $results,
                'message' => 'Imagem convertida para WebP com sucesso'
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro ao converter imagem: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Gera HTML picture element com WebP e fallback
     *
     * @param array $imageData
     * @param string $alt
     * @param string $class
     * @param array $attributes
     * @return string
     */
    public function generatePictureElement(array $imageData, string $alt = '', string $class = '', array $attributes = []): string
    {
        $webpUrl = $imageData['original']['url'] ?? '';
        $fallbackUrl = $imageData['fallback']['url'] ?? '';
        
        if (empty($webpUrl) || empty($fallbackUrl)) {
            return '';
        }
        
        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= " {$key}=\"{$value}\"";
        }
        
        $html = '<picture>';
        
        // Adicionar sources responsivos se existirem
        if (!empty($imageData['responsive'])) {
            foreach (array_reverse($imageData['responsive']) as $responsive) {
                $html .= "<source media=\"(max-width: {$responsive['width']}px)\" srcset=\"{$responsive['url']}\" type=\"image/webp\">";
            }
        }
        
        // Source WebP principal
        $html .= "<source srcset=\"{$webpUrl}\" type=\"image/webp\">";
        
        // Fallback IMG
        $html .= "<img src=\"{$fallbackUrl}\" alt=\"{$alt}\" class=\"{$class}\"{$attributesStr} loading=\"lazy\">";
        
        $html .= '</picture>';
        
        return $html;
    }
    
    /**
     * Remove imagens antigas do storage
     *
     * @param string $path
     * @return bool
     */
    public function deleteImage(string $path): bool
    {
        try {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                
                // Tentar remover versões WebP e responsivas relacionadas
                $pathInfo = pathinfo($path);
                $directory = $pathInfo['dirname'];
                $filename = $pathInfo['filename'];
                
                $relatedFiles = [
                    "{$directory}/{$filename}.webp",
                    "{$directory}/{$filename}_small.webp",
                    "{$directory}/{$filename}_medium.webp",
                    "{$directory}/{$filename}_large.webp"
                ];
                
                foreach ($relatedFiles as $file) {
                    if (Storage::disk('public')->exists($file)) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
