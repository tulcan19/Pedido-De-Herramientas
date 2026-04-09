<section class="space-y-0">

    <div class="prof-warn">
        <span class="material-symbols-outlined">warning</span>
        <p>
            Al eliminar tu cuenta, todos tus recursos, préstamos y datos históricos serán borrados de forma <strong>permanente e irreversible</strong>. Por favor, asegúrate de no tener pendientes antes de proceder.
        </p>
    </div>

    <button type="button" class="prof-btn prof-btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        <span class="material-symbols-outlined">delete_forever</span>
        Eliminar Cuenta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-extrabold text-[#16213e] flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined text-red-600">report</span>
                ¿Estás seguro de eliminar tu cuenta?
            </h2>

            <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                Una vez eliminada la cuenta, todos sus datos serán borrados permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma definitiva.
            </p>

            <div class="prof-field mb-6">
                <label for="password">Confirmar con tu Contraseña</label>
                <div class="prof-input-wrap">
                    <span class="material-symbols-outlined ico" style="color:#ef4444;">lock</span>
                    <input type="password" id="password" name="password" 
                           class="prof-input" placeholder="••••••••"
                           style="background:rgba(239,68,68,0.02); border-color:rgba(239,68,68,0.1);">
                </div>
                @if($errors->userDeletion->get('password'))
                    <div class="prof-error">
                        <span class="material-symbols-outlined" style="font-size:.9rem;">error</span>
                        {{ implode(', ', $errors->userDeletion->get('password')) }}
                    </div>
                @endif
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" x-on:click="$dispatch('close')"
                        class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-xl transition-colors">
                    Cancelar
                </button>

                <button type="submit" class="prof-btn prof-btn-danger" style="padding: 0.7rem 1.7rem; font-size: 0.85rem;">
                    <span class="material-symbols-outlined" style="font-size:1.1rem;">delete_forever</span>
                    Sí, eliminar cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>
