<?php

namespace App\View\Components;

use App\Personnel\Users\UserStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;


class AppSidebar extends Component
{
    private UserStore $userStore;

    public function __construct(UserStore $userStore)
    {
        $this->userStore = $userStore;
    }

    public function render(): View
    {
        return view(
            'components.sidebar',
            array('user' => $this->userStore->findById(Auth::user()->id))
        );
    }
}
