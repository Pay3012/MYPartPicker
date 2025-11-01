<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pcbuild extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'build_part')
                    ->withPivot('custom_price', 'quantity')
                    ->withTimestamps();
    }
}
