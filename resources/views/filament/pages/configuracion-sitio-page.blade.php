<x-filament-panels::page>
    {{-- Usamos una etiqueta form de HTML estándar con Livewire --}}
    <form wire:submit="guardar">
        
        {{-- Renderiza los campos del formulario --}}
        {{ $this->form }}

        {{-- Botón para guardar --}}
        <div class="mt-4">
            <x-filament::button type="submit" color="primary">
                Guardar Configuración
            </x-filament::button>
        </div>
        
    </form>
</x-filament-panels::page>