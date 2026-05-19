<?php
namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends BaseModel
{
    
    protected $fillable = [
        "name",
        "email",
        "phone",
        "address",
        "number",
        "restaurant_id",
        "is_active"
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
