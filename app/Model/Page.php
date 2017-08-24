<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    //protected $table = 'pages';
    public function hasManyComments()
    {
        return $this->hasMany('App\Model\Comment', 'page_id', 'id');
    }

    
}
