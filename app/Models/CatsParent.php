<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatsParent extends Model
{
    use HasFactory;

    protected $fillable = ['kitten_id', 'mother_id', 'father_id'];

    public function kitten()
    {
        return $this->BelongsTo(Cat::class, 'kitten_id');
    }

    public function mother()
    {
        return $this->BelongsTo(Cat::class, 'mother_id');
    }
    public function father()
    {
        return $this->BelongsTo(Cat::class, 'father_id');
    }

}
