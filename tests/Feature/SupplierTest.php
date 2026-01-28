<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_supplier_index()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->get(route('supplier.index'))
            ->assertStatus(200)
            ->assertSee('Daftar Supplier');
    }

    public function test_admin_can_create_supplier()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\Supplier\Index::class)
            ->set('nama_supplier', 'PT. Obat Sehat')
            ->set('kode_supplier', 'SUP-001')
            ->set('kontak_person', 'Budi')
            ->set('telepon', '08123456789')
            ->set('email', 'budi@obat.com')
            ->set('alamat', 'Jl. Sehat No. 1')
            ->call('store')
            ->assertDispatched('notify');

        $this->assertDatabaseHas('suppliers', [
            'nama_supplier' => 'PT. Obat Sehat',
            'kode_supplier' => 'SUP-001',
            'email' => 'budi@obat.com',
        ]);
    }

    public function test_validation_works()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\Supplier\Index::class)
            ->set('nama_supplier', '') // Empty
            ->call('store')
            ->assertHasErrors(['nama_supplier' => 'required']);
    }

    public function test_can_update_supplier()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $supplier = Supplier::create([
            'nama_supplier' => 'Old Name', 
            'kode_supplier' => 'OLD-001'
        ]);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\Supplier\Index::class)
            ->call('edit', $supplier)
            ->assertSet('nama_supplier', 'Old Name')
            ->set('nama_supplier', 'New Name')
            ->call('store');

        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'nama_supplier' => 'New Name',
        ]);
    }

    public function test_can_delete_supplier()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $supplier = Supplier::create([
            'nama_supplier' => 'To Delete', 
            'kode_supplier' => 'DEL-001'
        ]);

        $this->actingAs($user);

        Livewire::test(\App\Livewire\Supplier\Index::class)
            ->call('confirmDelete', $supplier->id)
            ->call('delete');

        $this->assertDatabaseMissing('suppliers', [
            'id' => $supplier->id,
        ]);
    }
}
