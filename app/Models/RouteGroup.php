<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RouteGroup extends \Illuminate\Database\Eloquent\Model
{
    

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'route_group_id')
            ->whereNotIn('permissions.id', function($query){
                $query->from('model_has_permissions')->select('permission_id')->where('granted', false);
            });
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}