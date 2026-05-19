<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends \Spatie\Permission\Models\Permission
{

    protected $casts = [
        "show_in_menu" => "boolean"
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function routeGroup(): BelongsTo
    {
            return $this->belongsTo(RouteGroup::class, 'route_group_id');
    }
}