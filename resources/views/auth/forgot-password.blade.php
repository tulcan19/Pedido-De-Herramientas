<x-guest-layout>
    <div class="mb-10 text-left">
        <h2 class="text-4xl font-bold text-white tracking-tight mb-3">¿Olvidaste tu contraseña?</h2>
        <p class="text-gray-400 text-lg font-light leading-relaxed">
            No hay problema. Indícanos tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña que te permitirá elegir una nueva.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-corporate-gold uppercase tracking-wider mb-2">Correo Electrónico</label>
            <input id="email" class="block w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-gray-500 focus:border-corporate-gold focus:ring-1 focus:ring-corporate-gold transition-all duration-300 outline-none" 
                   type="email" name="email" :value="old('email')" required autofocus placeholder="ejemplo@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <div class="flex flex-col gap-4 pt-4">
            <button type="submit" class="w-full group relative flex items-center justify-center gap-3 bg-corporate-gold text-[#16213e] font-black py-4 px-8 rounded-xl shadow-[0_10px_30px_rgba(204,167,91,0.3)] hover:shadow-[0_15px_40px_rgba(204,167,91,0.5)] transition-all duration-300 hover:-translate-y-1 active:scale-95 text-lg uppercase tracking-widest">
                <span>Enviar Enlace de Reinicio</span>
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">send</span>
            </button>

            <a class="text-center text-sm text-gray-500 hover:text-corporate-gold transition-colors underline decoration-gray-300 underline-offset-4 mt-2" href="{{ route('login') }}">
                Volver al inicio de sesión
            </a>
        </div>
    </form>
</x-guest-layout>
