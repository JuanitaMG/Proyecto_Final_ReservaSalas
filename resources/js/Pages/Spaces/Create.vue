<script setup>

import { useForm, Link } from '@inertiajs/vue3'

import AdminLayout from '@/Layouts/AdminLayout.vue'

const form = useForm({

    name: '',
    capacity: '',
    description: '',
    price_per_hour: '',
    image: null

})

const submit = () => {

    form.post('/spaces')

}

</script>

<template>

    <AdminLayout>

        <div class="max-w-4xl mx-auto">

            <!-- HEADER -->
            <div class="flex items-center justify-between mb-8">

                <div>

                    <h1 class="text-4xl font-black text-gray-800">
                        Crear sala
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Agrega una nueva sala al sistema
                    </p>

                </div>

                <!-- REGRESAR -->
                <Link
                    href="/spaces"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-3 rounded-2xl font-semibold transition"
                >
                    ← Regresar
                </Link>

            </div>

            <!-- FORM -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

                <form
                    @submit.prevent="submit"
                    class="space-y-6"
                >

                    <!-- NOMBRE -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nombre
                        </label>

                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Nombre de la sala"
                            class="w-full rounded-2xl border border-gray-200 px-4 py-3 bg-gray-50"
                        >

                    </div>

                    <!-- CAPACIDAD -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Capacidad
                        </label>

                        <input
                            v-model="form.capacity"
                            type="number"
                            placeholder="Capacidad"
                            class="w-full rounded-2xl border border-gray-200 px-4 py-3 bg-gray-50"
                        >

                    </div>

                    <!-- DESCRIPCIÓN -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Descripción
                        </label>

                        <textarea
                            v-model="form.description"
                            rows="4"
                            placeholder="Descripción"
                            class="w-full rounded-2xl border border-gray-200 px-4 py-3 bg-gray-50"
                        />

                    </div>

                    <!-- PRECIO -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Precio por hora
                        </label>

                        <input
                            v-model="form.price_per_hour"
                            type="number"
                            placeholder="Precio por hora"
                            class="w-full rounded-2xl border border-gray-200 px-4 py-3 bg-gray-50"
                        >

                    </div>

                    <!-- IMAGEN -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Imagen de la sala
                        </label>

                        <input
                            type="file"
                            @change="form.image = $event.target.files[0]"
                            class="w-full rounded-2xl border border-gray-200 px-4 py-3 bg-gray-50"
                        >

                    </div>

                    <!-- BOTÓN -->
                    <button
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl font-bold transition"
                    >
                        Guardar sala
                    </button>

                </form>

            </div>

        </div>

    </AdminLayout>

</template>