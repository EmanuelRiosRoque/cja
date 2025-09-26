<div class="space-y-10">

    {{-- =========================
    Encabezado: tipo, acudirán, cómo se enteró
    ========================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Tipo de persona --}}
        <fieldset class="space-y-2">
            <legend class="text-sm font-semibold">Tipo de persona</legend>
            <div class="flex flex-col gap-3">
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300" wire:model="form.variant" value="1">
                    <span class="text-sm">Persona física</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300" wire:model="form.variant" value="2">
                    <span class="text-sm">Persona moral</span>
                </label>
            </div>
            @error('person.variant') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </fieldset>

        {{-- ¿Acudirán juntos? --}}
        <fieldset class="space-y-2">
            <legend class="text-sm font-semibold">¿Acudirán juntos?</legend>
            <div class="flex flex-col gap-3">
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300" wire:model="form.acudiran_juntos" value="1">
                    <span class="text-sm">Sí</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="radio" class="rounded border-neutral-300" wire:model="form.acudiran_juntos" value="0">
                    <span class="text-sm">No</span>
                </label>
            </div>
            @error('person.acudiran_juntos') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </fieldset>

        {{-- ¿Cómo se enteró? --}}
        <div>
            <x-label>¿Cómo se enteró?</x-label>
            <select wire:model="form.como_se_entero" class="w-full rounded-md border-neutral-300">
                <option value="">-- Seleccione --</option>
                <option value="internet">Internet / Búsqueda</option>
                <option value="redes">Redes sociales</option>
                <option value="referido">Recomendación de conocido</option>
                <option value="institucion">Institución pública</option>
                <option value="cartel">Cartel / Volante</option>
                <option value="otro">Otro</option>
            </select>
            @error('person.como_se_entero') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- =========================
    Sección modular por tipo de persona
    ========================= --}}
    <div x-data class="space-y-4">
        {{-- Persona Física --}}
        <div x-show="$wire.form.variant === '1'" x-collapse x-cloak>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <x-label>Nombre</x-label>
                    <x-input type="text" wire:model.defer="form.nombre" class="w-full" />
                    @error('person.nombre') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-label>Apellido paterno</x-label>
                    <x-input type="text" wire:model.defer="form.apellido_paterno" class="w-full" />
                    @error('person.apellido_paterno') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-label>Apellido materno</x-label>
                    <x-input type="text" wire:model.defer="form.apellido_materno" class="w-full" />
                    @error('person.apellido_materno') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-label>RFC</x-label>
                    <x-input type="text" wire:model.defer="form.rfc" class="w-full uppercase" maxlength="13" />
                    @error('person.rfc') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-label>Edad</x-label>
                    <x-input type="number" min="0" max="120" wire:model.defer="form.edad" class="w-full" />
                    @error('person.edad') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <x-label>Sexo</x-label>
                    <select wire:model="form.sexo" class="w-full rounded-md border-neutral-300">
                        <option value="">-- Seleccione --</option>
                        <option value="F">Femenino</option>
                        <option value="M">Masculino</option>
                        <option value="X">No especifica</option>
                    </select>
                    @error('person.sexo') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-label>Fecha de nacimiento</x-label>
                    <x-input type="date" wire:model.defer="form.fecha_nacimiento" class="w-full" />
                    @error('person.fecha_nacimiento') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-3">
                    <div>
                        <x-label>Escolaridad</x-label>
                        <select wire:model="form.education" class="w-full rounded-md border-neutral-300">
                            <option value="">-- Seleccione --</option>
                            <option value="primaria">Primaria</option>
                            <option value="secundaria">Secundaria</option>
                            <option value="preparatoria">Preparatoria</option>
                            <option value="universidad">Universidad</option>
                            <option value="posgrado">Posgrado</option>
                            <option value="other">Otro</option>
                        </select>
                        @error('person.education') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div x-show="$wire.form.education === 'other'" x-cloak>
                        <x-label>Especifica la escolaridad</x-label>
                        <x-input type="text" wire:model.defer="form.education_other" class="w-full"
                            placeholder="Ej. Técnico en ..." />
                        @error('person.education_other') <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <x-label>Ocupación</x-label>
                    <select wire:model="form.ocupacion" class="w-full rounded-md border-neutral-300">
                        <option value="">-- Seleccione --</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="empleado">Empleado</option>
                        <option value="independiente">Independiente</option>
                        <option value="hogar">Labores del hogar</option>
                        <option value="desempleado">Desempleado</option>
                        <option value="jubilado">Jubilado</option>
                        <option value="otro">Otro</option>
                    </select>
                    @error('person.ocupacion') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-label>Nacionalidad</x-label>
                    <select wire:model="form.nacionalidad" class="w-full rounded-md border-neutral-300">
                        <option value="">-- Seleccione --</option>
                        <option value="mexicana">Mexicana</option>
                        <option value="extranjera">Extranjera</option>
                    </select>
                    @error('person.nacionalidad') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

 
         
               
            </div>
                {{-- =========================
                Datos de contacto (modal)
                ========================= --}}
                <div class=" space-y-4">
                    <h3 class="inline-block border-b-2 border-emerald-500 pb-1">
                        Datos de contacto
                    </h3>
                    <x-ui.modal name="datos-contacto" title="Datos de contacto" description="Completa los campos para continuar.">
                        <x-slot:trigger>
                            <button
                                class="inline-flex items-center gap-2 rounded-lg border px-4 py-2 text-sm font-medium bg-white hover:bg-neutral-50 border-neutral-300 text-neutral-800 shadow-sm">
                                Datos de contacto
                            </button>
                        </x-slot:trigger>
    
                        {{-- Contenido del modal --}}
                        <div class="space-y-6">
                            {{-- Teléfonos --}}
                            @php $phones = array_values($form['phones'] ?? []); @endphp
                            <section class="space-y-3">
                                <h3 class="text-sm font-semibold">Teléfonos</h3>
                                <div class="grid grid-cols-[1fr_auto] items-end gap-3">
                                    <div>
                                        <x-label>Número</x-label>
                                        <x-input type="tel" wire:model.defer="newPhoneNumber"
                                            wire:keydown.enter.prevent="addPhoneFromInput" placeholder="55-0000-0000"
                                            class="w-full" />
                                        @error('newPhoneNumber') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <x-button type="button" class="px-4 h-11 whitespace-nowrap rounded-md"
                                        wire:click="addPhoneFromInput" wire:loading.attr="disabled" wire:target="addPhoneFromInput">
                                        Agregar
                                    </x-button>
                                </div>
    
                                @php $phonesClean = array_values(array_filter($phones, fn($p)=>trim($p['number'] ?? '') !== ''));
                                @endphp
                                @if(empty($phonesClean))
                                <p class="text-xs text-neutral-500">No hay teléfonos agregados todavía.</p>
                                @else
                                <ul class="divide-y rounded border max-h-60 overflow-y-auto">
                                    @foreach($phonesClean as $i => $p)
                                    @php $num = trim($p['number'] ?? ''); $telHref = 'tel:' . preg_replace('/\D+/', '', $num);
                                    @endphp
                                    <li class="flex items-center justify-between gap-3 p-2" wire:key="phone-{{ $i }}">
                                        <a href="{{ $telHref }}" class="text-sm text-neutral-800 hover:underline truncate">{{ $num
                                            }}</a>
                                        <button type="button" class="text-xs px-2 py-1 rounded bg-neutral-100 hover:bg-neutral-200"
                                            wire:click="removePhone({{ $i }})">
                                            Quitar
                                        </button>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                                @error('person.phones') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                            </section>
    
                            {{-- Correos --}}
                            @php $emails = array_values($form['emails'] ?? []); @endphp
                            <section class="space-y-3">
                                <h3 class="text-sm font-semibold">Correos</h3>
                                <div class="grid grid-cols-[1fr_auto] items-end gap-3">
                                    <div>
                                        <x-label>Email</x-label>
                                        <x-input type="email" wire:model.defer="newEmail"
                                            wire:keydown.enter.prevent="addEmailFromInput" placeholder="correo@dominio.com"
                                            class="w-full" />
                                        @error('newEmail') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <x-button type="button" class="px-4 h-11 whitespace-nowrap rounded-md"
                                        wire:click="addEmailFromInput" wire:loading.attr="disabled" wire:target="addEmailFromInput">
                                        Agregar
                                    </x-button>
                                </div>
    
                                @php $emailsClean = array_values(array_filter($emails, fn($e)=>trim($e['email'] ?? '') !== ''));
                                @endphp
                                @if(empty($emailsClean))
                                <p class="text-xs text-neutral-500">No hay correos agregados todavía.</p>
                                @else
                                <ul class="divide-y rounded border max-h-60 overflow-y-auto">
                                    @foreach($emailsClean as $i => $e)
                                    <li class="flex items-center justify-between gap-3 p-2" wire:key="email-{{ $i }}">
                                        <a href="mailto:{{ $e['email'] }}"
                                            class="text-sm text-neutral-800 hover:underline truncate">{{ $e['email'] }}</a>
                                        <button type="button" class="text-xs px-2 py-1 rounded bg-neutral-100 hover:bg-neutral-200"
                                            wire:click="removeEmail({{ $i }})">
                                            Quitar
                                        </button>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                                @error('person.emails') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                            </section>
                        </div>
                        
    
                        <x-slot:footer>
                            <button @click="$dispatch('close-modal', { name: 'datos-contacto' })"
                                class="rounded-lg px-4 py-2 text-sm font-medium border bg-white border-neutral-300 hover:bg-neutral-50">
                                Cancelar
                            </button>
                            <button @click="$dispatch('close-modal', { name: 'datos-contacto' })"
                                class="rounded-lg px-4 py-2 text-sm font-semibold text-white bg-neutral-900 hover:bg-neutral-800">
                                Guardar
                            </button>
                        </x-slot:footer>
                    </x-ui.modal>
                </div>
        </div>

        {{-- Persona Moral --}}
        <div x-show="$wire.form.variant === '2'" x-collapse x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="md:col-span-2">
                <x-label>Razón social</x-label>
                <x-input type="text" class="w-full" wire:model.defer="form.pm.razon_social" />
                @error('person.pm.razon_social') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <x-label>RFC</x-label>
                <x-input type="text" class="w-full uppercase" maxlength="13" wire:model.defer="form.pm.rfc" />
                @error('person.pm.rfc') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

     

    </div>


    {{-- =========================
    Adjuntos
    ========================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <livewire:ui.dropzone wire:model="form.identificacion" :label="'Identificacion'" :multiple="false"
            accept=".pdf,.jpg,.jpeg,.png" />
        <livewire:ui.dropzone wire:model="form.formato_aceptacion" :label="'Formato aceptacion'" :multiple="false"
            accept=".pdf,.jpg,.jpeg,.png" />
    </div>



    {{-- =========================
    Representante
    ========================= --}}
    <fieldset class="space-y-2">
        <legend class="text-sm font-semibold">¿Es representante?</legend>
        <div class="flex flex-col gap-3">
            <label class="inline-flex items-center gap-2">
                <input type="radio" class="rounded border-neutral-300" wire:model="form.representante" value="1">
                <span class="text-sm">Sí</span>
            </label>
            <label class="inline-flex items-center gap-2">
                <input type="radio" class="rounded border-neutral-300" wire:model="form.representante" value="0">
                <span class="text-sm">No</span>
            </label>
        </div>
        @error('form.representante') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </fieldset>

    <div x-data x-show="$wire.form.representante == '1'" x-transition x-cloak class="mt-4 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <x-label>Nombre del representante</x-label>
                <x-input type="text" class="w-full" wire:model.defer="form.rep.name" />
                @error('form.rep.name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <x-label>Apellido paterno</x-label>
                <x-input type="text" class="w-full" wire:model.defer="form.rep.apellido_paterno" />
                @error('form.rep.apellido_paterno') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <x-label>Apellido materno</x-label>
                <x-input type="text" class="w-full" wire:model.defer="form.rep.apellido_materno" />
                @error('form.rep.apellido_materno') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <x-label>Documentos que lo avalan</x-label>
            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-3">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model="form.rep.docs.doc1" class="rounded border-neutral-300">
                    <span class="text-sm">Poder notarial</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model="form.rep.docs.doc2" class="rounded border-neutral-300">
                    <span class="text-sm">Carta poder simple</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" wire:model="form.rep.docs.doc3" class="rounded border-neutral-300">
                    <span class="text-sm">Identificación oficial</span>
                </label>
            </div>
        </div>

        <div class="space-y-6">
            <div x-show="$wire.form.rep.docs?.doc1" x-cloak>
                <livewire:ui.dropzone wire:key="dz-rep-doc1" wire:model="form.rep.files.doc1" :label="'Poder notarial'"
                    :multiple="false" accept=".pdf,.jpg,.jpeg,.png" />
            </div>
            <div x-show="$wire.form.rep.docs?.doc2" x-cloak>
                <livewire:ui.dropzone wire:key="dz-rep-doc2" wire:model="form.rep.files.doc2"
                    :label="'Carta poder simple'" :multiple="true" accept=".pdf,.jpg,.jpeg,.png" />
            </div>
            <div x-show="$wire.form.rep.docs?.doc3" x-cloak>
                <livewire:ui.dropzone wire:key="dz-rep-doc3" wire:model="form.rep.files.doc3"
                    :label="'Identificación oficial'" :multiple="true" accept=".pdf,.jpg,.jpeg,.png" />
            </div>
        </div>
    </div>
</div>