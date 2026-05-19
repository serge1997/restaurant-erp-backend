<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    
    public function routeGroupes(): HasMany
    {
        return $this->hasMany(RouteGroup::class);
    }
}
