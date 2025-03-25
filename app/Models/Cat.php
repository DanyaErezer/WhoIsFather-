<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'gender', 'age'];

    public function kittens()
    {
        return $this->hasMany(CatsParent::class, 'mother_id');
    }

    public function fatheredKittens()
    {
        return $this->hasMany(CatsParent::class, 'father_id');
    }

    public function parentsRelation()
    {
        return $this->hasOne(CatsParent::class, 'kitten_id');
    }

    public function mother()
    {
        return $this->hasOneThrough(
            Cat::class,
            CatsParent::class,
            'kitten_id',
            'id',
            'id',
            'mother_id'
        );
    }


    public function father()
    {
        return $this->hasOneThrough(
            Cat::class,
            CatsParent::class,
            'kitten_id',
            'id',
            'id',
            'father_id'
        );
    }

    // Аксессор для удобного получения матери
    public function getMotherAttribute()
    {
        return $this->parentsRelation ? $this->parentsRelation->mother : null;
    }

    // Аксессор для удобного получения отца
    public function getFatherAttribute()
    {
        return $this->parentsRelation ? $this->parentsRelation->father : null;
    }
}
