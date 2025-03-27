<?php

namespace App\Models;

use App\Models\invoice;
use App\Models\product;
use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    protected $fillable = [
        'section_name',
        'description',
        'created_by',
    ];

    
    public function products()
    {
       return $this->hasMany(product::class);
    }

  
}
