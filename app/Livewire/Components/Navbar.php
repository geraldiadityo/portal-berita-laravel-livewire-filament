<?php

namespace App\Livewire\Components; // Perhatikan namespace-nya

use App\Repositories\CategoryRepostitory;
use Livewire\Component;

class Navbar extends Component
{
    public function render(CategoryRepostitory $repo)
    {
        // Pastikan file view ada di: resources/views/livewire/components/navbar.blade.php
        return view('livewire.components.navbar', [
            'categories' => $repo->getAll()
        ]);
    }
}
