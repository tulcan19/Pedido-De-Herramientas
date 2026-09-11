<nav x-data="{ open: false }" class="bg-white border-b border-gray-100" style="position: sticky; top: 0; z-index: 50;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 w-full">
            <div class="flex items-center min-w-0">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-corporate-blue" />
                    </a>
                </div>

                <!-- Navigation Links (solo visibles en pantallas grandes) -->
                <div class="hidden space-x-6 md:-my-px md:ms-8 md:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Inicio') }}
                    </x-nav-link>
                    @unless(Auth::user()->esDocente())
                        <x-nav-link :href="route('herramientas.index')" :active="request()->routeIs('herramientas.*')">
                            {{ __('Herramientas') }}
                        </x-nav-link>
                    @endunless
                    @if(Auth::user()->esAdmin() || Auth::user()->esDocente())
                        <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.index')">
                            {{ __('Estudiantes') }}
                        </x-nav-link>

                        @if(Auth::user()->esAdmin())
                            <x-nav-link :href="route('docentes.index')" :active="request()->routeIs('docentes.*')">
                                {{ __('Docentes') }}
                            </x-nav-link>
                        @endif

                        <x-nav-link :href="route('reportes.bitacora')" :active="request()->routeIs('reportes.bitacora')">
                            {{ __('Bitácora') }}
                        </x-nav-link>

                        @if(Auth::user()->esAdmin())
                            <x-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.index')">
                                {{ __('Reportes') }}
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Right Side (User) — solo en pantallas >= md -->
            <div class="hidden md:flex md:items-center md:ms-6 gap-3 shrink-0">
                <a href="{{ route('notificaciones.index') }}" class="relative inline-flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out {{ request()->routeIs('notificaciones.*') ? 'text-[#cca75b] bg-[#fdf8ee]' : '' }}" title="Notificaciones">
                    <span class="material-symbols-outlined" style="font-size: 1.4rem;">notifications</span>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[9px] font-black leading-none text-white bg-red-600 border border-white rounded-full shadow-sm">{{ Auth::user()->unreadNotifications->count() }}</span>
                    @endif
                </a>

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="truncate max-w-[160px]">{{ Auth::user()->nombre }}</div>

                            <div class="ms-1 shrink-0">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (visible en pantallas < md) -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (visible en pantallas < md) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            @unless(Auth::user()->esDocente())
                <x-responsive-nav-link :href="route('herramientas.index')" :active="request()->routeIs('herramientas.*')">
                    {{ __('Herramientas') }}
                </x-responsive-nav-link>
            @endunless
            @if(Auth::user()->esAdmin() || Auth::user()->esDocente())
                <x-responsive-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.index')">
                    {{ __('Estudiantes') }}
                </x-responsive-nav-link>
                @if(Auth::user()->esAdmin())
                    <x-responsive-nav-link :href="route('docentes.index')" :active="request()->routeIs('docentes.*')">
                        {{ __('Docentes') }}
                    </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('reportes.bitacora')" :active="request()->routeIs('reportes.bitacora')">
                    {{ __('Bitácora') }}
                </x-responsive-nav-link>
                @if(Auth::user()->esAdmin())
                    <x-responsive-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.index')">
                        {{ __('Reportes') }}
                    </x-responsive-nav-link>
                @endif
            @endif
            <x-responsive-nav-link :href="route('notificaciones.index')" :active="request()->routeIs('notificaciones.*')">
                {{ __('Notificaciones') }}
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-[10px] font-black leading-none text-white bg-red-600 rounded-full shadow-sm">{{ Auth::user()->unreadNotifications->count() }}</span>
                @endif
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->nombre }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->cedula }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
