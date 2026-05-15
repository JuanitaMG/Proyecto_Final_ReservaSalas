<script setup>

import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({

    reservation: Object,
    spaces: Array

})

const form = useForm({

    space_id: props.reservation.space_id,

    date: props.reservation.date,

    start_time: props.reservation.start_time,

    end_time: props.reservation.end_time,

})

const submit = () => {

    form.put(`/reservations/${props.reservation.id}`)

}

</script>

<template>

    <AdminLayout>

        <div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 p-8">

            <div class="max-w-3xl mx-auto">

                <!-- HEADER -->
                <div class="mb-8">

                    <h1 class="text-4xl font-black text-gray-800">
                        Editar reserva
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Actualiza la información de la reserva
                    </p>

                </div>

                <!-- CARD -->
                <div class="bg-white rounded-3xl shadow-xl p-8">

                    <form
                        @submit.prevent="submit"
                        class="space-y-6"
                    >

                        <!-- SALA -->
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Sala
                            </label>

                            <select
                                v-model="form.space_id"
                                class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4"
                            >

                                <option value="">
                                    Selecciona una sala
                                </option>

                                <option
                                    v-for="space in spaces"
                                    :key="space.id"
                                    :value="space.id"
                                >
                                    {{ space.name }}
                                </option>

                            </select>

                            <!-- ERROR -->
                            <p
                                v-if="form.errors.space_id"
                                class="text-red-500 text-sm mt-2"
                            >
                                {{ form.errors.space_id }}
                            </p>

                        </div>

                        <!-- FECHA -->
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Fecha
                            </label>

                            <input
                                v-model="form.date"
                                type="date"
                                class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4"
                            >

                            <!-- ERROR -->
                            <p
                                v-if="form.errors.date"
                                class="text-red-500 text-sm mt-2"
                            >
                                {{ form.errors.date }}
                            </p>

                        </div>

                        <!-- HORARIOS -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- INICIO -->
                            <div>

                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Hora inicio
                                </label>

                                <input
                                    v-model="form.start_time"
                                    type="time"
                                    class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4"
                                >

                                <!-- ERROR -->
                                <p
                                    v-if="form.errors.start_time"
                                    class="text-red-500 text-sm mt-2"
                                >
                                    {{ form.errors.start_time }}
                                </p>

                            </div>

                            <!-- FIN -->
                            <div>

                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Hora fin
                                </label>

                                <input
                                    v-model="form.end_time"
                                    type="time"
                                    class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4"
                                >

                                <!-- ERROR -->
                                <p
                                    v-if="form.errors.end_time"
                                    class="text-red-500 text-sm mt-2"
                                >
                                    {{ form.errors.end_time }}
                                </p>

                            </div>

                        </div>

                        <!-- BOTONES -->
                        <div class="flex gap-4 pt-4">

                            <!-- GUARDAR -->
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white py-4 rounded-2xl font-bold shadow-lg transition"
                            >
                                {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                            </button>

                            <!-- VOLVER -->
                            <a
                                href="/reservations"
                                class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 py-4 rounded-2xl font-bold transition"
                            >
                                Volver
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>