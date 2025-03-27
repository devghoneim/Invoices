<?php

namespace App\Models;

use App\Models\section;
use Illuminate\Database\Eloquent\Model;

class invoice_details extends Model
{
    protected $guarded =[] ;

    public function section()
    {
        return $this->belongsTo(section::class);
    }

}
