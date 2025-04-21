<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductCharacteristic;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'status_id',
        'img',
        'price',
        'old_price',
        'hit',
        'sale',
    ];

    public function characteristics()
    {
        return $this->hasMany(ProductCharacteristic::class);
    }


    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }


    public function getImage()
    {
        if (!$this->img) {
            return asset('assets/front/img/no-image.png');
        } else {
            return asset("assets/front/img/{$this->img}");
        }
    }
}
