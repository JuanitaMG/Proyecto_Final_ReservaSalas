<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'

defineProps({

    spaces: Array

})

/*
|--------------------------------------------------------------------------
| ELIMINAR
|--------------------------------------------------------------------------
*/

const deleteSpace = (id) => {

    if (confirm('¿Eliminar esta sala?')) {

        router.delete(`/spaces/${id}`)

    }

}

</script>

<template>

    <AdminLayout>

        <div class="max-w-7xl mx-auto px-4">

            <!-- HEADER -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-12">

                <div>

                    <h1 class="text-5xl font-black text-gray-800 tracking-tight">
                        Salas
                    </h1>

                    <p class="text-gray-500 mt-3 text-lg">
                        Gestión moderna de salas y espacios disponibles
                    </p>

                </div>

                <!-- ADMIN -->
                <template v-if="$page.props.auth?.user?.role === 'admin'">

                    <Link
                        href="/spaces/create"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-7 py-4 rounded-2xl shadow-lg hover:scale-105 transition duration-300 font-semibold w-fit"
                    >

                        + Nueva sala

                    </Link>

                </template>

            </div>

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                <!-- CARD -->
                <div
                    v-for="space in spaces"
                    :key="space.id"
                    class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition duration-300"
                >

                    <!-- IMAGE -->
                    <div class="relative h-60 overflow-hidden">

                        <!-- IMAGE -->
                        <img
                            v-if="space.image"
                            :src="space.image"
                            :alt="space.name"
                            class="w-full h-full object-cover"
                        >

                        <!-- FALLBACK -->
                        <div
                            v-else
                            class="w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white text-7xl"
                        >

                            🏢

                        </div>

                        <!-- STATUS -->
                        <div class="absolute top-4 right-4">

                            <span
                                v-if="space.is_active"
                                class="bg-green-100/95 backdrop-blur text-green-700 text-xs font-bold px-4 py-2 rounded-full shadow"
                            >

                                ✅ Activa

                            </span>

                            <span
                                v-else
                                class="bg-red-100/95 backdrop-blur text-red-700 text-xs font-bold px-4 py-2 rounded-full shadow"
                            >

                                ❌ Inactiva

                            </span>

                        </div>

                    </div>

                    <!-- CONTENT -->
                    <div class="p-7">

                        <!-- TITLE -->
                        <div class="mb-6">

                            <h2 class="text-2xl font-black text-gray-800 leading-tight">

                                {{ space.name }}

                            </h2>

                            <p class="text-gray-400 mt-2">

                                Espacio profesional de reservas

                            </p>

                        </div>

                        <!-- DESCRIPTION -->
                        <p class="text-gray-600 leading-relaxed mb-6 min-h-[72px]">

                            {{ space.description }}

                        </p>

                        <!-- INFO -->
                        <div class="space-y-4">

                            <!-- CAPACITY -->
                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center text-xl">
                                    👥
                                </div>

                                <div>

                                    <p class="text-xs uppercase tracking-wide text-gray-400">
                                        Capacidad
                                    </p>

                                    <p class="font-semibold text-gray-700">
                                        {{ space.capacity }} personas
                                    </p>

                                </div>

                            </div>

                            <!-- PRICE -->
                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-xl">
                                    💰
                                </div>

                                <div>

                                    <p class="text-xs uppercase tracking-wide text-gray-400">
                                        Precio por hora
                                    </p>

                                    <p class="font-semibold text-gray-700">

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

                                    </p>

                                </div>

                            </div>

                        </div>

                        <!-- ACTIONS -->
                        <div class="mt-8 space-y-3">

                            <!-- RESERVAR -->
                            <template v-if="$page.props.auth?.user">

                                <Link
                                    href="/reservations/create"
                                    class="block text-center bg-indigo-600 text-white py-3 rounded-2xl hover:bg-indigo-700 transition duration-300 font-semibold shadow-md"
                                >

                                    Reservar sala

                                </Link>

                            </template>

                            <!-- INVITADO -->
                            <template v-else>

                                <Link
                                    href="/login"
                                    class="block text-center bg-gray-900 text-white py-3 rounded-2xl hover:bg-black transition duration-300 font-semibold"
                                >

                                    Inicia sesión para reservar

                                </Link>

                            </template>

                            <!-- ADMIN -->
                            <template v-if="$page.props.auth?.user?.role === 'admin'">

                                <div class="grid grid-cols-2 gap-3">

                                    <!-- EDIT -->
                                    <Link
                                        :href="`/spaces/${space.id}/edit`"
                                        class="bg-yellow-100 text-yellow-700 text-center py-3 rounded-2xl hover:bg-yellow-200 transition font-semibold"
                                    >

                                        ✏️ Editar

                                    </Link>

                                    <!-- DELETE -->
                                    <button
                                        @click="deleteSpace(space.id)"
                                        class="bg-red-100 text-red-600 py-3 rounded-2xl hover:bg-red-200 transition font-semibold"
                                    >

                                        🗑 Eliminar

                                    </button>

                                </div>

                            </template>

                        </div>

                    </div>

                </div>

            </div>

            <!-- EMPTY -->
            <div
                v-if="spaces.length === 0"
                class="bg-white rounded-3xl p-16 text-center text-gray-400 shadow-sm mt-10 border border-gray-100"
            >

                <div class="text-7xl mb-6">
                    🏢
                </div>

                <p class="text-2xl font-bold text-gray-700 mb-2">
                    No hay salas registradas
                </p>

                <p class="text-gray-400">
                    Crea una nueva sala para comenzar
                </p>

            </div>

        </div>

    </AdminLayout>

</template>