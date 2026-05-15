<script setup>

import { useForm } from '@inertiajs/vue3'

import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({

    spaces: Array,

    selectedDate: String,

    selectedSpace: [String, Number]

})

/*
|--------------------------------------------------------------------------
| FORM
|--------------------------------------------------------------------------
*/

const form = useForm({

    space_id: props.selectedSpace || '',

    date: props.selectedDate || '',

    start_time: '',

    end_time: ''

})

</script>

<template>

    <AdminLayout>

        <div class="max-w-3xl mx-auto">

            <!-- HEADER -->
            <div class="mb-10">

                <h1 class="text-5xl font-black text-gray-800 tracking-tight">
                    Nueva Reserva
                </h1>

                <p class="text-gray-500 mt-3 text-lg">
                    Reserva una sala de reuniones
                </p>

            </div>

            <!-- CARD -->
            <div
                class="bg-white/80 backdrop-blur-xl rounded-3xl p-10 shadow-xl border border-white/50"
            >

                <form
                    @submit.prevent="form.post('/reservations')"
                    class="space-y-8"
                >

                    <!-- SALA -->
                    <div>

                        <label
                            class="block text-sm font-semibold text-gray-700 mb-3"
                        >
                            Sala
                        </label>

                        <select
                            v-model="form.space_id"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"
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

                        <label
                            class="block text-sm font-semibold text-gray-700 mb-3"
                        >
                            Fecha
                        </label>

                        <input
                            type="date"
                            v-model="form.date"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"
                        >

                        <!-- ERROR -->
                        <p
                            v-if="form.errors.date"
                            class="text-red-500 text-sm mt-2"
                        >
                            {{ form.errors.date }}
                        </p>

                    </div>

                    <!-- HORAS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- HORA INICIO -->
                        <div>

                            <label
                                class="block text-sm font-semibold text-gray-700 mb-3"
                            >
                                Hora inicio
                            </label>

                            <input
                                type="time"
                                v-model="form.start_time"
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"
                            >

                            <!-- ERROR -->
                            <p
                                v-if="form.errors.start_time"
                                class="text-red-500 text-sm mt-2"
                            >
                                {{ form.errors.start_time }}
                            </p>

                        </div>

                        <!-- HORA FIN -->
                        <div>

                            <label
                                class="block text-sm font-semibold text-gray-700 mb-3"
                            >
                                Hora fin
                            </label>

                            <input
                                type="time"
                                v-model="form.end_time"
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"
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

                    <!-- ERROR GENERAL -->
                    <div
                        v-if="form.errors.error"
                        class="bg-red-100 text-red-700 px-5 py-4 rounded-2xl font-medium"
                    >

                        {{ form.errors.error }}

                    </div>

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:scale-[1.02] disabled:opacity-50 disabled:hover:scale-100 text-white py-4 rounded-2xl font-bold text-lg shadow-xl transition duration-300"
                    >

                        <span v-if="form.processing">
                            Reservando...
                        </span>

                        <span v-else>
                            Reservar sala
                        </span>

                    </button>

                </form>

            </div>

        </div>

    </AdminLayout>

</template>