<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Centro de Notificaciones') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap');
        .notif-root { font-family: 'Outfit', sans-serif; background: #f0f3f8; min-height: 100vh; padding: 2rem 0; }
        .notif-container { max-width: 800px; margin: 0 auto; padding: 0 1.5rem; }
        
        .notif-card { background: white; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1.5px solid #e5e7eb; overflow: hidden; }
        .notif-item { padding: 1.5rem 2rem; border-bottom: 1px solid #f1f5f9; display: flex; gap: 1.5rem; transition: all 0.2s; position: relative; }
        .notif-item:hover { background: #f8fafc; }
        .notif-item.unread { background: #f0f7ff; border-left: 4px solid #3b82f6; }
        .notif-item.unread::after { content: ''; position: absolute; right: 2rem; top: 2rem; width: 8px; height: 8px; background: #3b82f6; border-radius: 50%; }

        .notif-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .notif-icon.incidencia { background: #fee2e2; color: #ef4444; }
        .notif-icon.peticion { background: #dcfce7; color: #22c55e; }
        .notif-icon.info { background: #dbeafe; color: #3b82f6; }

        .notif-content { flex: 1; }
        .notif-msg { font-size: 0.95rem; font-weight: 500; color: #1e293b; line-height: 1.5; margin-bottom: 0.25rem; }
        .notif-time { font-size: 0.75rem; color: #94a3b8; display: flex; align-items: center; gap: 4px; }
        
        .btn-read { padding: 0.4rem 0.8rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; border-radius: 8px; transition: all 0.2s; border: 1px solid #e5e7eb; color: #64748b; background: white; }
        .btn-read:hover { background: #f1f5f9; border-color: #cbd5e1; color: #1e293b; }

        .empty-notif { padding: 5rem 2rem; text-align: center; color: #94a3b8; }
    </style>

    <div class="notif-root">
        <div class="notif-container">
            
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-black text-[#16213e]">Notificaciones</h1>
                    <p class="text-sm text-gray-500">Mantente al tanto de la actividad de tus herramientas.</p>
                </div>
            </div>

            <div class="notif-card">
                @forelse($notifications as $n)
                    <div class="notif-item {{ $n->unread() ? 'unread' : '' }}">
                        <div class="notif-icon {{ $n->data['tipo'] ?? 'info' }}">
                            <span class="material-symbols-outlined">
                                @if(($n->data['tipo'] ?? '') == 'incidencia') report_problem 
                                @elseif(($n->data['tipo'] ?? '') == 'peticion') assignment_turned_in
                                @else notifications @endif
                            </span>
                        </div>
                        <div class="notif-content">
                            <p class="notif-msg">{{ $n->data['mensaje'] ?? 'Sin mensaje.' }}</p>
                            <div class="notif-time">
                                <span class="material-symbols-outlined text-sm">schedule</span>
                                {{ \Carbon\Carbon::parse($n->data['fecha'] ?? $n->created_at)->diffForHumans() }}
                            </div>
                        </div>
                        @if($n->unread())
                            <div>
                                <a href="{{ route('notificaciones.leer', $n->id) }}" class="btn-read">Marcar como leída</a>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-notif">
                        <span class="material-symbols-outlined text-5xl mb-4 opacity-20">notifications_off</span>
                        <p class="text-lg font-bold">No tienes notificaciones</p>
                        <p class="text-sm">Te avisaremos cuando haya novedades importantes.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
