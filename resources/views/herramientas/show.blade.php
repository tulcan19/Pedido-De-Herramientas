<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles de la Herramienta') }}
            </h2>
            <a href="{{ route('herramientas.index') }}" class="text-xs font-bold text-corporate-blue hover:underline">
                &larr; Volver al Catálogo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <!-- Lado Izquierdo: Imagen y QR -->
                        <div class="space-y-8">
                            <div class="relative group">
                                <div class="w-full aspect-square rounded-3xl overflow-hidden bg-gray-50 border border-gray-100 shadow-inner">
                                    <img src="{{ $herramienta->imagen_url }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $herramienta->nombre }}">
                                </div>
                                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-white p-3 rounded-2xl shadow-xl border border-gray-50 flex flex-col items-center justify-center group/qr">
                                    <div id="qrcode" class="mb-1"></div>
                                    <span class="text-[9px] font-mono text-gray-400 mb-1">{{ $herramienta->codigo_qr }}</span>
                                    <button onclick="downloadQR('{{ $herramienta->codigo_qr }}')" class="opacity-0 group-hover/qr:opacity-100 transition-opacity text-[8px] text-corporate-blue font-bold uppercase tracking-tighter hover:underline">
                                        Descargar PNG
                                    </button>
                                </div>
                            </div>
                            
                            <script>
                                new QRCode(document.getElementById("qrcode"), {
                                    text: "{{ $herramienta->codigo_qr }}",
                                    width: 80,
                                    height: 80,
                                    colorDark : "#23325b",
                                    colorLight : "#ffffff",
                                    correctLevel : QRCode.CorrectLevel.H
                                });

                                function downloadQR(code) {
                                    const container = document.getElementById('qrcode');
                                    const canvas = container.querySelector('canvas');
                                    const img = container.querySelector('img');
                                    
                                    if (canvas) {
                                        const url = canvas.toDataURL("image/png");
                                        const link = document.createElement('a');
                                        link.download = `QR-${code}.png`;
                                        link.href = url;
                                        link.click();
                                    } else if (img) {
                                        const link = document.createElement('a');
                                        link.download = `QR-${code}.png`;
                                        link.href = img.src;
                                        link.click();
                                    }
                                }
                            </script>
                        </div>

                        <!-- Lado Derecho: Información -->
                        <div class="flex flex-col h-full">
                            <div class="flex-grow">
                                <div class="mb-2">
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full 
                                        {{ $herramienta->estado == 'disponible' ? 'bg-green-100 text-green-700' : 
                                           ($herramienta->estado == 'prestado' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $herramienta->estado }}
                                    </span>
                                </div>
                                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $herramienta->nombre }}</h1>
                                
                                <div class="flex items-center gap-2 text-gray-500 mb-8 pb-8 border-b border-gray-100 font-medium">
                                    <span class="material-symbols-outlined text-sm">location_on</span>
                                    {{ $herramienta->ubicacion ?? 'Ubicación no especificada' }}
                                </div>

                                <div class="prose prose-sm text-gray-600 mb-12">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Descripción Técnica</h3>
                                    <p class="text-lg leading-relaxed">{{ $herramienta->descripcion ?? 'Sin descripción adicional para esta herramienta.' }}</p>
                                </div>
                            </div>

                            @if(Auth::user()->esAdmin())
                                <div class="flex gap-4 pt-8 border-t border-gray-100">
                                    <a href="{{ route('herramientas.edit', $herramienta) }}" class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-corporate-blue text-white rounded-xl font-bold text-sm hover:bg-gray-700 transition-all shadow-lg shadow-corporate-blue/20">
                                        <span class="material-symbols-outlined text-sm mr-2">edit</span>
                                        Editar Herramienta
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
