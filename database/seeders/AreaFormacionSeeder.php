<?php

namespace Database\Seeders;

use App\Models\AreaFormacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaFormacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areaFormacions = [
            [
                'nombre' => 'Agricultura Orgánica Y Plantas',
                'slug' => 'agricultura-organica-y-plantas',
                'descripcion' => '<h2>What is Lorem Ipsum?</h2><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since 1966, when designers at Letraset and James Mosley, the librarian at St Bride Printing Library in London, took a 1914 Cicero translation and scrambled it to make dummy text for Letraset\'s Body Type sheets. It has survived not only many decades, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised thanks to these sheets and more recently with desktop publishing software like Aldus PageMaker and Microsoft Word including versions of Lorem Ipsum.</p>',
                'icono' => 'leaf',
                'color' => '#56bf7d',
                'deleted_at' => null,
                'created_at' => '2026-07-29 23:08:26',
                'updated_at' => '2026-07-29 18:59:00',
            ],
            [
                'nombre' => 'Arte Y Recreación',
                'slug' => 'arte-y-recreacion',
                'descripcion' => '<h2>What is Lorem Ipsum?</h2><p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since 1966, when designers at Letraset and James Mosley, the librarian at St Bride Printing Library in London, took a 1914 Cicero translation and scrambled it to make dummy text for Letraset\'s Body Type sheets. It has survived not only many decades, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised thanks to these sheets and more recently with desktop publishing software like Aldus PageMaker and Microsoft Word including versions of Lorem Ipsum.</p>',
                'icono' => 'users',
                'color' => '#f59e0b',
                'deleted_at' => null,
                'created_at' => '2026-07-29 23:09:00',
                'updated_at' => '2026-07-29 18:58:23',
            ],
            [
                'nombre' => 'Cómputo e Idiomas',
                'slug' => 'computo-e-idiomas',
                'descripcion' => '<h2>What is Lorem Ipsum?</h2><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since 1966, when designers at Letraset and James Mosley, the librarian at St Bride Printing Library in London, took a 1914 Cicero translation and scrambled it to make dummy text for Letraset\'s Body Type sheets. It has survived not only many decades, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised thanks to these sheets and more recently with desktop publishing software like Aldus PageMaker and Microsoft Word including versions of Lorem Ipsum.</p>',
                'icono' => 'computer',
                'color' => '#1c3a5e',
                'deleted_at' => null,
                'created_at' => '2026-07-29 23:08:53',
                'updated_at' => '2026-07-29 18:58:35',
            ],
            [
                'nombre' => 'Humanidades',
                'slug' => 'humanidades',
                'descripcion' => '<h2>What is Lorem Ipsum?</h2><p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since 1966, when designers at Letraset and James Mosley, the librarian at St Bride Printing Library in London, took a 1914 Cicero translation and scrambled it to make dummy text for Letraset\'s Body Type sheets. It has survived not only many decades, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised thanks to these sheets and more recently with desktop publishing software like Aldus PageMaker and Microsoft Word including versions of Lorem Ipsum.</p>',
                'icono' => 'book-open',
                'color' => '#ffbe90',
                'deleted_at' => null,
                'created_at' => '2026-07-29 23:08:38',
                'updated_at' => '2026-07-29 18:58:50',
            ],
            [
                'nombre' => 'Salud y Desarrollo',
                'slug' => 'salud-y-desarrollo',
                'descripcion' => '<h2>What is Lorem Ipsum?</h2><p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since 1966, when designers at Letraset and James Mosley, the librarian at St Bride Printing Library in London, took a 1914 Cicero translation and scrambled it to make dummy text for Letraset\'s Body Type sheets. It has survived not only many decades, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised thanks to these sheets and more recently with desktop publishing software like Aldus PageMaker and Microsoft Word including versions of Lorem Ipsum.</p>',
                'icono' => 'heart',
                'color' => '#0ea5e9',
                'deleted_at' => null,
                'created_at' => '2026-07-29 21:57:35',
                'updated_at' => '2026-07-29 18:59:08',
            ],
        ];

        foreach ($areaFormacions as $area) {
            AreaFormacion::updateOrCreate(
                ['slug' => $area['slug']],
                $area
            );
        }
    }
}
