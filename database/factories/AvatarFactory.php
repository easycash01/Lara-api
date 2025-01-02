<?php

namespace Database\Factories;

use App\Models\Avatar;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvatarFactory extends Factory
{
    protected $model = Avatar::class;
    private $defaultFileName = 'default.jpg';
    private $defaultPath = 'images/avatars/default.jpg';

    /**
     * Converte i bytes in una forma leggibile (KB, MB, etc)
     */
    private function formatBytes($bytes)
    {
        if ($bytes === 0) return '0 Bytes';

        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));

        return sprintf('%.2f %s', $bytes / pow($k, $i), $sizes[$i]);
    }

    public function definition()
    {
        // Ottieni la dimensione reale del file in bytes
        $fileSize = file_exists(public_path($this->defaultPath)) 
            ? filesize(public_path($this->defaultPath)) // Restituisce la dimensione in bytes
            : null;

        // Per debug/log puoi vedere la dimensione formattata
        // info("Dimensione file: " . $this->formatBytes($fileSize));

        return [
            'path' => $this->defaultPath,
            'file_name' => $this->defaultFileName,
            'nome_originale' => $this->defaultFileName,
            'mime_type' => 'image/jpeg',
            'dimensione' => $fileSize // Dimensione in bytes
            
        ];
    }
} 