<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
    ];

    public function pcbuilds()
    {
        return $this->belongsToMany(Pcbuild::class, 'build_part')
                    ->withPivot('custom_price', 'quantity')
                    ->withTimestamps();
    }
}
