<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Masajista;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CitaController extends Controller
{
    /**
     * Display a listing of citas with filters.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Cita::with('cliente', 'masajistaRelation', 'servicios');

        // Filter by estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Filter by fecha range
        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->input('fecha_desde'));
        }
        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->input('fecha_hasta'));
        }

        // Filter by masajista
        if ($request->filled('masajista')) {
            $query->where('masajista', $request->input('masajista'));
        }

        // Search by cliente name or cedula
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('cliente', function ($cq) use ($search) {
                    $cq->where('nombre', 'like', "%{$search}%")
                       ->orWhere('cedula', 'like', "%{$search}%");
                })
                ->orWhereHas('masajistaRelation', function ($mq) use ($search) {
                    $mq->where('nombre_masajista', 'like', "%{$search}%");
                });
            });
        }

        $citas = $query->orderBy('fecha', 'desc')->paginate(15);

        if ($request->expectsJson()) {
            return response()->json(['data' => $citas]);
        }

        $masajistas = Masajista::orderBy('nombre_masajista')->get();
        return view('admin.citas.index', compact('citas', 'masajistas'));
    }

    /**
     * Show the form for creating a new cita.
     */
    public function create(): View
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $masajistas = Masajista::with('servicios')->orderBy('nombre_masajista')->get();
        $servicios = Servicio::orderBy('nombre_servicio')->get();

        return view('admin.citas.create', compact('clientes', 'masajistas', 'servicios'));
    }

    /**
     * Display the specified cita.
     */
    public function show(Request $request, int $id_cita): View|JsonResponse
    {
        $cita = Cita::where('id_cita', $id_cita)
            ->with('cliente', 'masajistaRelation', 'servicios')
            ->firstOrFail();

        if ($request->expectsJson()) {
            return response()->json(['data' => $cita]);
        }

        return view('admin.citas.show', compact('cita'));
    }

    /**
     * Store a newly created cita.
     */
    public function store(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'id_cita'                  => 'nullable|integer|unique:citas,id_cita',
            'fecha'                    => 'required|date|after:now',
            'id_cliente'               => 'required|integer|exists:clientes,cedula',
            'masajista'                => 'required|integer|exists:masajistas,cedula',
            'nota'                     => 'nullable|string',
            'estado'                   => 'nullable|in:pendiente,confirmada,cancelada,finalizada',
            'habitacion'               => 'nullable|integer',
            'servicios'                => 'required|array|min:1',
            'servicios.*.id_servicio'  => 'required|exists:servicios,id_servicio',
            'servicios.*.duracion'     => 'nullable|integer|min:1',
        ]);

        // Generate id_cita if not provided
        if (empty($validated['id_cita'])) {
            $validated['id_cita'] = (Cita::max('id_cita') ?? 0) + 1;
        }

        $validated['estado'] = $validated['estado'] ?? 'pendiente';

        $cita = Cita::create([
            'id_cita'    => $validated['id_cita'],
            'fecha'      => $validated['fecha'],
            'id_cliente' => $validated['id_cliente'],
            'masajista'  => $validated['masajista'],
            'nota'       => $validated['nota'] ?? null,
            'estado'     => $validated['estado'],
            'habitacion' => $validated['habitacion'] ?? null,
        ]);

        // Attach servicios with duracion
        $serviciosData = [];
        foreach ($validated['servicios'] as $srv) {
            $serviciosData[$srv['id_servicio']] = ['duracion' => $srv['duracion'] ?? null];
        }
        $cita->servicios()->attach($serviciosData);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'id_cita' => $cita->id_cita,
                'estado'  => $cita->estado,
            ], 201);
        }

        return redirect()->route('admin.citas.index')->with('success', 'Cita creada exitosamente.');
    }

    /**
     * Show the form for editing the specified cita.
     */
    public function edit(int $id_cita): View
    {
        $cita = Cita::where('id_cita', $id_cita)->with('servicios')->firstOrFail();
        $clientes = Cliente::orderBy('nombre')->get();
        $masajistas = Masajista::with('servicios')->orderBy('nombre_masajista')->get();
        $servicios = Servicio::orderBy('nombre_servicio')->get();

        return view('admin.citas.edit', compact('cita', 'clientes', 'masajistas', 'servicios'));
    }

    /**
     * Update the specified cita.
     */
    public function update(Request $request, int $id_cita): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $cita = Cita::where('id_cita', $id_cita)->firstOrFail();

        $validated = $request->validate([
            'fecha'                    => 'sometimes|required|date',
            'id_cliente'               => 'sometimes|required|integer|exists:clientes,cedula',
            'masajista'                => 'sometimes|required|integer|exists:masajistas,cedula',
            'nota'                     => 'nullable|string',
            'estado'                   => 'nullable|in:pendiente,confirmada,cancelada,finalizada',
            'habitacion'               => 'nullable|integer',
            'servicios'                => 'sometimes|required|array|min:1',
            'servicios.*.id_servicio'  => 'required_with:servicios|exists:servicios,id_servicio',
            'servicios.*.duracion'     => 'nullable|integer|min:1',
        ]);

        $cita->update(collect($validated)->except('servicios')->toArray());

        if (isset($validated['servicios'])) {
            $serviciosData = [];
            foreach ($validated['servicios'] as $srv) {
                $serviciosData[$srv['id_servicio']] = ['duracion' => $srv['duracion'] ?? null];
            }
            $cita->servicios()->sync($serviciosData);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $cita->load('servicios')]);
        }

        return redirect()->route('admin.citas.index')->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Cancel a cita.
     */
    public function cancel(Request $request, int $id_cita): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $cita = Cita::where('id_cita', $id_cita)->firstOrFail();
        $cita->update(['estado' => 'cancelada']);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'estado' => 'cancelada']);
        }

        return redirect()->route('admin.citas.index')->with('success', 'Cita cancelada.');
    }

    /**
     * Confirm a cita.
     */
    public function confirm(Request $request, int $id_cita): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $cita = Cita::where('id_cita', $id_cita)->firstOrFail();
        $cita->update(['estado' => 'confirmada']);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'estado' => 'confirmada']);
        }

        return redirect()->route('admin.citas.index')->with('success', 'Cita confirmada.');
    }

    /**
     * Finalize a cita.
     */
    public function finalize(Request $request, int $id_cita): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $cita = Cita::where('id_cita', $id_cita)->firstOrFail();
        $cita->update(['estado' => 'finalizada']);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'estado' => 'finalizada']);
        }

        return redirect()->route('admin.citas.index')->with('success', 'Cita finalizada.');
    }

    /**
     * Remove the specified cita.
     */
    public function destroy(Request $request, int $id_cita): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $cita = Cita::where('id_cita', $id_cita)->firstOrFail();
        $cita->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Cita eliminada.']);
        }

        return redirect()->route('admin.citas.index')->with('success', 'Cita eliminada exitosamente.');
    }
}
