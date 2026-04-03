<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Masajista;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm(): View
    {
        return view('admin.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validate([
            'usuario'    => 'required|string',
            'contrasena' => 'required|string',
        ]);

        $admin = Admin::where('usuario', $credentials['usuario'])->first();

        if ($admin && Hash::check($credentials['contrasena'], $admin->contrasena)) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Login exitoso.']);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Credenciales incorrectas.'], 401);
        }

        return back()->withErrors([
            'usuario' => 'Las credenciales proporcionadas son incorrectas.',
        ])->onlyInput('usuario');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Show admin dashboard.
     */
    public function dashboard(): View
    {
        $totalCitas = Cita::count();
        $citasPendientes = Cita::where('estado', 'pendiente')->count();
        $citasConfirmadas = Cita::where('estado', 'confirmada')->count();
        $citasHoy = Cita::whereDate('fecha', today())->count();
        $totalClientes = Cliente::count();
        $totalMasajistas = Masajista::count();
        $totalServicios = Servicio::count();

        $citasRecientes = Cita::with('cliente', 'masajistaRelation', 'servicios')
            ->orderBy('fecha', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalCitas',
            'citasPendientes',
            'citasConfirmadas',
            'citasHoy',
            'totalClientes',
            'totalMasajistas',
            'totalServicios',
            'citasRecientes',
        ));
    }

    /**
     * List all admins.
     */
    public function index(): View
    {
        $admins = Admin::orderBy('usuario')->get();
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Store a new admin.
     */
    public function store(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'usuario'    => 'required|string|max:255|unique:admin,usuario',
            'contrasena' => 'required|string|min:6|confirmed',
        ]);

        $admin = Admin::create([
            'usuario'    => $validated['usuario'],
            'contrasena' => $validated['contrasena'],
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'data' => $admin], 201);
        }

        return redirect()->route('admin.admins.index')->with('success', 'Administrador creado exitosamente.');
    }

    /**
     * Remove an admin.
     */
    public function destroy(Request $request, int $id_admin): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $admin = Admin::findOrFail($id_admin);

        // Prevent deleting self
        if (Auth::guard('admin')->id() === $admin->id_admin) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'No puedes eliminarte a ti mismo.'], 403);
            }
            return back()->withErrors(['error' => 'No puedes eliminarte a ti mismo.']);
        }

        $admin->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Administrador eliminado.']);
        }

        return redirect()->route('admin.admins.index')->with('success', 'Administrador eliminado.');
    }
}
