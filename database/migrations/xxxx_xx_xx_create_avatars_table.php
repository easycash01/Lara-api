<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $defaultPath;
    private $uploadPath;
    private $defaultFileName;
    private $resourcePath;

    /**
     * Inizializza i percorsi per gli avatar
     */
    public function __construct()
    {
        $this->defaultFileName = 'default.jpg';
        $this->defaultPath = 'images/avatars/' . $this->defaultFileName;
        $this->uploadPath = 'images/avatars';
        $this->resourcePath = 'images/placeholder-avatar.jpg';
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crea la directory per gli avatar se non esiste
        if (!file_exists(public_path($this->uploadPath))) {
            mkdir(public_path($this->uploadPath), 0755, true);
        }

        // Se l'immagine default non esiste in resources, crea un'immagine vuota
        if (!file_exists(resource_path($this->resourcePath))) {
            // Crea un'immagine vuota 100x100
            $image = imagecreatetruecolor(100, 100);
            // Colore di sfondo grigio
            $bgColor = imagecolorallocate($image, 200, 200, 200);
            imagefill($image, 0, 0, $bgColor);
            // Salva l'immagine in resources
            imagejpeg($image, resource_path($this->resourcePath));
            imagedestroy($image);
        }

        // Copia l'immagine default da resources a public
        copy(
            resource_path($this->resourcePath),
            public_path($this->defaultPath)
        );

        Schema::create('avatars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->unique()
                  ->constrained('customer')
                  ->onDelete('cascade');
            $table->string('path')->default($this->defaultPath);
            $table->string('file_name')->default($this->defaultFileName);
            $table->string('nome_originale')->nullable();
            $table->string('mime_type')->nullable();
            $table->integer('dimensione')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatars');
                
        // Opzionale: rimuovi anche la directory degli avatar
        // if (file_exists(public_path($this->uploadPath))) {
        //     array_map('unlink', glob(public_path($this->uploadPath).'/*.*'));
        //     rmdir(public_path($this->uploadPath));
        // }

    }
}; 