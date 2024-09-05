<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'qty',
        'price',
        'image',
    ];

    protected $casts = [
        'qty' => 'integer',
        'price' => 'integer',
        'image' => 'string',
    ];

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->image);
    }
}