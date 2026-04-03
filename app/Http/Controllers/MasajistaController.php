<?php

namespace App\Http\Controllers;

use App\Models\Masajista;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MasajistaController extends Controller
{
    /**
     * Display a listing of masajistas.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Masajista::with('servicios', 'citas');
        $servicios = \App\Models\Servicio::orderBy('nombre_servicio')->get();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre_masajista', 'like', "%{$search}%")
                  ->orWhere('cedula', 'like', "%{$search}%");
            });
        }

        $masajistas = $query->orderBy('nombre_masajista')->get();

        if ($request->expectsJson()) {
            return response()->json(['data' => $masajistas]);
        }

        return view('admin.masajistas.index', compact('masajistas', 'servicios'));
    }

    /**
     * Show the form for creating a new masajista.
     */
    public function create(): View
    {
        $servicios = \App\Models\Servicio::orderBy('nombre_servicio')->get();
        return view('admin.masajistas.create', compact('servicios'));
    }

    /**
     * Display the specified masajista.
     */
    public function show(Request $request, int $cedula): View|JsonResponse
    {
        $masajista = Masajista::where('cedula', $cedula)
            ->with('servicios', 'citas.cliente', 'citas.servicios')
            ->firstOrFail();

        if ($request->expectsJson()) {
            return response()->json(['data' => $masajista]);
        }

        return view('admin.masajistas.show', compact('masajista'));
    }

    /**
     * Store a newly created masajista.
     */
    public function store(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'cedula'           => 'required|integer|unique:masajistas,cedula',
            'nombre_masajista' => 'required|string|max:255',
            'telefono'         => 'nullable|string|max:15',
        ]);

        $masajista = Masajista::create($validated);

        // Attach servicios if provided
        if ($request->has('servicios')) {
            $serviciosData = [];
            foreach ($request->input('servicios', []) as $srv) {
                if (is_array($srv)) {
                    $serviciosData[$srv['id_servicio']] = ['comision' => $srv['comision'] ?? null];
                } else {
                    $serviciosData[$srv] = ['comision' => null];
                }
            }
            $masajista->servicios()->sync($serviciosData);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $masajista->load('servicios')], 201);
        }

        return redirect()->route('admin.masajistas.index')->with('success', 'Masajista creado exitosamente.');
    }

    /**
     * Update the specified masajista.
     */
    public function update(Request $request, int $cedula): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $masajista = Masajista::where('cedula', $cedula)->firstOrFail();

        $validated = $request->validate([
            'nombre_masajista' => 'required|string|max:255',
            'telefono'         => 'nullable|string|max:15',
        ]);

        $masajista->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $masajista]);
        }

        return redirect()->route('admin.masajistas.index')->with('success', 'Masajista actualizado exitosamente.');
    }

    /**
     * Remove the specified masajista.
     */
    public function destroy(Request $request, int $cedula): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $masajista = Masajista::where('cedula', $cedula)->firstOrFail();
        $masajista->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Masajista eliminado.']);
        }

        return redirect()->route('admin.masajistas.index')->with('success', 'Masajista eliminado exitosamente.');
    }

    /**
     * Attach or sync servicios to a masajista with comision.
     */
    public function attachServicios(Request $request, int $cedula): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $masajista = Masajista::where('cedula', $cedula)->firstOrFail();

        $validated = $request->validate([
            'servicios'               => 'required|array',
            'servicios.*.id_servicio' => 'required|exists:servicios,id_servicio',
            'servicios.*.comision'    => 'nullable|integer|min:0',
        ]);

        $syncData = [];
        foreach ($validated['servicios'] as $srv) {
            $syncData[$srv['id_servicio']] = ['comision' => $srv['comision'] ?? null];
        }

        $masajista->servicios()->sync($syncData);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $masajista->load('servicios'),
            ]);
        }

        return redirect()->route('admin.masajistas.show', $cedula)->with('success', 'Servicios actualizados.');
    }
}
