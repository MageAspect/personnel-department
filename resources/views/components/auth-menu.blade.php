<div>
    @if (!$currentRouteIsLogin)
        <a href="{{ route('auth.login') }}"
           class="p-2 rounded transition
                text-sm text-gray-light
                hover:bg-oceanic-light hover:text-blue">
            вход в систему
        </a>
    @endif
</div>
