<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'producto_id', 'cantidad'])]
class CarritoItem extends Model
{
    protected $casts = [
        'cantidad' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function subtotal(): float
    {
        return (float) $this->producto->precio * $this->cantidad;
    }
}
