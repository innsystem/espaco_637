<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'status', 'sort_order', 'category_id'];

    public function images()
    {
        return $this->hasMany(PortfolioImage::class)->orderBy('sort_order', 'asc');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFeaturedImageAttribute()
    {
        $featuredImage = $this->images()->where('featured', 1)->first();
        if ($featuredImage) {
            return asset('storage/' . $featuredImage->image_path);
        }

        return asset('galerias/avatares/sem_foto.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
