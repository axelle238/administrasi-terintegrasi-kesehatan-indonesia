<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use Livewire\Component;
use Livewire\Attributes\Layout;

class PrintLabelsBulk extends Component
{
    public $ids = [];
    public $barangs = [];

    public function mount()
    {
        $this->ids = explode(',', request()->query('ids', ''));
        if (empty($this->ids)) {
            abort(404, 'No items selected');
        }

        $this->barangs = Barang::whereIn('id', $this->ids)->get();
    }

    #[Layout('layouts.print')]
    public function render()
    {
        return view('livewire.barang.print-labels-bulk');
    }
}
