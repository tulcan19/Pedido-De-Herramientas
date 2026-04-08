<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-10 text-left">
        <h2 class="text-4xl font-bold text-white tracking-tight mb-3">Inicia Sesión</h2>
        <p class="text-gray-400 text-lg font-light">Bienvenido de nuevo. Accede a la plataforma de gestión del taller.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Cédula -->
        <div>
            <label for="cedula" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider mb-2">Cédula de Identidad</label>
            <input id="cedula" class="block w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none" 
                   type="text" name="cedula" value="{{ old('cedula') }}" required autofocus placeholder="0000000000" maxlength="10" />
            <x-input-error :messages="$errors->get('cedula')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider">Contraseña</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-gray-500 hover:text-corporate-gold transition-colors" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <input id="password" class="block w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none" 
                   type="password" name="password" required placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded w-5 h-5 border-white/20 bg-white/5 text-corporate-gold focus:ring-corporate-gold transition-all" name="remember">
            <span class="ms-3 text-sm text-gray-400">{{ __('Mantener sesión iniciada') }}</span>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full group relative flex items-center justify-center gap-3 bg-corporate-gold text-[#16213e] font-black py-4 px-8 rounded-xl shadow-[0_10px_30px_rgba(204,167,91,0.3)] hover:shadow-[0_15px_40px_rgba(204,167,91,0.5)] transition-all duration-300 hover:-translate-y-1 active:scale-95 text-lg uppercase tracking-widest">
                <span>Ingresar al Sistema</span>
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </div>
    </form>
</x-guest-layout>
