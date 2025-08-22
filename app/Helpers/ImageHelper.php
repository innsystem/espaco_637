<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Gera HTML picture element com WebP e fallback
     *
     * @param string $imagePath - Caminho da imagem original
     * @param string $alt - Texto alternativo
     * @param string $class - Classes CSS
     * @param array $attributes - Atributos adicionais
     * @return string
     */
    public static function webpPicture($imagePath, $alt = '', $class = '', $attributes = [])
    {
        if (empty($imagePath)) {
            return '';
        }

        // Remover 'storage/' do início se existir
        $cleanPath = str_replace('storage/', '', $imagePath);
        
        // Gerar URLs WebP e fallback
        $pathInfo = pathinfo($cleanPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        
        $webpPath = "{$directory}/{$filename}.webp";
        $fallbackPath = $cleanPath;
        
        // Verificar se WebP existe
        $webpUrl = Storage::disk('public')->exists($webpPath) 
            ? Storage::url($webpPath) 
            : Storage::url($fallbackPath);
            
        $fallbackUrl = Storage::url($fallbackPath);
        
        // Gerar atributos
        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= " {$key}=\"{$value}\"";
        }
        
        // Verificar se há versões responsivas
        $responsiveVersions = [
            ['suffix' => 'thumb', 'maxWidth' => '200px'],
            ['suffix' => 'small', 'maxWidth' => '400px'],
            ['suffix' => 'medium', 'maxWidth' => '800px']
        ];
        
        $html = '<picture>';
        
        // Adicionar sources responsivos
        foreach ($responsiveVersions as $version) {
            $responsivePath = "{$directory}/{$filename}_{$version['suffix']}.webp";
            if (Storage::disk('public')->exists($responsivePath)) {
                $responsiveUrl = Storage::url($responsivePath);
                $html .= "<source media=\"(max-width: {$version['maxWidth']})\" srcset=\"{$responsiveUrl}\" type=\"image/webp\">";
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
     * Retorna URL WebP se existir, senão retorna original
     *
     * @param string $imagePath
     * @param string $suffix - Sufixo para versões responsivas (opcional)
     * @return string
     */
    public static function webpUrl($imagePath, $suffix = null)
    {
        if (empty($imagePath)) {
            return '';
        }

        $cleanPath = str_replace('storage/', '', $imagePath);
        $pathInfo = pathinfo($cleanPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        
        // Se um sufixo foi fornecido, tentar usar versão responsiva
        if ($suffix) {
            $responsiveWebpPath = "{$directory}/{$filename}_{$suffix}.webp";
            if (Storage::disk('public')->exists($responsiveWebpPath)) {
                return Storage::url($responsiveWebpPath);
            }
        }
        
        // Fallback para versão principal WebP
        $webpPath = "{$directory}/{$filename}.webp";
        
        return Storage::disk('public')->exists($webpPath) 
            ? Storage::url($webpPath) 
            : Storage::url($cleanPath);
    }

    /**
     * Gera srcset responsivo para sliders
     *
     * @param string $imagePath
     * @return string
     */
    public static function webpSrcset($imagePath)
    {
        if (empty($imagePath)) {
            return '';
        }

        $cleanPath = str_replace('storage/', '', $imagePath);
        $pathInfo = pathinfo($cleanPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        
        $srcset = [];
        
        // Verificar versões responsivas disponíveis
        $responsiveVersions = [
            ['suffix' => 'mobile', 'width' => 768],
            ['suffix' => 'large', 'width' => 1600],
            ['suffix' => 'xl', 'width' => 1920]
        ];
        
        foreach ($responsiveVersions as $version) {
            $responsivePath = "{$directory}/{$filename}_{$version['suffix']}.webp";
            if (Storage::disk('public')->exists($responsivePath)) {
                $srcset[] = Storage::url($responsivePath) . ' ' . $version['width'] . 'w';
            }
        }
        
        // Adicionar versão principal se não estiver na lista
        $webpPath = "{$directory}/{$filename}.webp";
        if (Storage::disk('public')->exists($webpPath)) {
            $srcset[] = Storage::url($webpPath) . ' 1920w';
        }
        
        return implode(', ', $srcset);
    }
}
