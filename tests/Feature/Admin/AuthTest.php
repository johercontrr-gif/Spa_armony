<?php

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login page is accessible', function () {
    $response = $this->get('/login');
    $response->assertOk();
});

test('admin can login with valid credentials', function () {
    Admin::create([
        'usuario'    => 'testadmin',
        'contrasena' => 'secret123',
    ]);

    $response = $this->post('/login', [
        'usuario'    => 'testadmin',
        'contrasena' => 'secret123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs(Admin::first(), 'admin');
});

test('admin cannot login with invalid credentials', function () {
    Admin::create([
        'usuario'    => 'testadmin',
        'contrasena' => 'secret123',
    ]);

    $response = $this->post('/login', [
        'usuario'    => 'testadmin',
        'contrasena' => 'wrongpassword',
    ]);

    $response->assertRedirect();
    $this->assertGuest('admin');
});

test('dashboard requires authentication', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated admin can access dashboard', function () {
    $admin = Admin::create([
        'usuario'    => 'testadmin',
        'contrasena' => 'secret123',
    ]);

    $response = $this->actingAs($admin, 'admin')->get('/dashboard');
    $response->assertOk();
});

test('admin can logout', function () {
    $admin = Admin::create([
        'usuario'    => 'testadmin',
        'contrasena' => 'secret123',
    ]);

    $this->actingAs($admin, 'admin');
    $response = $this->post('/logout');

    $response->assertRedirect(route('login'));
    $this->assertGuest('admin');
});
