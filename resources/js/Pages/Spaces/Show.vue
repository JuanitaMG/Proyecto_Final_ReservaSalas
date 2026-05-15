<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({

    space: Object

})

</script>

<template>

    <AdminLayout>

        <div class="max-w-7xl mx-auto">

            <!-- IMAGE -->
            <div class="relative rounded-[32px] overflow-hidden shadow-2xl mb-10">

                <img
                    :src="space.image"
                    :alt="space.name"
                    class="w-full h-[450px] object-cover"
                >

                <!-- OVERLAY -->
                <div class="absolute inset-0 bg-black/40" />

                <!-- CONTENT -->
                <div class="absolute bottom-0 left-0 p-10 text-white">

                    <div
                        class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-xl px-4 py-2 rounded-full text-sm font-semibold mb-5"
                    >
                        🏢 Espacio disponible
                    </div>

                    <h1 class="text-5xl lg:text-6xl font-black mb-4">
                        {{ space.name }}
                    </h1>

                    <p class="text-xl text-gray-200 max-w-3xl leading-relaxed">
                        {{ space.description }}
                    </p>

                </div>

            </div>

            <!-- GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- INFO -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-gray-100">

                    <h2 class="text-3xl font-black text-gray-800 mb-8">
                        Información del espacio
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- CAPACITY -->
                        <div class="bg-gray-50 rounded-3xl p-6">

                            <div class="text-4xl mb-4">
                                👥
                            </div>

                            <p class="text-gray-400 text-sm">
                                Capacidad
                            </p>

                            <h3 class="text-2xl font-black text-gray-800 mt-2">
                                {{ space.capacity }} personas
                            </h3>

                        </div>

                        <!-- PRICE -->
                        <div class="bg-gray-50 rounded-3xl p-6">

                            <div class="text-4xl mb-4">
                                💰
                            </div>

                            <p class="text-gray-400 text-sm">
                                Precio por hora
                            </p>

                            <h3 class="text-2xl font-black text-gray-800 mt-2">

                                {{
                                    Number(space.price_per_hour).toLocaleString(
                                        'es-CO',
                                        {
                                            style: 'currency',
                                            currency: 'COP',
                                            minimumFractionDigits: 0
                                        }
                                    )
                                }}

                            </h3>

                        </div>

                        <!-- STATUS -->
                        <div class="bg-gray-50 rounded-3xl p-6">

                            <div class="text-4xl mb-4">
                                ✅
                            </div>

                            <p class="text-gray-400 text-sm">
                                Estado
                            </p>

                            <h3
                                v-if="space.is_active"
                                class="text-2xl font-black text-green-600 mt-2"
                            >

                                Activa

                            </h3>

                            <h3
                                v-else
                                class="text-2xl font-black text-red-600 mt-2"
                            >

                                Inactiva

                            </h3>

                        </div>

                        <!-- TYPE -->
                        <div class="bg-gray-50 rounded-3xl p-6">

                            <div class="text-4xl mb-4">
                                🏢
                            </div>

                            <p class="text-gray-400 text-sm">
                                Tipo
                            </p>

                            <h3 class="text-2xl font-black text-gray-800 mt-2">

                                Sala premium

                            </h3>

                        </div>

                    </div>

                </div>

                <!-- SIDEBAR -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 h-fit">

                    <h2 class="text-3xl font-black text-gray-800 mb-6">
                        Reservar
                    </h2>

                    <p class="text-gray-500 leading-relaxed mb-8">

                        Reserva este espacio de forma rápida y segura.
                        Consulta disponibilidad en tiempo real y selecciona el horario ideal.

                    </p>

                    <!-- BUTTON -->
                    <Link
                        :href="`/reservations/create?space=${space.id}`"
                        class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-bold shadow-lg transition duration-300 hover:scale-[1.02]"
                    >

                        📅 Reservar ahora

                    </Link>

                    <!-- BACK -->
                    <Link
                        href="/spaces"
                        class="block w-full text-center mt-4 border border-gray-200 hover:bg-gray-50 py-4 rounded-2xl font-semibold text-gray-700 transition"
                    >

                        ← Volver

                    </Link>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>