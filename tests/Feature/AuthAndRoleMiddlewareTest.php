<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthAndRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_is_redirected_to_login_when_accessing_protected_routes(): void
    {
        $responseAdmin = $this->get('/admin/dashboard');
        $responseAdmin->assertRedirect(route('login'));

        $responsePeserta = $this->get('/peserta/dashboard');
        $responsePeserta->assertRedirect(route('login'));
    }

    public function test_peserta_cannot_access_admin_routes(): void
    {
        $peserta = User::where('role', 'peserta')->first();

        $response = $this->actingAs($peserta)->get('/admin/dashboard');

        // Should be blocked and redirected to peserta dashboard
        $response->assertRedirect(route('peserta.dashboard'));
        $response->assertSessionHas('error');
    }

    public function test_admin_cannot_access_peserta_routes(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/peserta/dashboard');

        // Should be redirected to admin dashboard
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Administrator');
    }

    public function test_peserta_can_access_peserta_dashboard(): void
    {
        $peserta = User::where('role', 'peserta')->first();

        $response = $this->actingAs($peserta)->get('/peserta/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Saldo Tabungan Poin Limbah');
    }
}
