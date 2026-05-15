<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { usePage } from '@inertiajs/vue3'

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
    LinearScale,
    BarElement
} from 'chart.js'

import {
    Doughnut,
    Bar
} from 'vue-chartjs'

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
    LinearScale,
    BarElement
)

const page = usePage()

const props = defineProps({

    totalSpaces: Number,
    totalReservations: Number,
    approvedReservations: Number,
    pendingReservations: Number,
    rejectedReservations: Number,
    totalUsers: Number,

    recentReservations: Array,

    reservationsBySpace: Array,

    topSpace: Object,

    topUser: Object,

    approvalRate: Number

})

/*
|--------------------------------------------------------------------------
| CHART DONUT
|--------------------------------------------------------------------------
*/

const chartData = {

    labels: [
        'Aprobadas',
        'Pendientes',
        'Rechazadas'
    ],

    datasets: [
        {
            data: [
                props.approvedReservations,
                props.pendingReservations,
                props.rejectedReservations
            ],

            backgroundColor: [
                '#22c55e',
                '#eab308',
                '#ef4444'
            ],

            borderWidth: 0,
            borderRadius: 8
        }
    ]

}

const chartOptions = {

    responsive: true,

    maintainAspectRatio: false,

    cutout: '72%',

    plugins: {

        legend: {

            position: 'bottom',

            labels: {

                padding: 18,
                usePointStyle: true,
                pointStyle: 'circle',
                boxWidth: 10,
                font: {
                    size: 12
                }

            }

        }

    }

}

/*
|--------------------------------------------------------------------------
| CHART BARRAS
|--------------------------------------------------------------------------
*/

const barChartData = {

    labels: props.reservationsBySpace.map(space => space.name),

    datasets: [
        {
            label: 'Reservas',

            data: props.reservationsBySpace.map(space => space.total),

            backgroundColor: '#6366f1',

            borderRadius: 10,

            maxBarThickness: 45
        }
    ]

}

const barChartOptions = {

    responsive: true,

    maintainAspectRatio: false,

    plugins: {

        legend: {

            display: false

        }

    },

    scales: {

        y: {

            beginAtZero: true,

            ticks: {

                precision: 0

            },

            grid: {

                color: '#f1f5f9'

            }

        },

        x: {

            grid: {

                display: false

            }

        }

    }

}

</script>

