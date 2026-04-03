<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ClienteController extends Controller
{
    /**
     * Display a listing of clientes.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Cliente::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('cedula', 'like', "%{$search}%")
                  ->orWhere('correo', 'like', "%{$search}%");
            });
        }

        $clientes = $query->orderBy('nombre')->paginate(15);

        if ($request->expectsJson()) {
            return response()->json(['data' => $clientes]);
        }

        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new cliente.
     */
    public function create(): View
    {
        return view('admin.clientes.create');
    }

    /**
     * Display the specified cliente.
     */
    public function show(Request $request, int $cedula): View|JsonResponse
    {
        $cliente = Cliente::where('cedula', $cedula)->with('citas.masajistaRelation', 'citas.servicios')->firstOrFail();

        if ($request->expectsJson()) {
            return response()->json(['data' => $cliente]);
        }

        return view('admin.clientes.show', compact('cliente'));
    }

    /**
     * Store a newly created cliente.
     */
    public function store(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'cedula'   => 'required|integer|unique:clientes,cedula',
            'nombre'   => 'required|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'correo'   => 'nullable|email|max:255',
        ]);

        $cliente = Cliente::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $cliente], 201);
        }

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Update the specified cliente.
     */
    public function update(Request $request, int $cedula): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $cliente = Cliente::where('cedula', $cedula)->firstOrFail();

        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'correo'   => 'nullable|email|max:255',
        ]);

        $cliente->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $cliente]);
        }

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified cliente.
     */
    public function destroy(Request $request, int $cedula): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $cliente = Cliente::where('cedula', $cedula)->firstOrFail();
        $cliente->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Cliente eliminado.']);
        }

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }

    /**
     * Search clientes by name or cedula (API).
     */
    public function search(Request $request): JsonResponse
    {
        $search = $request->input('q', '');
        $clientes = Cliente::where('nombre', 'like', "%{$search}%")
            ->orWhere('cedula', 'like', "%{$search}%")
            ->limit(10)
            ->get();

        return response()->json(['data' => $clientes]);
    }

    /**
     * Get citas for a specific cliente (API).
     */
    public function citasPorCliente(int $cedula): JsonResponse
    {
        $cliente = Cliente::where('cedula', $cedula)->firstOrFail();
        $citas = $cliente->citas()->with('masajistaRelation', 'servicios')->orderBy('fecha', 'desc')->get();

        return response()->json(['data' => $citas]);
    }
}
