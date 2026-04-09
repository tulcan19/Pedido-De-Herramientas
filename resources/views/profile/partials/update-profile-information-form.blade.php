<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-0">
    @csrf
    @method('patch')

    {{-- Nombre --}}
    <div class="prof-field">
        <label for="nombre">Nombre Completo</label>
        <div class="prof-input-wrap">
            <span class="material-symbols-outlined ico">badge</span>
            <input type="text" id="nombre" name="nombre" class="prof-input"
                   value="{{ old('nombre', $user->nombre) }}" required autofocus autocomplete="nombre">
        </div>
        @if($errors->get('nombre'))
            <div class="prof-error">
                <span class="material-symbols-outlined" style="font-size:.9rem;">error</span>
                {{ implode(', ', $errors->get('nombre')) }}
            </div>
        @endif
    </div>

    {{-- Cédula (solo lectura) --}}
    <div class="prof-field">
        <label for="cedula">Cédula de Identidad</label>
        <div class="prof-input-wrap">
            <span class="material-symbols-outlined ico">fingerprint</span>
            <input type="text" id="cedula" class="prof-input readonly"
                   value="{{ old('cedula', $user->cedula) }}" disabled>
        </div>
        <div class="prof-hint">
            <span class="material-symbols-outlined">info</span>
            La cédula no puede ser modificada.
        </div>
    </div>

    {{-- Semestre (solo lectura para estudiantes) --}}
    @if($user->rol === 'estudiante')
    <div class="prof-field">
        <label for="semestre_display">Semestre Académico</label>
        <div class="prof-input-wrap">
            <span class="material-symbols-outlined ico">school</span>
            <input type="text" id="semestre_display" class="prof-input readonly"
                   value="{{ $user->semestre }}° Semestre" disabled>
        </div>
        <div class="prof-hint">
            <span class="material-symbols-outlined">info</span>
            El semestre es gestionado por tu administrador.
        </div>
    </div>
    @endif

    <div class="prof-save-row">
        <button type="submit" class="prof-btn prof-btn-gold">
            <span class="material-symbols-outlined">save</span>
            Guardar Cambios
        </button>
        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition
               x-init="setTimeout(() => show = false, 3000)" class="prof-saved">
                <span class="material-symbols-outlined">check_circle</span>
                Perfil actualizado correctamente.
            </p>
        @endif
    </div>
</form>
