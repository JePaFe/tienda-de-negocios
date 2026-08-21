<?php

namespace App\Http\Requests;

use App\DTO\UpdateProductoDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Rules\ValidSku;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productoId = $this->route('producto')?->id;

        return [
            'sku' => ['sometimes', 'required', 'string', 'max:255', 'unique:productos,sku,' . $productoId . ',id', new ValidSku()],
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|nullable|string',
            'precio' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'categoria_id' => 'sometimes|required|exists:categorias,id',
        ];
    }

     public function toDto(): UpdateProductoDTO
    {
        $validated = $this->validated();

        return new UpdateProductoDTO(
            sku: $validated['sku'] ?? null,
            categoriaId: array_key_exists('categoria_id', $validated)
                ? (int) $validated['categoria_id']
                : null,
            nombre: $validated['nombre'] ?? null,
            descripcion: $validated['descripcion'] ?? null,
            precio: array_key_exists('precio', $validated)
                ? (float) $validated['precio']
                : null,
            stock: array_key_exists('stock', $validated)
                ? (int) $validated['stock']
                : null,
            providedFields: array_keys($validated),
        );
    }
}
