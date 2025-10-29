{{-- ===== PANEL DE RECESO ===== --}}
@if($agregandoReceso)
<div class="mt-6 border rounded-lg overflow-hidden">
    <div class="bg-neutral-100 px-4 py-2 text-sm font-semibold text-neutral-700">
        Agregar receso en la sesión:
    </div>

    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-xs font-medium text-neutral-700 mb-1">Hora de inicio:</label>
            <x-input type="time" step="300" wire:model="receso_inicio" class="w-full border-gray-300 rounded-md shadow-sm 
                     focus:ring-emerald-500 focus:border-emerald-500" />
            @error('receso_inicio') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-medium text-neutral-700 mb-1">Hora de fin:</label>
            <x-input type="time" step="300" wire:model="receso_fin" class="w-full border-gray-300 rounded-md shadow-sm 
                     focus:ring-emerald-500 focus:border-emerald-500" />
            @error('receso_fin') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="px-4 pb-4 flex justify-end gap-3">
        <x-button variant="secondary" wire:click="cancelarReceso">
            Cancelar
        </x-button>
        <x-button variant="primary" wire:click="confirmarReceso">
            Agregar
        </x-button>
    </div>
</div>
@endif

{{-- ===== LISTADO DE RECESOS ===== --}}
<div class="mt-8">
    <h4 class="text-sm font-semibold text-neutral-800 mb-3 border-b border-neutral-200 pb-1">
        Recesos agregados
    </h4>

    <div class="overflow-x-auto rounded-xl shadow-sm ring-1 ring-neutral-200 bg-white">
        <table class="min-w-full text-sm text-neutral-700">
            <thead class="bg-neutral-50 text-neutral-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold w-16">#</th>
                    <th class="px-4 py-3 text-left font-semibold">Inicio</th>
                    <th class="px-4 py-3 text-left font-semibold">Fin</th>
                    <th class="px-4 py-3 text-right font-semibold w-32">Acción</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recesos as $i => $r)
                <tr class="border-t transition-colors">
                    <td class="px-4 py-2 font-medium text-neutral-800">{{ $i + 1 }}</td>
                    <td class="px-4 py-2">{{ $r['inicio'] }}</td>
                    <td class="px-4 py-2">{{ $r['fin'] }}</td>
                    <td class="px-4 py-2 text-right">
                        <button wire:click="eliminarReceso({{ $i }})" type="button"
                            class="text-red-600 hover:text-red-700 font-medium transition">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="border-t">
                    <td colspan="4" class="px-4 py-6 text-center text-neutral-500 italic">
                        No hay recesos para esta sesión.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>