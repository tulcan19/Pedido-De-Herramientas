<x-guest-layout>
    <div class="mb-8 text-left animate-fade-in-up">
        <h2 class="text-4xl font-black text-white tracking-tight mb-2">Registrarse</h2>
        <p class="text-gray-400 text-lg font-light leading-relaxed">Únete a la plataforma del <span class="text-corporate-gold font-medium">ISTPET</span> para gestionar herramientas.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5 text-left pb-10">
        @csrf

        <!-- Nombre -->
        <div class="opacity-0 animate-fade-in-up stagger-1">
            <label for="nombre" class="block text-xs font-bold text-corporate-gold uppercase tracking-[0.2em] mb-2 px-1">Nombre Completo</label>
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-corporate-gold transition-colors duration-300">person</span>
                <input id="nombre" class="block w-full bg-white/5 border border-white/10 rounded-2xl pl-12 pr-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold/50 focus:ring-4 focus:ring-corporate-gold/20 transition-all duration-300 outline-none backdrop-blur-sm" 
                       type="text" name="nombre" :value="old('nombre')" required autofocus placeholder="Ej: Juan Pérez" />
            </div>
            <x-input-error :messages="$errors->get('nombre')" class="mt-2 text-xs text-red-400" />
        </div>

        <!-- Cédula -->
        <div class="opacity-0 animate-fade-in-up stagger-2">
            <label for="cedula" class="block text-xs font-bold text-corporate-gold uppercase tracking-[0.2em] mb-2 px-1">Cédula de Identidad</label>
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-corporate-gold transition-colors duration-300">badge</span>
                <input id="cedula" class="block w-full bg-white/5 border border-white/10 rounded-2xl pl-12 pr-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold/50 focus:ring-4 focus:ring-corporate-gold/20 transition-all duration-300 outline-none backdrop-blur-sm" 
                       type="text" name="cedula" :value="old('cedula')" required placeholder="0000000000" maxlength="10" />
            </div>
            <x-input-error :messages="$errors->get('cedula')" class="mt-2 text-xs text-red-400" />
        </div>

        <!-- Correo Electrónico -->
        <div class="opacity-0 animate-fade-in-up stagger-3">
            <label for="email" class="block text-xs font-bold text-corporate-gold uppercase tracking-[0.2em] mb-2 px-1">Correo Electrónico</label>
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-corporate-gold transition-colors duration-300">mail</span>
                <input id="email" class="block w-full bg-white/5 border border-white/10 rounded-2xl pl-12 pr-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold/50 focus:ring-4 focus:ring-corporate-gold/20 transition-all duration-300 outline-none backdrop-blur-sm" 
                       type="email" name="email" :value="old('email')" required placeholder="juan.perez@ejemplo.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-400" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
             <!-- Semestre -->
            <div class="opacity-0 animate-fade-in-up stagger-4">
                <label for="semestre" class="block text-xs font-bold text-corporate-gold uppercase tracking-[0.2em] mb-2 px-1">Semestre Actual</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-corporate-gold transition-colors duration-300">school</span>
                    <select id="semestre" name="semestre" required class="block w-full bg-white/5 border border-white/10 rounded-2xl pl-12 pr-10 py-4 text-white focus:border-corporate-gold/50 focus:ring-4 focus:ring-corporate-gold/20 transition-all duration-300 outline-none appearance-none cursor-pointer backdrop-blur-sm">
                        <option value="" disabled selected class="bg-[#23325b] text-gray-500">Seleccionar</option>
                        @foreach(range(1, \App\Models\Setting::get('max_semestres', 6)) as $i)
                            <option value="{{ $i }}" {{ old('semestre') == $i ? 'selected' : '' }} class="bg-[#23325b] text-white">{{ $i }}° Semestre</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none group-focus-within:text-corporate-gold">expand_more</span>
                </div>
                <x-input-error :messages="$errors->get('semestre')" class="mt-2 text-xs text-red-400" />
            </div>

            <!-- Contraseña -->
            <div class="opacity-0 animate-fade-in-up stagger-4">
                <label for="password" class="block text-xs font-bold text-corporate-gold uppercase tracking-[0.2em] mb-2 px-1">Contraseña</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-corporate-gold transition-colors duration-300">lock</span>
                    <input id="password" class="block w-full bg-white/5 border border-white/10 rounded-2xl pl-12 pr-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold/50 focus:ring-4 focus:ring-corporate-gold/20 transition-all duration-300 outline-none backdrop-blur-sm" 
                           type="password" name="password" required placeholder="••••••••" autocomplete="new-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-400" />
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="opacity-0 animate-fade-in-up stagger-5">
            <label for="password_confirmation" class="block text-xs font-bold text-corporate-gold uppercase tracking-[0.2em] mb-2 px-1">Confirmar Contraseña</label>
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-corporate-gold transition-colors duration-300">lock_reset</span>
                <input id="password_confirmation" class="block w-full bg-white/5 border border-white/10 rounded-2xl pl-12 pr-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold/50 focus:ring-4 focus:ring-corporate-gold/20 transition-all duration-300 outline-none backdrop-blur-sm" 
                       type="password" name="password_confirmation" required placeholder="••••••••" autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-400" />
        </div>

        <div class="flex flex-col gap-5 pt-8 opacity-0 animate-fade-in-up stagger-5">
            <button type="submit" class="w-full group relative flex items-center justify-center gap-4 bg-corporate-gold text-[#16213e] font-black py-4.5 px-8 rounded-2xl shadow-[0_15px_35px_rgba(204,167,91,0.3)] hover:shadow-[0_20px_45px_rgba(204,167,91,0.5)] transition-all duration-500 hover:-translate-y-1.5 active:scale-[0.98] text-lg uppercase tracking-widest overflow-hidden">
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                <span class="relative z-10 flex items-center gap-2">
                    Completar Registro
                    <span class="material-symbols-outlined text-2xl group-hover:translate-x-2 transition-transform duration-500">how_to_reg</span>
                </span>
            </button>

            <a class="text-center text-sm text-gray-400 hover:text-white transition-all duration-300 hover:tracking-wide" href="{{ route('login') }}">
                ¿Ya tienes una cuenta? <span class="text-corporate-gold font-bold underline underline-offset-4 decoration-corporate-gold/30 hover:decoration-corporate-gold">Inicia sesión</span>
            </a>
        </div>
    </form>
</x-guest-layout>
