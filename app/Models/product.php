<?php

namespace App\Models;

use App\Models\section;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable =[
        'product_name',
        'section_id',
        'description'
    ];

    public function section()
    {
      return  $this->belongsTo(section::class);
    }
}
