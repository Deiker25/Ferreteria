<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *EL GET
     */
    public function index()
    {
        $productos = Producto::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => ProductoResource::collection($productos),
            'pagination' => [
                'total'         => $productos->total(),
                'per_page'      => $productos->perPage(),
                'current_page'  => $productos->currentPage(),
                'last_page'     => $productos->lastPage(),
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validados = $request->validate([
        //     'codigo_barra' => 'required|string|unique:productos,codigo_barra|max:30',
        //     'nombre' => 'required|string|max:100',
        //     'precio_venta' => 'required|numeric|min:0.01',
        //     'stock' => 'required|integer|min:0',
        //     'categoria_id' => 'required|exists:categorias,id',
        // ]);

        $validados = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
        ]);

        $producto = Producto::create($validados);

        return response()->json([
            'status' => 'success',
            'message' => 'Producto creado exitosamente',
            'data' => new ProductoResource($producto)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new ProductoResource($producto)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $validados = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
        ]);

        $producto->update($validados);

        return response()->json([
            'status' => 'success',
            'message' => 'Producto actualizado exitosamente',
            'data' => new ProductoResource($producto)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status' => 'error',
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Producto eliminado exitosamente'
        ], 200);
    }
}
