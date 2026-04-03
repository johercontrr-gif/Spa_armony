<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ServicioController extends Controller
{
    /**
     * Display a listing of servicios (public).
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Servicio::query();

        if ($request->filled('search')) {
            $query->where('nombre_servicio', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->input('precio_min'));
        }

        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->input('precio_max'));
        }

        $servicios = $query->orderBy('nombre_servicio')->get();

        if ($request->expectsJson()) {
            return response()->json(['data' => $servicios]);
        }

        // Determine if admin or public view
        if ($request->is('dashboard/*') || $request->is('admin/*')) {
            return view('admin.servicios.index', compact('servicios'));
        }

        return view('servicios', compact('servicios'));
    }

    /**
     * Show the form for creating a new servicio.
     */
    public function create(): View
    {
        return view('admin.servicios.create');
    }

    /**
     * Display the specified servicio.
     */
    public function show(Request $request, int $id_servicio): View|JsonResponse
    {
        $servicio = Servicio::where('id_servicio', $id_servicio)->with('masajistas')->firstOrFail();

        if ($request->expectsJson()) {
            return response()->json(['data' => $servicio]);
        }

        return view('admin.servicios.show', compact('servicio'));
    }

    /**
     * Store a newly created servicio.
     */
    public function store(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'id_servicio'     => 'required|integer|unique:servicios,id_servicio',
            'nombre_servicio' => 'required|string|max:255',
            'precio'          => 'required|integer|min:0',
            'descripcion'     => 'nullable|string|max:255',
        ]);

        $servicio = Servicio::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $servicio], 201);
        }

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio creado exitosamente.');
    }

    /**
     * Update the specified servicio.
     */
    public function update(Request $request, int $id_servicio): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $servicio = Servicio::where('id_servicio', $id_servicio)->firstOrFail();

        $validated = $request->validate([
            'nombre_servicio' => 'required|string|max:255',
            'precio'          => 'required|integer|min:0',
            'descripcion'     => 'nullable|string|max:255',
        ]);

        $servicio->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $servicio]);
        }

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio actualizado exitosamente.');
    }

    /**
     * Remove the specified servicio.
     */
    public function destroy(Request $request, int $id_servicio): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $servicio = Servicio::where('id_servicio', $id_servicio)->firstOrFail();
        $servicio->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Servicio eliminado.']);
        }

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio eliminado exitosamente.');
    }
}
