<?php

namespace App\Livewire\Kasir;

use App\Models\Pembayaran;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Closing extends Component
{
    public $tanggal;
    
    public function mount()
    {
        $this->tanggal = date('Y-m-d');
    }

    public function render()
    {
        $transactions = Pembayaran::with('pasien')
            ->whereDate('created_at', $this->tanggal)
            ->where('status', 'Lunas')
            ->get();

        $totalTunai = $transactions->where('metode_pembayaran', 'Tunai')->sum('jumlah_bayar');
        $totalNonTunai = $transactions->where('metode_pembayaran', '!=', 'Tunai')->sum('jumlah_bayar');
        $grandTotal = $transactions->sum('jumlah_bayar');

        return view('livewire.kasir.closing', [
            'transactions' => $transactions,
            'totalTunai' => $totalTunai,
            'totalNonTunai' => $totalNonTunai,
            'grandTotal' => $grandTotal
        ])->layout('layouts.app', ['header' => 'Laporan Harian Kasir (Closing)']);
    }
}
