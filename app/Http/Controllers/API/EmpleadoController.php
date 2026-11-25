<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\EmpleadoResource;
use App\Models\Empleado;


class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => EmpleadoResource::collection($empleados),
            'pagination' => [
                'total'         => $empleados->total(),
                'per_page'      => $empleados->perPage(),
                'current_page'  => $empleados->currentPage(),
                'last_page'     => $empleados->lastPage(),
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validados = $request->validate([
            'identidad' => 'required|string|unique:empleados,identidad|max:15',
            'nombre' => 'required|string|max:100',
            'cargo' => 'required|string|max:50',
            'salario' => 'required|numeric|min:0.01',
            'fecha_ingreso' => 'required|date',
        ]);

        $empleado = Empleado::create($validados);

        return response()->json([
            'status' => 'success',
            'message' => 'Empleado creado exitosamente',
            'data' => new EmpleadoResource($empleado),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'status' => 'error',
                'message' => 'Empleado no encontrado',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new EmpleadoResource($empleado),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'status' => 'error',
                'message' => 'Empleado no encontrado',
            ], 404);
        }

        $validados = $request->validate([
            'identidad' => 'required|string|unique:empleados,identidad,' . $empleado->id . '|max:15',
            'nombre' => 'required|string|max:100',
            'cargo' => 'required|string|max:50',
            'salario' => 'required|numeric|min:0.01',
            'fecha_ingreso' => 'required|date',
        ]);

        $empleado->update($validados);

        return response()->json([
            'status' => 'success',
            'message' => 'Empleado actualizado exitosamente',
            'data' => new EmpleadoResource($empleado),
        ], 200);    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'status' => 'error',
                'message' => 'Empleado no encontrado',
            ], 404);
        }

        $empleado->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Empleado eliminado exitosamente',
        ], 200);
    }
}
