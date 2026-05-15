<script setup>

import {
    onMounted,
    onUnmounted
} from 'vue'

import AdminLayout from '@/Layouts/AdminLayout.vue'

defineProps({

    spaces: Array

})

/*
|--------------------------------------------------------------------------
| AUTO REFRESH
|--------------------------------------------------------------------------
*/

let interval = null

onMounted(() => {

    interval = setInterval(() => {

        window.location.reload()

    }, 10000)

})

onUnmounted(() => {

    clearInterval(interval)

})

</script>

<template>

    <AdminLayout>

        <div class="max-w-7xl mx-auto">

            <!-- HEADER -->
            <div class="mb-12">

                <h1 class="text-5xl font-black text-gray-800">
                    Disponibilidad en tiempo real
                </h1>

                <p class="text-gray-500 mt-3 text-lg">
                    Estado actual de las salas
                </p>

            </div>

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                <!-- CARD -->
                <div
                    v-for="space in spaces"
                    :key="space.id"
                    class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-1 transition duration-300"
                >

                    <!-- TOP -->
                    <div class="flex justify-between items-start">

                        <div>

                            <h2 class="text-2xl font-bold text-gray-800">
                                {{ space.name }}
                            </h2>

                            <p class="text-gray-400 mt-1">
                                {{ space.location }}
                            </p>

                        </div>

                        <!-- STATUS -->
                        <div>

                            <!-- DISPONIBLE -->
                            <span
                                v-if="space.status === 'available'"
                                class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold"
                            >
                                🟢 Disponible
                            </span>

                            <!-- OCUPADA -->
                            <span
                                v-if="space.status === 'busy'"
                                class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold"
                            >
                                🔴 Ocupada
                            </span>

                            <!-- PRÓXIMA -->
                            <span
                                v-if="space.status === 'soon'"
                                class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-bold"
                            >
                                🟡 Próxima reserva
                            </span>

                        </div>

                    </div>

                    <!-- INFO -->
                    <div class="mt-8">

                        <!-- DISPONIBLE -->
                        <div v-if="space.status === 'available'">

                            <p class="text-gray-700 text-lg font-semibold">
                                Libre ahora
                            </p>

                            <p class="text-gray-400 mt-2">
                                Disponible para reservar
                            </p>

                        </div>

                        <!-- OCUPADA -->
                        <div v-if="space.status === 'busy'">

                            <p class="text-gray-700 text-lg font-semibold">
                                Sala ocupada
                            </p>

                            <p class="text-gray-400 mt-2">
                                {{ space.start_time }} - {{ space.end_time }}
                            </p>

                        </div>

                        <!-- PRÓXIMA -->
                        <div v-if="space.status === 'soon'">

                            <p class="text-gray-700 text-lg font-semibold">
                                Reserva próxima
                            </p>

                            <p class="text-gray-400 mt-2">
                                Inicia pronto
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>