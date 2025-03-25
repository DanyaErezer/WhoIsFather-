<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'gender', 'age'];

    public function catMom()
    {
        return $this->hasMany(CatsParent::class, 'mother_id');
    }
    public function catFather(){
        return $this->hasMany(CatsParent::class, 'father_id');
    }
    public function catParent(){
        return $this->hasMany(CatsParent::class, 'parent_id');
    }
    public function mother(){
        return $this->hasManyThrough(
            CatsParent::class,
            CatsParent::class,
            'kitten_id',
            'id',
            'id',
            'mother_id');
    }
    public function father(){
        return $this->hasManyThrough(
            CatsParent::class,
            CatsParent::class,
            'kitten_id',
            'id',
            'id',
            'father_id');
    }

}
