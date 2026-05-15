<script setup>

import { ref, computed, onMounted } from 'vue'

import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

/*
|--------------------------------------------------------------------------
| DARK MODE
|--------------------------------------------------------------------------
*/

const darkMode = ref(false)

const toggleDarkMode = () => {

    darkMode.value = !darkMode.value

}

/*
|--------------------------------------------------------------------------
| MOBILE MENU
|--------------------------------------------------------------------------
*/

const sidebarOpen = ref(false)

const toggleSidebar = () => {

    sidebarOpen.value = !sidebarOpen.value

}

onMounted(() => {

    if (window.innerWidth >= 1024) {

        sidebarOpen.value = true

    }

})

/*
|--------------------------------------------------------------------------
| ACTIVE LINKS
|--------------------------------------------------------------------------
*/

const currentUrl = computed(() => page.url)

const isActive = (path) => {

    return currentUrl.value.startsWith(path)

}

</script>

<template>

    <div
        :class="darkMode ? 'dark bg-[#0f172a]' : 'bg-[#f5f7fb]'"
        class="flex min-h-screen transition-all duration-500"
    >

        <!-- MOBILE OVERLAY -->
        <div
            v-if="sidebarOpen"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-40 lg:hidden"
        />

        <!-- SIDEBAR -->
        <aside
            :class="[

                darkMode
                    ? 'bg-[#111827] border-gray-800'
                    : 'bg-white border-gray-200',

                sidebarOpen
                    ? 'translate-x-0'
                    : '-translate-x-full lg:translate-x-0'

            ]"
            class="fixed lg:static z-50 w-72 h-screen border-r flex flex-col justify-between transition-all duration-500 shadow-xl"
        >

            <!-- TOP -->
            <div>

                <!-- LOGO -->
                <div
                    :class="darkMode
                        ? 'border-gray-800'
                        : 'border-gray-100'"
                    class="p-8 border-b transition-all duration-500"
                >

                    <div class="flex items-center justify-between">

                        <div>

                            <h1 class="text-3xl font-black text-indigo-500 tracking-tight">
                                ReservasPro
                            </h1>

                            <p
                                :class="darkMode
                                    ? 'text-gray-500'
                                    : 'text-gray-400'"
                                class="text-sm mt-1"
                            >
                                Sistema de Salas
                            </p>

                        </div>

                        <!-- DARK BUTTON -->
                        <button
                            @click="toggleDarkMode"
                            class="w-12 h-12 rounded-2xl bg-indigo-500 hover:bg-indigo-600 text-white shadow-lg transition hover:scale-105"
                        >
                            {{ darkMode ? '☀️' : '🌙' }}
                        </button>

                    </div>

                </div>

                <!-- NAV -->
                <nav class="p-5 space-y-3">

                    <!-- DASHBOARD -->
                    <template v-if="page.props.auth?.user?.role === 'admin'">

                        <Link
                            href="/admin"
                            :class="[

                                isActive('/admin')
                                    ? 'bg-indigo-600 text-white shadow-lg scale-[1.02]'
                                    : darkMode
                                        ? 'text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-400'
                                        : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600'

                            ]"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 font-semibold"
                        >
                            📊 Dashboard
                        </Link>

                    </template>

                    <!-- SALAS -->
                    <Link
                        href="/spaces"
                        :class="[

                            isActive('/spaces')
                                ? 'bg-indigo-600 text-white shadow-lg scale-[1.02]'
                                : darkMode
                                    ? 'text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-400'
                                    : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600'

                        ]"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 font-semibold"
                    >
                        🏢 Salas
                    </Link>

                    <!-- SOLO LOGUEADOS -->
                    <template v-if="page.props.auth?.user">

                        <!-- RESERVAS -->
                        <Link
                            href="/reservations"
                            :class="[

                                isActive('/reservations')
                                    ? 'bg-indigo-600 text-white shadow-lg scale-[1.02]'
                                    : darkMode
                                        ? 'text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-400'
                                        : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600'

                            ]"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 font-semibold"
                        >
                            📅 Reservas
                        </Link>

                        <!-- CALENDARIO -->
                        <Link
                            href="/calendar"
                            :class="[

                                isActive('/calendar')
                                    ? 'bg-indigo-600 text-white shadow-lg scale-[1.02]'
                                    : darkMode
                                        ? 'text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-400'
                                        : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600'

                            ]"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 font-semibold"
                        >
                            🗓 Calendario
                        </Link>

                        <!-- DISPONIBILIDAD -->
                        <Link
                            href="/availability"
                            :class="[

                                isActive('/availability')
                                    ? 'bg-indigo-600 text-white shadow-lg scale-[1.02]'
                                    : darkMode
                                        ? 'text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-400'
                                        : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600'

                            ]"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 font-semibold"
                        >
                            ⚡ Disponibilidad
                        </Link>

                        <!-- BLOQUEOS -->
                        <template v-if="page.props.auth?.user?.role === 'admin'">

                            <Link
                                href="/blocked-slots"
                                :class="[

                                    isActive('/blocked-slots')
                                        ? 'bg-indigo-600 text-white shadow-lg scale-[1.02]'
                                        : darkMode
                                            ? 'text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-400'
                                            : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600'

                                ]"
                                class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 font-semibold"
                            >
                                🚫 Bloqueos
                            </Link>

                        </template>

                    </template>

                </nav>

            </div>

            <!-- USER / INVITADO -->
            <div class="p-5">

                <!-- USER -->
                <div
                    v-if="page.props.auth?.user"
                    class="bg-gradient-to-r from-indigo-500 to-purple-500 p-5 rounded-3xl text-white shadow-2xl"
                >

                    <!-- INFO -->
                    <div>

                        <p class="font-bold text-lg">
                            {{ page.props.auth.user.name }}
                        </p>

                        <p class="text-sm opacity-80 break-all">
                            {{ page.props.auth.user.email }}
                        </p>

                        <!-- ROLE -->
                        <div class="mt-3">

                            <!-- ADMIN -->
                            <span
                                v-if="page.props.auth.user.role === 'admin'"
                                class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full"
                            >
                                👑 Administrador
                            </span>

                            <!-- USER -->
                            <span
                                v-else
                                class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full"
                            >
                                👤 Usuario
                            </span>

                        </div>

                    </div>

                    <!-- LOGOUT -->
                    <div class="mt-5">

                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            class="w-full bg-white/20 hover:bg-white/30 backdrop-blur-xl py-3 rounded-2xl font-semibold transition duration-300 hover:scale-[1.02]"
                        >
                            Cerrar sesión
                        </Link>

                    </div>

                </div>

                <!-- INVITADO -->
                <div
                    v-else
                    :class="darkMode
                        ? 'bg-[#1f2937] border-gray-700'
                        : 'bg-white border-gray-200'"
                    class="border p-5 rounded-3xl shadow transition-all duration-500"
                >

                    <p
                        :class="darkMode
                            ? 'text-white'
                            : 'text-gray-800'"
                        class="font-bold text-lg"
                    >
                        Invitado
                    </p>

                    <p
                        :class="darkMode
                            ? 'text-gray-400'
                            : 'text-gray-500'"
                        class="text-sm mt-2 mb-5"
                    >
                        Inicia sesión para reservar salas y ver el calendario
                    </p>

                    <div class="space-y-3">

                        <!-- LOGIN -->
                        <Link
                            href="/login"
                            class="block text-center bg-indigo-600 text-white py-3 rounded-2xl hover:bg-indigo-700 transition"
                        >
                            Iniciar sesión
                        </Link>

                        <!-- REGISTER -->
                        <Link
                            href="/register"
                            class="block text-center border border-indigo-600 text-indigo-600 py-3 rounded-2xl hover:bg-indigo-50 transition"
                        >
                            Crear cuenta
                        </Link>

                    </div>

                </div>

            </div>

        </aside>

        <!-- CONTENT -->
        <main
            :class="darkMode
                ? 'bg-[#0f172a]'
                : 'bg-[#f5f7fb]'"
            class="flex-1 overflow-y-auto transition-all duration-500"
        >

            <!-- MOBILE TOPBAR -->
            <div class="lg:hidden flex items-center justify-between p-5">

                <!-- MENU BUTTON -->
                <button
                    @click="toggleSidebar"
                    class="w-12 h-12 rounded-2xl bg-indigo-600 text-white shadow-lg"
                >
                    ☰
                </button>

                <h1 class="text-xl font-black text-indigo-600">
                    ReservasPro
                </h1>

            </div>

            <!-- PAGE CONTENT -->
            <div
                class="p-5 lg:p-10 animate-fade-in"
            >

                <slot />

            </div>

        </main>

    </div>

</template>

<style scoped>

@keyframes fadeIn {

    from {

        opacity: 0;
        transform: translateY(10px);

    }

    to {

        opacity: 1;
        transform: translateY(0);

    }

}

.animate-fade-in {

    animation: fadeIn 0.4s ease;

}

</style>