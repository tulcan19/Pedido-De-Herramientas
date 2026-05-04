<form method="post" action="{{ route('password.update') }}" class="space-y-0">
    @csrf
    @method('put')

    {{-- Contraseña actual --}}
    <div class="prof-field">
        <label for="update_password_current_password">Contraseña Actual</label>
        <div class="prof-input-wrap">
            <span class="material-symbols-outlined ico">lock</span>
            <input type="password" id="update_password_current_password" name="current_password"
                   class="prof-input" placeholder="••••••••" autocomplete="current-password">
        </div>
        @if($errors->updatePassword->get('current_password'))
            <div class="prof-error">
                <span class="material-symbols-outlined" style="font-size:.9rem;">error</span>
                {{ implode(', ', $errors->updatePassword->get('current_password')) }}
            </div>
        @endif
    </div>

    {{-- Nueva contraseña --}}
    <div class="prof-field">
        <label for="update_password_password">Nueva Contraseña</label>
        <div class="prof-input-wrap">
            <span class="material-symbols-outlined ico">lock_open</span>
            <input type="password" id="update_password_password" name="password"
                   class="prof-input" placeholder="••••••••" autocomplete="new-password">
        </div>
        <p class="prof-hint mt-1">Debe contener al menos 8 caracteres, mayúsculas, minúsculas, números y símbolos.</p>
        @if($errors->updatePassword->get('password'))
            <div class="prof-error">
                <span class="material-symbols-outlined" style="font-size:.9rem;">error</span>
                {{ implode(', ', $errors->updatePassword->get('password')) }}
            </div>
        @endif
    </div>

    {{-- Confirmar nueva contraseña --}}
    <div class="prof-field">
        <label for="update_password_password_confirmation">Confirmar Nueva Contraseña</label>
        <div class="prof-input-wrap">
            <span class="material-symbols-outlined ico">verified</span>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                   class="prof-input" placeholder="••••••••" autocomplete="new-password">
        </div>
        @if($errors->updatePassword->get('password_confirmation'))
            <div class="prof-error">
                <span class="material-symbols-outlined" style="font-size:.9rem;">error</span>
                {{ implode(', ', $errors->updatePassword->get('password_confirmation')) }}
            </div>
        @endif
    </div>

    <div class="prof-save-row">
        <button type="submit" class="prof-btn prof-btn-blue">
            <span class="material-symbols-outlined">security</span>
            Actualizar Contraseña
        </button>

        @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition
               x-init="setTimeout(() => show = false, 3000)" class="prof-saved">
                <span class="material-symbols-outlined">check_circle</span>
                Contraseña actualizada correctamente.
            </p>
        @endif
    </div>
</form>
