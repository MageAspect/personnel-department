<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;


class AuthMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function render(): View
    {
        return view(
            'components.auth-menu',
            array('currentRouteIsLogin' => request()->routeIs('auth.login'))
        );
    }
}
