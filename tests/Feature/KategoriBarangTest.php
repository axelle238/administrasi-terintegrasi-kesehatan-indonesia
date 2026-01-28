<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\KategoriBarang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class KategoriBarangTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_kategori_index()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->get(route('kategori-barang.index'))
            ->assertStatus(200);
    }

    public function test_admin_can_create_kategori()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\KategoriBarang\Create::class)
            ->set('nama_kategori', 'Elektronik')
            ->set('keterangan', 'Barang elektronik kantor')
            ->call('save')
            ->assertDispatched('notify')
            ->assertRedirect(route('kategori-barang.index'));

        $this->assertDatabaseHas('kategori_barangs', [
            'nama_kategori' => 'Elektronik',
        ]);
    }

    public function test_admin_can_update_kategori()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $kategori = KategoriBarang::create(['nama_kategori' => 'Old Cat']);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\KategoriBarang\Edit::class, ['kategoriBarang' => $kategori])
            ->assertSet('nama_kategori', 'Old Cat')
            ->set('nama_kategori', 'New Cat')
            ->call('save')
            ->assertDispatched('notify')
            ->assertRedirect(route('kategori-barang.index'));

        $this->assertDatabaseHas('kategori_barangs', [
            'id' => $kategori->id,
            'nama_kategori' => 'New Cat',
        ]);
    }

    public function test_admin_can_delete_kategori()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $kategori = KategoriBarang::create(['nama_kategori' => 'To Delete']);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\KategoriBarang\Index::class)
            ->call('delete', $kategori->id)
            ->assertDispatched('notify'); // Success message

        $this->assertDatabaseMissing('kategori_barangs', [
            'id' => $kategori->id,
        ]);
    }
}
