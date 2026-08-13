<?php

namespace App\Filament\Pages;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Models\ConfiguracionSitio;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\KeyValue;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Form as ComponentsForm;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ConfiguracionSitioPage extends Page implements HasForms
{
    use InteractsWithForms;

    // Icono y título en el menú lateral

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;


    protected static ?string $navigationLabel = 'Configuración del Sitio';
    protected static ?string $title = 'Ajustes Generales';

    protected string $view = 'filament.pages.configuracion-sitio-page';
    protected static string | UnitEnum | null $navigationGroup = 'Sistema';
    public ?array $data = [];

    public function mount(): void
    {
        // Busca el primer registro o lo crea con valores por defecto
        $config = ConfiguracionSitio::firstOrCreate(
            ['id' => 1], // Busca el ID 1
            [
                'nombre' => 'SUAM',
                'acerca_de' => 'Información sobre el sitio...',
                'codigo_etica' => [],
                'contacto' => [],
                'dictamen' => null,
            ]
        );

        // Llena el formulario con los datos de la BD
        $this->form->fill($config->toArray());
    }

    public function form($form)
    {
        return $form
            ->schema([
                TextInput::make('nombre')->label('Nombre del Sitio')
                    ->required()
                    ->maxLength(255),

                Section::make('Acerca de')
                    ->schema([

                        TinyEditor::make('acerca_de')
                            ->required()->profile('simple'),

                        FileUpload::make('dictamen')->acceptedFileTypes(['application/pdf'])->label('Dictamen de creación')->disk('public'),

                        Fieldset::make('Información de Contacto')
                            ->schema([
                                TextInput::make('contacto.email')
                                    ->label('Correo electrónico')
                                    ->email(),

                                TextInput::make('contacto.telefono')
                                    ->label('Teléfono')
                                    ->tel(),

                                TextInput::make('contacto.dirección')
                                    ->label('Dirección'),

                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('contacto.horario_dias')
                                            ->label('Días de atención')
                                            ->placeholder('Lunes a Viernes')
                                            ->required(),

                                        TextInput::make('contacto.horario_horas')
                                            ->label('Horario de atención')
                                            ->placeholder('9:00 AM - 6:00 PM')
                                            ->required(),
                                    ])
                            ])
                            ->columns(2)

                    ]),
                Section::make('Código de Ética')
                    ->schema([
                        // Editor de texto enriquecido
                        TinyEditor::make('codigo_etica.descripcion')
                            ->label('Texto / Descripción del Código de Ética')
                            ->required()->profile('simple'),

                        // Subida del archivo (ej. PDF o Imagen)
                        FileUpload::make('codigo_etica.archivo')
                            ->label('Documento Adjunto (PDF)')
                            ->acceptedFileTypes(['application/pdf'])->disk('public')
                            ->directory('codigo-etica') // Carpeta en storage donde se guardará
                            ->maxSize(10240) // Límite de 10 MB (opcional)
                            ->downloadable() // Permite descargar el archivo desde el panel
                            ->openable(),   // Permite abrir/previsualizar el archivo
                    ]),


            ])
            ->statePath('data');
    }

    public function guardar(): void
    {
        // Obtiene el registro y lo actualiza
        $config = ConfiguracionSitio::first();
        $config->update($this->form->getState());

        // Muestra una notificación de éxito
        Notification::make()
            ->success()
            ->title('Configuración guardada exitosamente')
            ->send();
    }
}
