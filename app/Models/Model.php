<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Mod;
use App\Traits\PreventDemoModeChanges;

use App;

class Model extends Mod
{
    use PreventDemoModeChanges;

    protected $fillable = ['name', 'slug', 'brand_id'];
    

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }
}
