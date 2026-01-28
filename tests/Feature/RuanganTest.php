<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ruangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RuanganTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_ruangan_index()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->get(route('ruangan.index'))
            ->assertStatus(200)
            ->assertSee('Manajemen Ruangan');
    }

    public function test_admin_can_create_ruangan()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\Ruangan\Create::class)
            ->set('nama_ruangan', 'Ruang Mawar')
            ->set('kode_ruangan', 'R-001')
            ->set('lokasi_gedung', 'Gedung A')
            ->set('penanggung_jawab', 'Dr. Budi')
            ->call('save')
            ->assertRedirect(route('ruangan.index'));

        $this->assertDatabaseHas('ruangans', [
            'nama_ruangan' => 'Ruang Mawar',
            'kode_ruangan' => 'R-001',
        ]);
    }

    public function test_validation_works()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\Ruangan\Create::class)
            ->set('nama_ruangan', '') // Empty
            ->call('save')
            ->assertHasErrors(['nama_ruangan' => 'required']);
    }

    public function test_can_update_ruangan()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $ruangan = Ruangan::create([
            'nama_ruangan' => 'Old Room', 
            'kode_ruangan' => 'OLD-001'
        ]);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\Ruangan\Edit::class, ['ruangan' => $ruangan])
            ->assertSet('nama_ruangan', 'Old Room')
            ->set('nama_ruangan', 'New Room')
            ->call('save')
            ->assertRedirect(route('ruangan.index'));

        $this->assertDatabaseHas('ruangans', [
            'id' => $ruangan->id,
            'nama_ruangan' => 'New Room',
        ]);
    }

    public function test_can_delete_ruangan()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $ruangan = Ruangan::create([
            'nama_ruangan' => 'To Delete', 
            'kode_ruangan' => 'DEL-001'
        ]);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\Ruangan\Index::class)
            ->call('confirmDelete', $ruangan->id)
            ->call('delete');

        $this->assertDatabaseMissing('ruangans', [
            'id' => $ruangan->id,
        ]);
    }
}