<?php

namespace App\Models;

use App\Foundation\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Alert extends BaseModel
{
    const ALERTABLE_LABELS = [
        Product::class => 'Estoque',
        Order::class   => 'Pedido',
    ];
    protected $fillable = [
        "title",
        "description",
        "severity",
        "is_resolved",
        "resolved_at",
        "resolved_by",
        "alertable_type",
        "alertable_id",
        'restaurant_id',
        'alerted_by'
    ];

    public function alertable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getAlertableLabelAttribute(): string
    {
        return self::ALERTABLE_LABELS[$this->alertable_type] ?? 'outro';
    }
}
