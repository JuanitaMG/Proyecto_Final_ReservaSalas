<script setup>

import { ref } from 'vue'

import AdminLayout from '@/Layouts/AdminLayout.vue'

import {
    Link,
    router
} from '@inertiajs/vue3'

defineProps({

    spaces: Array

})

/*
|--------------------------------------------------------------------------
| MODAL ELIMINAR
|--------------------------------------------------------------------------
*/

const showDeleteModal = ref(false)

const selectedSpace = ref(null)

const openDeleteModal = (space) => {

    selectedSpace.value = space

    showDeleteModal.value = true

}

const closeDeleteModal = () => {

    showDeleteModal.value = false

    selectedSpace.value = null

}

const deleteSpace = () => {

    router.delete(`/spaces/${selectedSpace.value.id}`, {

        onSuccess: () => {

            closeDeleteModal()

        }

    })

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
                            :src="space.image.startsWith('http')
                                ? space.image
                                : `/storage/${space.image}`"
                            :alt="space.name"
                            class="w-full h-full object-cover hover:scale-105 transition duration-500"
                        >

                        <!-- FALLBACK -->
                        <div
                            v-else
                            class="w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white text-7xl"
                        >

                            🏢

                        </div>

                        <!-- OVERLAY -->
                        <div class="absolute inset-0 bg-black/10" />

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

                            <!-- VER DETALLE -->
                            <Link
                                :href="`/spaces/${space.slug}`"
                                class="block text-center bg-indigo-600 text-white py-3 rounded-2xl hover:bg-indigo-700 transition duration-300 font-semibold shadow-md"
                            >

                                🔍 Ver detalles

                            </Link>

                            <!-- RESERVAR -->
                            <template v-if="$page.props.auth?.user">

                                <Link
                                    :href="`/reservations/create?space=${space.id}`"
                                    class="block text-center border border-indigo-200 text-indigo-600 py-3 rounded-2xl hover:bg-indigo-50 transition duration-300 font-semibold"
                                >

                                    📅 Reservar sala

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
                                        @click="openDeleteModal(space)"
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

        <!-- MODAL ELIMINAR -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        >

            <div
                class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8"
            >

                <!-- ICON -->
                <div
                    class="w-20 h-20 mx-auto rounded-full bg-red-100 flex items-center justify-center text-4xl mb-6"
                >
                    🗑️
                </div>

                <!-- TITLE -->
                <h2 class="text-3xl font-black text-gray-800 text-center mb-3">
                    Eliminar sala
                </h2>

                <!-- TEXT -->
                <p class="text-gray-500 text-center leading-relaxed mb-8">

                    ¿Seguro que deseas eliminar

                    <span class="font-bold text-gray-700">
                        {{ selectedSpace?.name }}
                    </span>?

                    Esta acción no se puede deshacer.

                </p>

                <!-- BUTTONS -->
                <div class="flex gap-4">

                    <!-- CANCEL -->
                    <button
                        @click="closeDeleteModal"
                        class="flex-1 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition"
                    >

                        Cancelar

                    </button>

                    <!-- DELETE -->
                    <button
                        @click="deleteSpace"
                        class="flex-1 py-3 rounded-2xl bg-red-500 hover:bg-red-600 text-white font-bold shadow-lg transition"
                    >

                        Sí, eliminar

                    </button>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>