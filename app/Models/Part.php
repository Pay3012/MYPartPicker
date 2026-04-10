<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;

class Part extends Model
{
    use HasFactory, HasChildren;

    protected $fillable = [
        'name',
        'category',
        'price',
        'type',
        'specs',
    ];

    protected $casts = [
        'specs' => 'array',
    ];

    protected $childTypes = [
        'part'        => self::class,
        'gpu'         => Parts\Gpu::class,
        'cpu'         => Parts\Cpu::class,
        'ram'         => Parts\Ram::class,
        'motherboard' => Parts\Motherboard::class,
        'psu'         => Parts\Psu::class,
        'storage'     => Parts\Storage::class,
        'cooler'      => Parts\Cooler::class,
        'fan'         => Parts\Fan::class,
    ];

    public function pcbuilds()
    {
        return $this->belongsToMany(Pcbuild::class, 'build_part')
                    ->withPivot('custom_price', 'quantity')
                    ->withTimestamps();
    }
}
