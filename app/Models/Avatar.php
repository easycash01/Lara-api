<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Avatar extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'path',
        'file_name',
        'nome_originale',
        'mime_type',
        'dimensione'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected function formatSize(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $bytes = $attributes['dimensione'];
                if ($bytes === 0 || $bytes === null) return '0 Bytes';

                $k = 1024;
                $sizes = ['Bytes', 'KB', 'MB', 'GB'];
                $i = floor(log($bytes) / log($k));

                return sprintf('%.2f %s', $bytes / pow($k, $i), $sizes[$i]);
            }
        );
    }
} 