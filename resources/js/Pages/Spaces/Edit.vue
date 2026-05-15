<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'

const props = defineProps({
    space: Object
})

const form = useForm({

    name: props.space.name,

    capacity: props.space.capacity,

    description: props.space.description,

    price_per_hour: props.space.price_per_hour,

    location: props.space.location,

    is_active: props.space.is_active,

})

const submit = () => {

    form.put(`/spaces/${props.space.id}`)

}
</script>

<template>

    <AdminLayout>

        <div class="max-w-3xl mx-auto">

            <!-- HEADER -->
            <div class="flex items-center justify-between mb-10">

                <div>

                    <h1 class="text-5xl font-black text-gray-800">
                        Editar sala
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Actualiza la información de la sala
                    </p>

                </div>

                <!-- BACK -->
                <Link
                    href="/spaces"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-3 rounded-2xl transition font-semibold"
                >
                    ← Volver
                </Link>

            </div>

            <!-- CARD -->
            <div
                class="bg-white rounded-3xl shadow-xl border border-gray-100 p-10"
            >

                <form
                    @submit.prevent="submit"
                    class="space-y-6"
                >

                    <!-- NAME -->
                    <div>

                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Nombre de la sala
                        </label>

                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4"
                            placeholder="Sala Ejecutiva"
                        >

                        <div
                            v-if="form.errors.name"
                            class="text-red-500 text-sm mt-2"
                        >
                            {{ form.errors.name }}
                        </div>

                    </div>

                    <!-- CAPACITY -->
                    <div>

                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Capacidad
                        </label>

                        <input
                            v-model="form.capacity"
                            type="number"
                            class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4"
                            placeholder="20"
                        >

                        <div
                            v-if="form.errors.capacity"
                            class="text-red-500 text-sm mt-2"
                        >
                            {{ form.errors.capacity }}
                        </div>

                    </div>

                    <!-- LOCATION -->
                    <div>

                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Ubicación
                        </label>

                        <input
                            v-model="form.location"
                            type="text"
                            class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4"
                            placeholder="Piso 2"
                        >

                    </div>

                    <!-- PRICE -->
                    <div>

                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Precio por hora
                        </label>

                        <input
                            v-model="form.price_per_hour"
                            type="number"
                            class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4"
                            placeholder="50000"
                        >

                    </div>

                    <!-- DESCRIPTION -->
                    <div>

                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Descripción
                        </label>

                        <textarea
                            v-model="form.description"
                            rows="5"
                            class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Describe la sala..."
                        />

                        <div
                            v-if="form.errors.description"
                            class="text-red-500 text-sm mt-2"
                        >
                            {{ form.errors.description }}
                        </div>

                    </div>

                    <!-- ACTIVE -->
                    <div class="flex items-center gap-4">

                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        >

                        <span class="font-medium text-gray-700">
                            Sala activa
                        </span>

                    </div>

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 rounded-2xl font-bold text-lg hover:scale-[1.01] transition duration-300 shadow-xl"
                    >
                        Guardar cambios
                    </button>

                </form>

            </div>

        </div>

    </AdminLayout>

</template>