<template>

    <AdminLayout>

        <div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 p-6 lg:p-8">

            <!-- HEADER -->
            <div class="mb-8">

                <h1 class="text-4xl lg:text-5xl font-black text-gray-800 tracking-tight">
                    Dashboard
                </h1>

                <p class="text-gray-500 mt-2 text-base lg:text-lg">
                    Bienvenida, {{ page.props.auth.user.name }}
                </p>

            </div>

            <!-- CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5">

                <!-- RESERVAS -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition duration-300">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-xl">
                            📅
                        </div>

                        <span class="text-sm text-gray-400">
                            Reservas
                        </span>

                    </div>

                    <h2 class="text-3xl font-black text-gray-800">
                        {{ totalReservations }}
                    </h2>

                    <p class="text-gray-500 mt-2 text-sm">
                        Reservas registradas
                    </p>

                </div>

                <!-- APROBADAS -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition duration-300">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-xl">
                            ✅
                        </div>

                        <span class="text-sm text-gray-400">
                            Aprobadas
                        </span>

                    </div>

                    <h2 class="text-3xl font-black text-green-600">
                        {{ approvedReservations }}
                    </h2>

                    <p class="text-gray-500 mt-2 text-sm">
                        Reservas aprobadas
                    </p>

                </div>

                <!-- PENDIENTES -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition duration-300">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center text-xl">
                            ⏳
                        </div>

                        <span class="text-sm text-gray-400">
                            Pendientes
                        </span>

                    </div>

                    <h2 class="text-3xl font-black text-yellow-500">
                        {{ pendingReservations }}
                    </h2>

                    <p class="text-gray-500 mt-2 text-sm">
                        Pendientes por aprobar
                    </p>

                </div>

                <!-- SALAS -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition duration-300">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center text-xl">
                            🏢
                        </div>

                        <span class="text-sm text-gray-400">
                            Salas
                        </span>

                    </div>

                    <h2 class="text-3xl font-black text-purple-600">
                        {{ totalSpaces }}
                    </h2>

                    <p class="text-gray-500 mt-2 text-sm">
                        Salas registradas
                    </p>

                </div>

                <!-- USUARIOS -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition duration-300">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-12 h-12 rounded-2xl bg-pink-100 flex items-center justify-center text-xl">
                            👤
                        </div>

                        <span class="text-sm text-gray-400">
                            Usuarios
                        </span>

                    </div>

                    <h2 class="text-3xl font-black text-pink-600">
                        {{ totalUsers }}
                    </h2>

                    <p class="text-gray-500 mt-2 text-sm">
                        Usuarios registrados
                    </p>

                </div>

            </div>

            <!-- GRID -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-8">

                <!-- ACTIVIDAD -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">

                    <h2 class="text-xl font-black text-gray-800 mb-6">
                        Actividad reciente
                    </h2>

                    <div class="space-y-5">

                        <div
                            v-for="reservation in recentReservations"
                            :key="reservation.id"
                            class="flex items-start gap-4"
                        >

                            <!-- ICON -->
                            <div
                                class="p-3 rounded-2xl"
                                :class="{
                                    'bg-green-100 text-green-600':
                                        reservation.status === 'approved',

                                    'bg-yellow-100 text-yellow-600':
                                        reservation.status === 'pending',

                                    'bg-red-100 text-red-600':
                                        reservation.status === 'rejected'
                                }"
                            >

                                <span v-if="reservation.status === 'approved'">
                                    ✅
                                </span>

                                <span v-else-if="reservation.status === 'pending'">
                                    ⏳
                                </span>

                                <span v-else>
                                    ❌
                                </span>

                            </div>

                            <!-- INFO -->
                            <div class="min-w-0">

                                <p class="font-semibold text-gray-700 text-sm lg:text-base break-words">

                                    {{ reservation.user.name }}

                                    reservó

                                    {{ reservation.space.name }}

                                </p>

                                <p class="text-sm text-gray-400 break-words">

                                    {{ reservation.date }}

                                    •

                                    {{ reservation.start_time }}

                                    -

                                    {{ reservation.end_time }}

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- DONUT -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">

                    <h2 class="text-xl font-black text-gray-800 mb-6">
                        Estado de reservas
                    </h2>

                    <div class="flex justify-center items-center">

                        <div class="w-full max-w-[280px] h-[280px]">

                            <Doughnut
                                :data="chartData"
                                :options="chartOptions"
                            />

                        </div>

                    </div>

                </div>

            </div>

            <!-- STATS EXTRA -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

                <!-- SALA MÁS USADA -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-xl">
                            🏆
                        </div>

                        <span class="text-sm text-gray-400">
                            Top sala
                        </span>

                    </div>

                    <h2 class="text-2xl font-black text-gray-800 break-words">
                        {{ topSpace?.name || 'Sin datos' }}
                    </h2>

                    <p class="text-gray-500 mt-2 text-sm">
                        Sala más utilizada
                    </p>

                </div>

                <!-- USUARIO MÁS ACTIVO -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-12 h-12 rounded-2xl bg-pink-100 flex items-center justify-center text-xl">
                            👑
                        </div>

                        <span class="text-sm text-gray-400">
                            Top usuario
                        </span>

                    </div>

                    <h2 class="text-2xl font-black text-gray-800 break-words">
                        {{ topUser?.name || 'Sin datos' }}
                    </h2>

                    <p class="text-gray-500 mt-2 text-sm">
                        Usuario más activo
                    </p>

                </div>

                <!-- APROBACIÓN -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">

                    <div class="flex items-center justify-between mb-5">

                        <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-xl">
                            📈
                        </div>

                        <span class="text-sm text-gray-400">
                            Rendimiento
                        </span>

                    </div>

                    <h2 class="text-3xl font-black text-green-600">
                        {{ approvalRate }}%
                    </h2>

                    <p class="text-gray-500 mt-2 text-sm">
                        Reservas aprobadas
                    </p>

                </div>

            </div>

            <!-- CHART BARRAS -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm mt-6">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">

                    <div>

                        <h2 class="text-xl font-black text-gray-800">
                            Reservas por sala
                        </h2>

                        <p class="text-gray-500 mt-1 text-sm">
                            Estadísticas generales de uso
                        </p>

                    </div>

                    <div class="bg-indigo-100 text-indigo-600 px-4 py-2 rounded-2xl text-sm font-semibold w-fit">
                        📊 Analytics
                    </div>

                </div>

                <div class="max-w-4xl mx-auto h-[260px] lg:h-[320px]">

                    <Bar
                        :data="barChartData"
                        :options="barChartOptions"
                    />

                </div>

            </div>

        </div>

    </AdminLayout>

</template>