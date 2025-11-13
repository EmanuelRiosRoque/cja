@props([
    'label' => null,
    'options' => null,
    'wireModel' => null,
    'placeholder' => '-- Selecciona --',
])

<div 
    x-data="{
        open: false,
        search: '',
        selected: '',
        options: {{ $options ? json_encode($options) : '[]' }},
        init() {
            if (this.options.length === 0) {
                const els = this.$root.querySelectorAll('option[data-opt]');
                this.options = Array.from(els).map(o => ({
                    value: o.value,
                    label: o.textContent.trim()
                }));
            }

            $watch('$wire.{{ $wireModel }}', (value) => {
                if (!value) {
                    this.selected = '';
                    this.search = '';
                } else {
                    // Si hay valor, actualizar el texto visible
                    const opt = this.options.find(o => o.value == value);
                    this.selected = opt ? opt.label : '';
                }
            });
        },
        get filtered() {
            if (this.search === '') return this.options;
            return this.options.filter(o => 
                o.label.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        selectOption(option) {
            this.selected = option.label;
            this.open = false;
            this.search = '';
            $wire.set('{{ $wireModel }}', option.value);
        }
    }"
    x-init="init()"
    class="relative"
>

    @if ($label)
        <x-label :value="$label" />
    @endif

    {{-- Campo principal --}}
    <input
        type="text"
        x-model="selected"
        @click="open = !open"
        placeholder="{{ $placeholder }}"
        readonly
        class="mt-1 w-full cursor-pointer border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
    />

    {{-- Dropdown --}}
    <div
        x-show="open"
        @click.outside="open = false"
        class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-md max-h-48 overflow-y-auto"
    >
        <div class="p-2">
            <input
                type="text"
                x-model="search"
                placeholder="Buscar..."
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm"
            />
        </div>

        <template x-for="option in filtered" :key="option.value">
            <div
                @click="selectOption(option)"
                class="px-3 py-2 hover:bg-emerald-100 cursor-pointer text-sm text-gray-700"
                x-text="option.label"
            ></div>
        </template>

        <div x-show="filtered.length === 0" class="px-3 py-2 text-gray-500 text-sm">
            Sin resultados
        </div>
    </div>

    {{-- Aquí se renderiza el slot oculto (para foreach) --}}
    <div class="hidden">
        {{ $slot }}
    </div>

    @error($wireModel)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>
