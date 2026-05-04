<x-guest-layout>
    <div class="mb-10 text-left">
        <h2 class="text-4xl font-bold text-white tracking-tight mb-3">Restablecer Contraseña</h2>
        <p class="text-gray-400 text-lg font-light leading-relaxed">
            Ingresa tu nueva contraseña para acceder a tu cuenta en el sistema de inventario del taller.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider mb-2">Correo Electrónico</label>
            <input id="email" class="block w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none opacity-70 cursor-not-allowed" 
                   type="email" name="email" value="{{ old('email', $request->email) }}" required readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider mb-2">Nueva Contraseña</label>
            <input id="password" class="block w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none" 
                   type="password" name="password" required autofocus autocomplete="new-password" placeholder="••••••••" />
            <p class="text-[11px] text-gray-400 mt-2 italic">Debe contener al menos 8 caracteres, mayúsculas, minúsculas, números y símbolos.</p>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider mb-2">Confirmar Contraseña</label>
            <input id="password_confirmation" class="block w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none" 
                   type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <div class="flex flex-col gap-4 pt-4">
            <button type="submit" class="w-full group relative flex items-center justify-center gap-3 bg-corporate-gold text-[#16213e] font-black py-4 px-8 rounded-xl shadow-[0_10px_30px_rgba(204,167,91,0.3)] hover:shadow-[0_15px_40px_rgba(204,167,91,0.5)] transition-all duration-300 hover:-translate-y-1 active:scale-95 text-lg uppercase tracking-widest">
                <span>Restablecer Contraseña</span>
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">lock_reset</span>
            </button>
        </div>
    </form>
</x-guest-layout>
