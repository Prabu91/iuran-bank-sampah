<div>
    <!-- Sidebar -->
    <aside class="w-64 h-full bg-primary border-r border-gray-200">
        <div class="p-4 flex items-center justify-center border-b border-gray-100">
            <a href="{{ route('dashboard') }}">
                <x-side-logo />
            </a>
        </div>

        <nav class="my-4 flex flex-col space-y-2 px-4">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>

            @if(Auth::user()->role === 'admin')
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('Manajemen User') }}
                </x-nav-link>
                <x-nav-link :href="route('peserta.index')" :active="request()->routeIs('peserta.*')">
                    {{ __('Manajemen Peserta') }}
                </x-nav-link>
            @endif

            @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                <x-nav-link :href="route('unitbsb.index')" :active="request()->routeIs('penabung.*')">
                    {{ __('Unit BSB') }}
                </x-nav-link>
                <x-nav-link :href="route('setoran.index')" :active="request()->routeIs('setoran.*')">
                    {{ __('Setoran') }}
                </x-nav-link>
                <x-nav-link :href="route('donasi.index')" :active="request()->routeIs('donasi.*')">
                    {{ __('Bayar Iuran') }}
                </x-nav-link>
            @endif
        </nav>

        <!-- Logout & Profile -->
        <div class="mt-auto px-4 py-4 border-t border-gray-200">
            <div class="text-sm text-text-light mb-2">
                {{ Auth::user()->name }}<br>
                <span class="text-xs">{{ Auth::user()->email }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-nav-link>
            </form>
        </div>
    </aside>

</div>
