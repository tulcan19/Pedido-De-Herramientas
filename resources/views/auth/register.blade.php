<x-guest-layout>
    <div class="mb-10 text-left">
        <h2 class="text-4xl font-bold text-white tracking-tight mb-3">Registrarse</h2>
        <p class="text-gray-400 text-lg font-light">Crea una cuenta para empezar a gestionar el taller.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6 text-left">
        @csrf

        <!-- Nombre -->
        <div>
            <label for="nombre" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider mb-2">Nombre Completo</label>
            <input id="nombre" class="block w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none" 
                   type="text" name="nombre" :value="old('nombre')" required autofocus placeholder="Nombre del Usuario" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2 text-red-400" />
        </div>

        <!-- Cédula -->
        <div class="mt-4">
            <label for="cedula" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider mb-2">Cédula de Identidad</label>
            <input id="cedula" class="block w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none" 
                   type="text" name="cedula" :value="old('cedula')" required placeholder="0000000000" maxlength="10" />
            <x-input-error :messages="$errors->get('cedula')" class="mt-2 text-red-400" />
        </div>

        <!-- Semestre -->
        <div class="mt-4">
            <label for="semestre" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider mb-2">Semestre Actual</label>
            <select id="semestre" name="semestre" required class="block w-full bg-[#23325b] border border-white/10 rounded-xl px-4 py-4 text-white focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none appearance-none cursor-pointer">
                <option value="" disabled selected>Selecciona tu semestre</option>
                @foreach(range(1, 6) as $i)
                    <option value="{{ $i }}" {{ old('semestre') == $i ? 'selected' : '' }}>{{ $i }}° Semestre</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('semestre')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider mb-2">Contraseña</label>
            <input id="password" class="block w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none" 
                   type="password" name="password" required placeholder="••••••••" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider mb-2">Confirmar Contraseña</label>
            <input id="password_confirmation" class="block w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none" 
                   type="password" name="password_confirmation" required placeholder="••••••••" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <div class="flex flex-col gap-4 mt-8">
            <button type="submit" class="w-full group relative flex items-center justify-center gap-3 bg-corporate-gold text-[#16213e] font-black py-4 px-8 rounded-xl shadow-[0_10px_30px_rgba(204,167,91,0.3)] hover:shadow-[0_15px_40px_rgba(204,167,91,0.5)] transition-all duration-300 hover:-translate-y-1 active:scale-95 text-lg uppercase tracking-widest">
                <span>Registrarse</span>
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">person_add</span>
            </button>

            <a class="text-center text-sm text-gray-500 hover:text-corporate-blue transition-colors underline decoration-gray-300 underline-offset-4" href="{{ route('login') }}">
                ¿Ya estás registrado?
            </a>
        </div>
    </form>
</x-guest-layout>
