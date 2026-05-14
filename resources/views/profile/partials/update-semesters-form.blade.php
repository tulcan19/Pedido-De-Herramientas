<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Configuración de Semestres') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Configura el número máximo de semestres disponibles en el sistema (por ejemplo, 6, 8 o 10 semestres).') }}
        </p>
    </header>

    <form method="post" action="{{ route('settings.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="prof-field">
            <x-input-label for="max_semestres" :value="__('Número Máximo de Semestres')" />
            <div class="prof-input-wrap">
                <span class="material-symbols-outlined ico">format_list_numbered</span>
                <input id="max_semestres" name="max_semestres" type="number" min="1" max="12" class="prof-input" value="{{ \App\Models\Setting::get('max_semestres', 6) }}" required />
            </div>
            <div class="prof-hint">
                <span class="material-symbols-outlined">info</span>
                Define hasta qué semestre pueden registrarse y avanzar los estudiantes.
            </div>
            <x-input-error :messages="$errors->get('max_semestres')" class="mt-2" />
        </div>

        <div class="prof-save-row">
            <button type="submit" class="prof-btn prof-btn-gold">
                <span class="material-symbols-outlined" style="font-size:18px;">save</span>
                {{ __('Guardar Cambios') }}
            </button>

            @if (session('status') === 'settings-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 4000)"
                    class="prof-saved"
                >
                    <span class="material-symbols-outlined" style="font-size:16px;">check_circle</span>
                    {{ __('Guardado.') }}
                </p>
            @endif
        </div>
    </form>
</section>
