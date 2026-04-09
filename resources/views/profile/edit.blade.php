<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi Perfil
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');

        .prof-root {
            font-family: 'Outfit', sans-serif;
            background: #f0f3f8;
            min-height: 100vh;
            padding-bottom: 3rem;
        }

        /* ── HERO ── */
        .prof-hero {
            background: linear-gradient(135deg, #16213e 0%, #23325b 60%, #2a3d6e 100%);
            position: relative;
            overflow: hidden;
            padding: 2.5rem 1.5rem 5rem;
        }
        .prof-hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(204,167,91,.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .prof-hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 25%;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(204,167,91,.10) 0%, transparent 70%);
            border-radius: 50%;
        }
        .prof-hero-inner {
            max-width: 900px; margin: 0 auto;
            position: relative; z-index: 1;
            display: flex; align-items: center; gap: 1.75rem;
        }
        .prof-avatar {
            width: 76px; height: 76px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, #cca75b, #a07a2a);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 28px rgba(204,167,91,.4);
            font-size: 2rem; font-weight: 800; color: #16213e;
        }
        .prof-hero-text {}
        .prof-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(204,167,91,.15); border: 1px solid rgba(204,167,91,.35);
            color: #cca75b; font-size: 11px; font-weight: 700;
            padding: 4px 12px; border-radius: 999px;
            margin-bottom: .6rem; letter-spacing: .06em; text-transform: uppercase;
        }
        .prof-hero-name {
            font-size: clamp(1.4rem, 3vw, 1.9rem);
            font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: .35rem;
        }
        .prof-meta-pills { display: flex; flex-wrap: wrap; gap: .5rem; }
        .prof-meta-pill {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
            color: #a0b0cc; font-size: .75rem; font-weight: 600;
            padding: .25rem .8rem; border-radius: 999px;
        }
        .prof-meta-pill .material-symbols-outlined { font-size: 13px; color: #cca75b; }

        /* ── MAIN ── */
        .prof-main {
            max-width: 900px; margin: -3rem auto 0;
            padding: 0 1.5rem;
            position: relative; z-index: 10;
            display: flex; flex-direction: column; gap: 1.5rem;
        }

        /* ── CARD ── */
        .prof-card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 8px 40px rgba(0,0,0,.08);
            border: 1.5px solid #e5e7eb;
            overflow: hidden;
        }
        .prof-card-header {
            padding: 1.5rem 2rem; border-bottom: 1px solid #f1f5f9;
            display: flex; align-items: center; gap: 1rem;
        }
        .prof-card-icon {
            width: 48px; height: 48px; border-radius: 13px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(0,0,0,.15);
        }
        .prof-card-icon .material-symbols-outlined { color: #fff; font-size: 22px; }
        .prof-card-icon.gold   { background: linear-gradient(135deg, #cca75b, #a07a2a); box-shadow: 0 4px 14px rgba(204,167,91,.35); }
        .prof-card-icon.blue   { background: linear-gradient(135deg, #23325b, #16213e); }
        .prof-card-icon.danger { background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 4px 14px rgba(239,68,68,.3); }
        .prof-card-header h3 { font-size: 1.05rem; font-weight: 700; color: #16213e; }
        .prof-card-header p  { font-size: .8rem; color: #6b7280; margin-top: .15rem; }
        .prof-card-body { padding: 2rem; }

        /* ── FIELDS ── */
        .prof-field { margin-bottom: 1.2rem; }
        .prof-field label {
            display: block; font-size: .72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em; color: #374151; margin-bottom: .5rem;
        }
        .prof-input-wrap { position: relative; }
        .prof-input-wrap .ico {
            position: absolute; left: .8rem; top: 50%; transform: translateY(-50%);
            color: #cca75b; font-size: 1.1rem; pointer-events: none;
        }
        .prof-input {
            width: 100%; padding: .75rem 1rem .75rem 2.6rem; box-sizing: border-box;
            border: 1.5px solid #e5e7eb; border-radius: 10px;
            font-size: .92rem; color: #16213e; background: #fff;
            font-family: 'Outfit', sans-serif;
            transition: border-color .2s, box-shadow .2s;
        }
        .prof-input:focus {
            outline: none; border-color: #cca75b;
            box-shadow: 0 0 0 3px rgba(204,167,91,.15);
        }
        .prof-input:disabled, .prof-input.readonly {
            background: #f8fafc; color: #9ca3af; cursor: not-allowed;
        }
        .prof-hint {
            font-size: .72rem; color: #9ca3af; margin-top: .35rem;
            display: flex; align-items: center; gap: 4px; font-style: italic;
        }
        .prof-hint .material-symbols-outlined { font-size: .85rem; color: #cca75b; }
        .prof-error {
            font-size: .78rem; color: #b91c1c; margin-top: .45rem; font-weight: 500;
            background: #fee2e2; padding: .45rem .9rem; border-radius: 7px;
            border-left: 3px solid #ef4444; display: flex; align-items: center; gap: 4px;
        }

        /* ── SAVE ROW ── */
        .prof-save-row {
            display: flex; align-items: center; gap: 1.2rem;
            padding-top: 1.5rem; border-top: 1px solid #f1f5f9; margin-top: 1.5rem;
        }
        .prof-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: .75rem 1.75rem; border-radius: 12px; border: none; cursor: pointer;
            font-size: .9rem; font-weight: 800; font-family: 'Outfit', sans-serif;
            text-transform: uppercase; letter-spacing: .04em;
            transition: transform .15s, box-shadow .15s;
        }
        .prof-btn-gold {
            background: linear-gradient(135deg, #cca75b, #a07a2a); color: #16213e;
            box-shadow: 0 4px 15px rgba(204,167,91,.4);
        }
        .prof-btn-gold:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(204,167,91,.5); }
        .prof-btn-blue {
            background: linear-gradient(135deg, #23325b, #16213e); color: #fff;
            box-shadow: 0 4px 15px rgba(22,33,62,.3);
        }
        .prof-btn-blue:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(22,33,62,.45); }
        .prof-btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff;
            box-shadow: 0 4px 15px rgba(239,68,68,.3);
        }
        .prof-btn-danger:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(239,68,68,.45); }
        .prof-saved {
            font-size: .82rem; color: #16a34a; font-weight: 600;
            display: flex; align-items: center; gap: 5px;
        }

        /* ── DANGER WARNING BOX ── */
        .prof-warn {
            background: #fef2f2; border-left: 4px solid #ef4444; border-radius: 0 10px 10px 0;
            padding: 1rem 1.2rem; margin-bottom: 1.5rem;
            display: flex; gap: .8rem; align-items: flex-start;
        }
        .prof-warn .material-symbols-outlined { color: #ef4444; font-size: 1.2rem; flex-shrink: 0; }
        .prof-warn p { font-size: .83rem; color: #b91c1c; margin: 0; line-height: 1.6; font-weight: 600; }
    </style>

    <div class="prof-root">

        {{-- ── HERO ── --}}
        <div class="prof-hero">
            <div class="prof-hero-inner">
                <div class="prof-avatar">
                    {{ strtoupper(mb_substr(Auth::user()->nombre, 0, 1)) }}
                </div>
                <div class="prof-hero-text">
                    <div class="prof-badge">
                        <span class="material-symbols-outlined" style="font-size:12px;">manage_accounts</span>
                        Mi Cuenta
                    </div>
                    <div class="prof-hero-name">{{ Auth::user()->nombre }}</div>
                    <div class="prof-meta-pills">
                        <span class="prof-meta-pill">
                            <span class="material-symbols-outlined">badge</span>
                            {{ Auth::user()->cedula }}
                        </span>
                        <span class="prof-meta-pill">
                            <span class="material-symbols-outlined">shield_person</span>
                            {{ ucfirst(Auth::user()->rol) }}
                        </span>
                        @if(Auth::user()->rol === 'estudiante')
                        <span class="prof-meta-pill">
                            <span class="material-symbols-outlined">school</span>
                            {{ Auth::user()->semestre }}° Semestre
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ── CARDS ── --}}
        <div class="prof-main">

            {{-- Información Personal --}}
            <div class="prof-card">
                <div class="prof-card-header">
                    <div class="prof-card-icon gold">
                        <span class="material-symbols-outlined">person</span>
                    </div>
                    <div>
                        <h3>Información Personal</h3>
                        <p>Actualiza tu nombre de usuario en el sistema.</p>
                    </div>
                </div>
                <div class="prof-card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Seguridad --}}
            <div class="prof-card">
                <div class="prof-card-header">
                    <div class="prof-card-icon blue">
                        <span class="material-symbols-outlined">lock</span>
                    </div>
                    <div>
                        <h3>Seguridad y Contraseña</h3>
                        <p>Usa una contraseña larga y aleatoria para mantener tu cuenta segura.</p>
                    </div>
                </div>
                <div class="prof-card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Zona Peligrosa --}}
            <div class="prof-card" style="border-color: #fecaca;">
                <div class="prof-card-header" style="border-color: #fef2f2;">
                    <div class="prof-card-icon danger">
                        <span class="material-symbols-outlined">delete_forever</span>
                    </div>
                    <div>
                        <h3 style="color: #b91c1c;">Zona Peligrosa</h3>
                        <p>Una vez eliminada, tu cuenta no podrá recuperarse.</p>
                    </div>
                </div>
                <div class="prof-card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
