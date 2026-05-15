<script setup>

import { useForm, router } from '@inertiajs/vue3'

import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({

    spaces: Array,

    allSpaces: Array,

    availabilities: Array

})

/*
|--------------------------------------------------------------------------
| DÍAS
|--------------------------------------------------------------------------
*/

const days = [

    'Domingo',
    'Lunes',
    'Martes',
    'Miércoles',
    'Jueves',
    'Viernes',
    'Sábado'

]

/*
|--------------------------------------------------------------------------
| FORM
|--------------------------------------------------------------------------
*/

const form = useForm({

    space_id: '',
    day_of_week: '',
    start_time: '',
    end_time: ''

})

/*
|--------------------------------------------------------------------------
| ELIMINAR DISPONIBILIDAD
|--------------------------------------------------------------------------
*/

const deleteAvailability = (id) => {

    if (confirm('¿Eliminar disponibilidad?')) {

        router.delete(`/availabilities/${id}`)

    }

}

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
                    class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-1 transition duration-300"
                >

                    <!-- IMAGE -->
                    <div class="relative h-44 overflow-hidden">

                        <!-- IMAGE -->
                        <img
                            v-if="space.image"
                            :src="space.image.startsWith('http')
                                ? space.image
                                : `/storage/${space.image}`"
                            :alt="space.name"
                            class="w-full h-full object-cover"
                        >

                        <!-- FALLBACK -->
                        <div
                            v-else
                            class="w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white text-6xl"
                        >

                            🏢

                        </div>

                        <!-- OVERLAY -->
                        <div class="absolute inset-0 bg-black/10" />

                        <!-- STATUS -->
                        <div class="absolute top-4 right-4">

                            <!-- DISPONIBLE -->
                            <span
                                v-if="space.status === 'available'"
                                class="bg-green-100/95 backdrop-blur text-green-700 px-4 py-2 rounded-full text-sm font-bold shadow"
                            >
                                🟢 Disponible
                            </span>

                            <!-- OCUPADA -->
                            <span
                                v-else-if="space.status === 'busy'"
                                class="bg-red-100/95 backdrop-blur text-red-700 px-4 py-2 rounded-full text-sm font-bold shadow"
                            >
                                🔴 Sala ocupada
                            </span>

                            <!-- INACTIVA -->
                            <span
                                v-else-if="space.status === 'inactive'"
                                class="bg-red-100/95 backdrop-blur text-red-700 px-4 py-2 rounded-full text-sm font-bold shadow"
                            >
                                ❌ No disponible
                            </span>

                            <!-- PRÓXIMA -->
                            <span
                                v-else-if="space.status === 'soon'"
                                class="bg-yellow-100/95 backdrop-blur text-yellow-700 px-4 py-2 rounded-full text-sm font-bold shadow"
                            >
                                🟡 Próxima reserva
                            </span>

                        </div>

                    </div>

                    <!-- CONTENT -->
                    <div class="p-8">

                        <!-- TOP -->
                        <div>

                            <h2 class="text-2xl font-bold text-gray-800">
                                {{ space.name }}
                            </h2>

                            <p class="text-gray-400 mt-1">
                                {{ space.location }}
                            </p>

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
                            <div v-else-if="space.status === 'busy'">

                                <p class="text-red-600 text-lg font-bold">
                                    Sala ocupada
                                </p>

                                <p class="text-gray-500 mt-2">

                                    Ocupada desde

                                    {{ space.start_time }}

                                    hasta

                                    {{ space.end_time }}

                                </p>

                            </div>

                            <!-- INACTIVA -->
                            <div v-else-if="space.status === 'inactive'">

                                <p class="text-red-600 text-lg font-bold">
                                    Sala deshabilitada
                                </p>

                                <p class="text-gray-500 mt-2">
                                    No disponible actualmente
                                </p>

                            </div>

                            <!-- PRÓXIMA -->
                            <div v-else-if="space.status === 'soon'">

                                <p class="text-yellow-600 text-lg font-bold">
                                    Reserva próxima
                                </p>

                                <p class="text-gray-500 mt-2">
                                    Inicia pronto
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- SOLO ADMIN -->
            <div
                v-if="$page.props.auth.user?.role === 'admin'"
                class="mt-16"
            >

                <!-- TITLE -->
                <div class="mb-8">

                    <h2 class="text-4xl font-black text-gray-800">
                        Disponibilidad semanal
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Configura horarios permitidos para cada sala
                    </p>

                </div>

                <!-- FORM -->
                <div
                    class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-10"
                >

                    <form
                        @submit.prevent="form.post('/availabilities')"
                        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-5"
                    >

                        <!-- SALA -->
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Sala
                            </label>

                            <select
                                v-model="form.space_id"
                                class="w-full rounded-2xl border border-gray-200 px-4 py-3 bg-gray-50"
                            >

                                <option value="">
                                    Selecciona
                                </option>

                                <option
                                    v-for="space in allSpaces"
                                    :key="space.id"
                                    :value="space.id"
                                >
                                    {{ space.name }}
                                </option>

                            </select>

                        </div>

                        <!-- DÍA -->
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Día
                            </label>

                            <select
                                v-model="form.day_of_week"
                                class="w-full rounded-2xl border border-gray-200 px-4 py-3 bg-gray-50"
                            >

                                <option value="">
                                    Selecciona
                                </option>

                                <option
                                    v-for="(day, index) in days"
                                    :key="index"
                                    :value="index"
                                >
                                    {{ day }}
                                </option>

                            </select>

                        </div>

                        <!-- HORA INICIO -->
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Hora inicio
                            </label>

                            <input
                                type="time"
                                v-model="form.start_time"
                                class="w-full rounded-2xl border border-gray-200 px-4 py-3 bg-gray-50"
                            >

                        </div>

                        <!-- HORA FIN -->
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Hora fin
                            </label>

                            <input
                                type="time"
                                v-model="form.end_time"
                                class="w-full rounded-2xl border border-gray-200 px-4 py-3 bg-gray-50"
                            >

                        </div>

                        <!-- BUTTON -->
                        <div class="flex items-end">

                            <button
                                type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-2xl font-bold transition"
                            >
                                Guardar
                            </button>

                        </div>

                    </form>

                </div>

                <!-- TABLE -->
                <div
                    class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden"
                >

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <!-- HEAD -->
                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="p-5 text-left text-gray-500 uppercase text-xs">
                                        Sala
                                    </th>

                                    <th class="p-5 text-left text-gray-500 uppercase text-xs">
                                        Día
                                    </th>

                                    <th class="p-5 text-left text-gray-500 uppercase text-xs">
                                        Inicio
                                    </th>

                                    <th class="p-5 text-left text-gray-500 uppercase text-xs">
                                        Fin
                                    </th>

                                    <th class="p-5 text-center text-gray-500 uppercase text-xs">
                                        Acción
                                    </th>

                                </tr>

                            </thead>

                            <!-- BODY -->
                            <tbody>

                                <tr
                                    v-for="availability in availabilities"
                                    :key="availability.id"
                                    class="border-t border-gray-100 hover:bg-gray-50 transition"
                                >

                                    <!-- SALA -->
                                    <td class="p-5 font-semibold text-gray-800">
                                        {{ availability.space.name }}
                                    </td>

                                    <!-- DÍA -->
                                    <td class="p-5 text-gray-600">
                                        {{ days[availability.day_of_week] }}
                                    </td>

                                    <!-- INICIO -->
                                    <td class="p-5 text-gray-600">
                                        {{ availability.start_time }}
                                    </td>

                                    <!-- FIN -->
                                    <td class="p-5 text-gray-600">
                                        {{ availability.end_time }}
                                    </td>

                                    <!-- BUTTON -->
                                    <td class="p-5 text-center">

                                        <button
                                            @click="deleteAvailability(availability.id)"
                                            class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-xl font-semibold transition"
                                        >
                                            🗑 Eliminar
                                        </button>

                                    </td>

                                </tr>

                                <!-- EMPTY -->
                                <tr v-if="availabilities.length === 0">

                                    <td
                                        colspan="5"
                                        class="p-14 text-center text-gray-400"
                                    >

                                        <div class="text-5xl mb-4">
                                            ⏰
                                        </div>

                                        <p class="text-xl font-bold">
                                            No hay disponibilidades configuradas
                                        </p>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>