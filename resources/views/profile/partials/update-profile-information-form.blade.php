<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Actualiza la información del perfil y tu número de cédula.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nombre" :value="__('Nombre Completo')" />
            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $user->nombre)" required autofocus autocomplete="nombre" />
            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
        </div>

        <div>
            <x-input-label for="cedula" :value="__('Cédula de Identidad')" />
            <x-text-input id="cedula" name="cedula" type="text" class="mt-1 block w-full bg-gray-50 text-gray-500 cursor-not-allowed" :value="old('cedula', $user->cedula)" readonly required />
            <x-input-error class="mt-2" :messages="$errors->get('cedula')" />
        </div>

        @if($user->rol === 'estudiante')
            <div>
                <x-input-label for="semestre" :value="__('Semestre Actual')" />
                <x-text-input id="semestre" name="semestre" type="text" class="mt-1 block w-full bg-gray-50 text-gray-500 cursor-not-allowed" :value="$user->semestre . '° Semestre'" readonly />
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Guardado correctamente.') }}</p>
            @endif
        </div>
    </form>
</section>
