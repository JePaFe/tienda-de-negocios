<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sku',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
