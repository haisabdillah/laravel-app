<?php

namespace App\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        $navlinks = [
            [
                'name' => 'Dashboard',
                'route' => 'dashboard',
                'icon' => 'fa-gauge',

            ],
            [
                'name' => 'Users',
                'route' => 'users.index',
                'icon' => 'fa-users',
            ],
        ];
        return view('layouts.sidebar',['navlinks' => $navlinks]);
    }
}
