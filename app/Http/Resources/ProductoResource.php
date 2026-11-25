<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // return [
        //     'id' => $this->id,
        //     'codigo_barra' => $this->codigo_barra,
        //     'nombre' => $this->nombre,
        //     'precio_venta' => (float) $this->precio_venta,
        //     'precio_hnl' => 'L. ' . number_format($this->precio_venta, 2),
        //     'stock' => (int) $this->stock,
        //     'disponibilidad' => $this->stock > 0 ? 'Disponible' : 'Agotado',
        //     'categoria_id' => $this->categoria_id,
        //     'fecha_registro' => $this->created_at
        //         ? $this->created_at->format('d/m/Y H:i A')
        //         : null,
        // ];

        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => (float) $this->precio,
            'precio_hnl' => 'L. ' . number_format($this->precio, 2),
            'stock' => (int) $this->stock,
        ];
    }
}