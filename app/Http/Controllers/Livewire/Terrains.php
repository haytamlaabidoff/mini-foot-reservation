<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Terrain;

class Terrains extends Component
{
    public $name;
    public $price_per_hour;
    public $terrains; // هذا public مهم جدًا

    public function mount()
    {
        $this->loadTerrains();
    }

    public function loadTerrains()
    {
        $this->terrains = Terrain::all(); // هنا يتم تحميل البيانات
    }

    public function addTerrain()
    {
        $this->validate([
            'name' => 'required|string',
            'price_per_hour' => 'required|numeric|min:0'
        ]);

        Terrain::create([
            'name' => $this->name,
            'price_per_hour' => $this->price_per_hour,
            'status' => true
        ]);

        $this->reset(['name','price_per_hour']);
        $this->loadTerrains();
        session()->flash('message', 'Terrain ajouté avec succès !');
    }

    public function deleteTerrain($id)
    {
        $terrain = Terrain::find($id);
        if ($terrain) {
            $terrain->delete();
            $this->loadTerrains();
            session()->flash('message', 'Terrain supprimé !');
        }
    }

    public function render()
    {
        return view('livewire.terrains');
    }
}