<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['qty', 'total', 'name', 'email', 'phone', 'address', 'note'];

    public function product()
    {
        return $this->hasMany(orderProduct::class);
    }
}
