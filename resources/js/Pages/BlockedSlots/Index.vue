<script setup>

import { useForm } from '@inertiajs/vue3'

import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({

    blockedSlots: Array,

    spaces: Array

})

/*
|--------------------------------------------------------------------------
| FORM
|--------------------------------------------------------------------------
*/

const form = useForm({

    space_id: '',

    date: '',

    start_time: '',

    end_time: '',

    reason: ''

})

/*
|--------------------------------------------------------------------------
| GUARDAR
|--------------------------------------------------------------------------
*/

const submit = () => {

    form.post('/blocked-slots', {

        preserveScroll: true,

        onSuccess: () => {

            form.reset()

        }

    })

}

</script>

<template>

    <AdminLayout>

        <div class="max-w-7xl mx-auto">

            <!-- HEADER -->
            <div class="mb-10">

                <h1 class="text-5xl font-black text-gray-800">
                    Bloqueos
                </h1>

                <p class="text-gray-500 mt-3 text-lg">
                    Administra horarios bloqueados
                </p>

            </div>

            <!-- FORM -->
            <div
                class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-10"
            >

                <form
                    @submit.prevent="submit"
                    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-5"
                >

                    <!-- SALA -->
                    <select
                        v-model="form.space_id"
                        class="rounded-2xl border-gray-200"
                    >

                        <option value="">
                            Sala
                        </option>

                        <option
                            v-for="space in spaces"
                            :key="space.id"
                            :value="space.id"
                        >
                            {{ space.name }}
                        </option>

                    </select>

                    <!-- FECHA -->
                    <input
                        type="date"
                        v-model="form.date"
                        class="rounded-2xl border-gray-200"
                    >

                    <!-- INICIO -->
                    <input
                        type="time"
                        v-model="form.start_time"
                        class="rounded-2xl border-gray-200"
                    >

                    <!-- FIN -->
                    <input
                        type="time"
                        v-model="form.end_time"
                        class="rounded-2xl border-gray-200"
                    >

                    <!-- MOTIVO -->
                    <input
                        type="text"
                        v-model="form.reason"
                        placeholder="Motivo"
                        class="rounded-2xl border-gray-200"
                    >

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        class="md:col-span-2 xl:col-span-5 bg-red-500 hover:bg-red-600 text-white py-4 rounded-2xl font-bold transition"
                    >

                        🚫 Bloquear horario

                    </button>

                </form>

            </div>

            <!-- TABLE -->
            <div
                class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100"
            >

                <table class="w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="p-5 text-left">
                                Sala
                            </th>

                            <th class="p-5 text-left">
                                Fecha
                            </th>

                            <th class="p-5 text-left">
                                Horario
                            </th>

                            <th class="p-5 text-left">
                                Motivo
                            </th>

                            <th class="p-5 text-center">
                                Acción
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr
                            v-for="blocked in blockedSlots"
                            :key="blocked.id"
                            class="border-t"
                        >

                            <td class="p-5">
                                {{ blocked.space.name }}
                            </td>

                            <td class="p-5">
                                {{ blocked.date }}
                            </td>

                            <td class="p-5">
                                {{ blocked.start_time }}
                                -
                                {{ blocked.end_time }}
                            </td>

                            <td class="p-5">
                                {{ blocked.reason }}
                            </td>

                            <td class="p-5 text-center">

                                <button
                                    @click="$inertia.delete(`/blocked-slots/${blocked.id}`)"
                                    class="bg-red-100 text-red-600 px-4 py-2 rounded-xl hover:bg-red-200 transition"
                                >

                                    🗑️

                                </button>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </AdminLayout>

</template>