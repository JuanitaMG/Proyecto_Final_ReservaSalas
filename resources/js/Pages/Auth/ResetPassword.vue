<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    email: String,
    token: String,
})

const showPassword = ref(false)
const showConfirmPassword = ref(false)

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('password.store'))
}
</script>

<template>

    <Head title="Restablecer contraseña" />

    <div class="min-h-screen flex">

        <!-- LEFT -->
        <div
            class="hidden lg:flex w-1/2 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 relative overflow-hidden"
        >

            <div class="absolute top-0 left-0 w-80 h-80 bg-white/10 rounded-full"></div>

            <div class="absolute bottom-0 right-0 w-80 h-80 bg-white/10 rounded-full"></div>

            <div class="relative z-10 flex flex-col justify-center px-20 text-white">

                <h1 class="text-7xl font-black mb-8">
                    ReservasPro
                </h1>

                <p class="text-2xl leading-relaxed text-white/90">
                    Restablece tu contraseña y vuelve a gestionar
                    tus reservas fácilmente.
                </p>

            </div>

        </div>

        <!-- RIGHT -->
        <div
            class="flex-1 flex items-center justify-center bg-[#f5f7fb] p-10"
        >

            <div
                class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-10"
            >

                <!-- HEADER -->
                <div class="text-center mb-8">

                    <h2 class="text-5xl font-black text-gray-800 mb-3">
                        Nueva contraseña
                    </h2>

                    <p class="text-gray-500">
                        Ingresa tu nueva contraseña
                    </p>

                </div>

                <!-- FORM -->
                <form @submit.prevent="submit" class="space-y-5">

                    <!-- EMAIL -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Correo electrónico
                        </label>

                        <input
                            v-model="form.email"
                            type="email"
                            class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4"
                        >

                        <div
                            v-if="form.errors.email"
                            class="text-red-500 text-sm mt-2"
                        >
                            {{ form.errors.email }}
                        </div>

                    </div>

                    <!-- PASSWORD -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nueva contraseña
                        </label>

                        <div class="relative">

                            <input
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4 pr-14"
                            >

                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2"
                            >
                                {{ showPassword ? '🙈' : '👁️' }}
                            </button>

                        </div>

                        <div
                            v-if="form.errors.password"
                            class="text-red-500 text-sm mt-2"
                        >
                            {{ form.errors.password }}
                        </div>

                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmar contraseña
                        </label>

                        <div class="relative">

                            <input
                                v-model="form.password_confirmation"
                                :type="showConfirmPassword ? 'text' : 'password'"
                                class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4 pr-14"
                            >

                            <button
                                type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2"
                            >
                                {{ showConfirmPassword ? '🙈' : '👁️' }}
                            </button>

                        </div>

                    </div>

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:opacity-90 text-white py-4 rounded-2xl font-bold text-lg shadow-lg transition"
                    >
                        Restablecer contraseña
                    </button>

                    <!-- BACK -->
                    <div class="text-center pt-2">

                        <Link
                            href="/login"
                            class="text-indigo-600 hover:text-indigo-700 text-sm font-semibold"
                        >
                            ← Volver al login
                        </Link>

                    </div>

                </form>

            </div>

        </div>

    </div>

</template>