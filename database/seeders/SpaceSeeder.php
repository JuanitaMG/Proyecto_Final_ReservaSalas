<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Space;

class SpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spaces = [

            [
                'name' => 'Sala Ejecutiva',
                'slug' => 'sala-ejecutiva',
                'capacity' => 12,
                'description' => 'Sala moderna para reuniones ejecutivas y juntas empresariales.',
                'price_per_hour' => 80000,
                'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72',
                'is_active' => true,
            ],

            [
                'name' => 'Auditorio Principal',
                'slug' => 'auditorio-principal',
                'capacity' => 120,
                'description' => 'Auditorio amplio para conferencias, eventos y capacitaciones.',
                'price_per_hour' => 250000,
                'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865',
                'is_active' => true,
            ],

            [
                'name' => 'Sala Creativa',
                'slug' => 'sala-creativa',
                'capacity' => 20,
                'description' => 'Espacio dinámico para brainstorming y trabajo colaborativo.',
                'price_per_hour' => 70000,
                'image' => 'https://images.unsplash.com/photo-1497366811353-6870744d04b2',
                'is_active' => true,
            ],

            [
                'name' => 'Laboratorio Tech',
                'slug' => 'laboratorio-tech',
                'capacity' => 25,
                'description' => 'Laboratorio equipado con tecnología para prácticas y talleres.',
                'price_per_hour' => 120000,
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3',
                'is_active' => true,
            ],

            [
                'name' => 'Sala VIP',
                'slug' => 'sala-vip',
                'capacity' => 8,
                'description' => 'Sala premium para reuniones privadas y clientes importantes.',
                'price_per_hour' => 150000,
                'image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36',
                'is_active' => true,
            ],

            [
                'name' => 'Sala de Capacitación',
                'slug' => 'sala-capacitacion',
                'capacity' => 40,
                'description' => 'Espacio ideal para cursos, talleres y entrenamientos.',
                'price_per_hour' => 100000,
                'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c',
                'is_active' => true,
            ],

            [
                'name' => 'Sala Multimedia',
                'slug' => 'sala-multimedia',
                'capacity' => 18,
                'description' => 'Sala equipada con proyector, sonido y pantallas interactivas.',
                'price_per_hour' => 95000,
                'image' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d',
                'is_active' => true,
            ],

            [
                'name' => 'Coworking Norte',
                'slug' => 'coworking-norte',
                'capacity' => 30,
                'description' => 'Espacio coworking moderno para equipos y freelancers.',
                'price_per_hour' => 60000,
                'image' => 'https://images.unsplash.com/photo-1497366412874-3415097a27e7',
                'is_active' => true,
            ],

            [
                'name' => 'Sala Académica',
                'slug' => 'sala-academica',
                'capacity' => 35,
                'description' => 'Sala destinada para clases, seminarios y actividades educativas.',
                'price_per_hour' => 85000,
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f',
                'is_active' => true,
            ],

            [
                'name' => 'Sala Principal',
                'slug' => 'sala-principal',
                'capacity' => 60,
                'description' => 'Espacio amplio para reuniones generales y presentaciones.',
                'price_per_hour' => 180000,
                'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c',
                'is_active' => true,
            ],

            [
                'name' => 'Cubículo Privado',
                'slug' => 'cubiculo-privado',
                'capacity' => 4,
                'description' => 'Cubículo privado para entrevistas y reuniones pequeñas.',
                'price_per_hour' => 40000,
                'image' => 'https://images.unsplash.com/photo-1497366412874-3415097a27e7',
                'is_active' => true,
            ],

            [
                'name' => 'Sala Innovación',
                'slug' => 'sala-innovacion',
                'capacity' => 15,
                'description' => 'Espacio creativo diseñado para proyectos de innovación.',
                'price_per_hour' => 90000,
                'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72',
                'is_active' => true,
            ],

        ];

        foreach ($spaces as $space) {

            Space::create($space);

        }
    }
}