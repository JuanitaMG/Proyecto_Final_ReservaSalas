<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({
    canResetPassword: Boolean,
    status: String,
})

const showPassword = ref(false)

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'))
}
</script>

<template>

    <Head title="Iniciar sesión" />

    <div class="min-h-screen flex">

        <!-- LEFT -->
        <div
            class="hidden lg:flex w-1/2 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 items-center justify-center p-16 relative overflow-hidden"
        >

            <!-- DECORATION -->
            <div class="absolute w-96 h-96 bg-white/10 rounded-full top-[-100px] left-[-100px]"></div>
            <div class="absolute w-72 h-72 bg-white/10 rounded-full bottom-[-80px] right-[-80px]"></div>

            <div class="relative z-10 text-white max-w-lg">

                <!-- TITLE -->
                <h1 class="text-6xl font-black leading-tight">
                    ReservasPro
                </h1>

                <!-- DESCRIPTION -->
                <p class="mt-6 text-xl text-indigo-100 leading-relaxed">
                    Plataforma profesional para la gestión de salas de reuniones,
                    reservas y disponibilidad en tiempo real.
                </p>

                <!-- BUTTONS -->
                <div class="mt-10 flex gap-4">

                    <!-- VER SALAS -->
                    <Link
                        href="/spaces"
                        class="bg-white/10 backdrop-blur-xl px-6 py-4 rounded-2xl text-white hover:bg-white/20 transition font-semibold"
                    >
                        🏢 Ver salas
                    </Link>

                    <!-- DISPONIBILIDAD -->
                    <Link
                        href="/availability"
                        class="bg-white/10 backdrop-blur-xl px-6 py-4 rounded-2xl text-white hover:bg-white/20 transition font-semibold"
                    >
                        ⚡ Disponibilidad
                    </Link>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div
            class="w-full lg:w-1/2 flex items-center justify-center bg-gray-100 p-8"
        >

            <div
                class="w-full max-w-md bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-10 border border-white/50"
            >

                <!-- HEADER -->
                <div class="mb-10 text-center">

                    <h2 class="text-4xl font-black text-gray-800">
                        Bienvenido
                    </h2>

                    <p class="text-gray-500 mt-3">
                        Inicia sesión para continuar
                    </p>

                </div>

                <!-- STATUS -->
                <div
                    v-if="status"
                    class="mb-6 bg-green-100 text-green-700 px-4 py-3 rounded-2xl"
                >
                    {{ status }}
                </div>

                <!-- FORM -->
                <form @submit.prevent="submit" class="space-y-6">

                    <!-- EMAIL -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Correo electrónico
                        </label>

                        <input
                            v-model="form.email"
                            type="email"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"
                            placeholder="admin@gmail.com"
                        />

                        <div
                            v-if="form.errors.email"
                            class="text-red-500 text-sm mt-2"
                        >
                            {{ form.errors.email }}
                        </div>

                    </div>

                    <!-- PASSWORD -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Contraseña
                        </label>

                        <div class="relative">

                            <input
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 pr-14 text-gray-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"
                                placeholder="••••••••"
                            />

                            <!-- OJITO -->
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-indigo-600"
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

                    <!-- REMEMBER -->
                    <div class="flex items-center justify-between">

                        <label class="flex items-center gap-3">

                            <input
                                v-model="form.remember"
                                type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            >

                            <span class="text-sm text-gray-600">
                                Recordarme
                            </span>

                        </label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm text-indigo-600 hover:text-indigo-700"
                        >
                            ¿Olvidaste tu contraseña?
                        </Link>

                    </div>

                    <!-- LOGIN BUTTON -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:scale-[1.02] text-white py-4 rounded-2xl font-bold text-lg shadow-xl transition duration-300"
                    >
                        Iniciar sesión
                    </button>

                    <!-- REGISTER -->
                    <div class="text-center pt-4">

                        <p class="text-gray-500 text-sm">
                            ¿No tienes cuenta?
                        </p>

                        <Link
                            href="/register"
                            class="text-indigo-600 font-semibold hover:text-indigo-700"
                        >
                            Crear usuario
                        </Link>

                    </div>

                </form>

            </div>

        </div>

    </div>

</template>