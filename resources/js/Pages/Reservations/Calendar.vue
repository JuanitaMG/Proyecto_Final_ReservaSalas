<script setup>

import { ref, computed } from 'vue'

import AdminLayout from '@/Layouts/AdminLayout.vue'

import FullCalendar from '@fullcalendar/vue3'

import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'

import esLocale from '@fullcalendar/core/locales/es'

const props = defineProps({

    reservations: Array

})

/*
|--------------------------------------------------------------------------
| MODAL
|--------------------------------------------------------------------------
*/

const showModal = ref(false)

const selectedEvent = ref(null)

/*
|--------------------------------------------------------------------------
| STATS
|--------------------------------------------------------------------------
*/

const approvedCount = computed(() => {

    return props.reservations.filter(
        r => r.status === 'approved'
    ).length

})

const pendingCount = computed(() => {

    return props.reservations.filter(
        r => r.status === 'pending'
    ).length

})

const rejectedCount = computed(() => {

    return props.reservations.filter(
        r => r.status === 'rejected'
    ).length

})

/*
|--------------------------------------------------------------------------
| EVENTOS
|--------------------------------------------------------------------------
*/

const events = props.reservations.map((reservation) => ({

    title: `${reservation.space.name}`,

    start: `${reservation.date}T${reservation.start_time}`,

    end: `${reservation.date}T${reservation.end_time}`,

    extendedProps: {

        status: reservation.status,

        user: reservation.user?.name || 'Usuario'

    },

    backgroundColor:
        reservation.status === 'approved'
            ? '#22c55e'
            : reservation.status === 'pending'
            ? '#f59e0b'
            : '#ef4444',

    borderColor:
        reservation.status === 'approved'
            ? '#16a34a'
            : reservation.status === 'pending'
            ? '#d97706'
            : '#dc2626',

    textColor: '#ffffff'

}))

/*
|--------------------------------------------------------------------------
| CALENDAR OPTIONS
|--------------------------------------------------------------------------
*/

const calendarOptions = {

    plugins: [

        dayGridPlugin,
        timeGridPlugin,
        interactionPlugin

    ],

    initialView: 'dayGridMonth',

    locale: esLocale,

    selectable: true,

    height: 760,

    events,

    headerToolbar: {

        left: 'prev,next today',

        center: 'title',

        right: 'dayGridMonth,timeGridWeek'

    },

    buttonText: {

        today: 'Hoy',

        month: 'Mes',

        week: 'Semana'

    },

    eventTimeFormat: {

        hour: '2-digit',

        minute: '2-digit',

        meridiem: false

    },

    /*
    |--------------------------------------------------------------------------
    | STYLE EVENTS
    |--------------------------------------------------------------------------
    */

    eventDidMount(info) {

        info.el.style.borderRadius = '14px'

        info.el.style.padding = '5px'

        info.el.style.fontWeight = '700'

        info.el.style.border = 'none'

        info.el.style.boxShadow =
            '0 6px 18px rgba(0,0,0,0.08)'

    },

    /*
    |--------------------------------------------------------------------------
    | CLICK EVENT
    |--------------------------------------------------------------------------
    */

    eventClick(info) {

        selectedEvent.value = {

            title: info.event.title,

            start: info.event.start,

            end: info.event.end,

            status: info.event.extendedProps.status,

            user: info.event.extendedProps.user

        }

        showModal.value = true

    },

    /*
    |--------------------------------------------------------------------------
    | CLICK DAY
    |--------------------------------------------------------------------------
    */

    dateClick(info) {

        window.location.href =
            `/reservations/create?date=${info.dateStr}`

    }

}

</script>

<template>

    <AdminLayout>

        <div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 p-8">

            <!-- HEADER -->
            <div
                class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8"
            >

                <div>

                    <h1 class="text-5xl font-black text-gray-800">
                        Calendario
                    </h1>

                    <p class="text-gray-500 mt-3 text-lg">
                        Visualización moderna de reservas
                    </p>

                </div>

                <!-- LEYENDA -->
                <div class="flex flex-wrap gap-3">

                    <!-- APROBADAS -->
                    <div
                        class="flex items-center gap-2 bg-white px-4 py-2 rounded-2xl shadow-sm border border-gray-100"
                    >

                        <div class="w-4 h-4 rounded-full bg-green-500"></div>

                        <span class="text-sm font-medium text-gray-700">
                            Aprobadas
                        </span>

                    </div>

                    <!-- PENDIENTES -->
                    <div
                        class="flex items-center gap-2 bg-white px-4 py-2 rounded-2xl shadow-sm border border-gray-100"
                    >

                        <div class="w-4 h-4 rounded-full bg-yellow-500"></div>

                        <span class="text-sm font-medium text-gray-700">
                            Pendientes
                        </span>

                    </div>

                    <!-- RECHAZADAS -->
                    <div
                        class="flex items-center gap-2 bg-white px-4 py-2 rounded-2xl shadow-sm border border-gray-100"
                    >

                        <div class="w-4 h-4 rounded-full bg-red-500"></div>

                        <span class="text-sm font-medium text-gray-700">
                            Rechazadas
                        </span>

                    </div>

                </div>

            </div>

            <!-- STATS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <!-- APROBADAS -->
                <div
                    class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100"
                >

                    <p class="text-gray-500 text-sm">
                        Reservas aprobadas
                    </p>

                    <h2 class="text-5xl font-black text-green-500 mt-3">
                        {{ approvedCount }}
                    </h2>

                </div>

                <!-- PENDIENTES -->
                <div
                    class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100"
                >

                    <p class="text-gray-500 text-sm">
                        Reservas pendientes
                    </p>

                    <h2 class="text-5xl font-black text-yellow-500 mt-3">
                        {{ pendingCount }}
                    </h2>

                </div>

                <!-- RECHAZADAS -->
                <div
                    class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100"
                >

                    <p class="text-gray-500 text-sm">
                        Reservas rechazadas
                    </p>

                    <h2 class="text-5xl font-black text-red-500 mt-3">
                        {{ rejectedCount }}
                    </h2>

                </div>

            </div>

            <!-- CALENDAR -->
            <div
                class="bg-white rounded-[32px] shadow-xl border border-gray-100 p-6 overflow-hidden"
            >

                <FullCalendar
                    :options="calendarOptions"
                />

            </div>

        </div>

        <!-- MODAL -->
        <div
            v-if="showModal"
            class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        >

            <div
                class="bg-white rounded-[32px] w-full max-w-lg p-8 shadow-2xl"
            >

                <!-- HEADER -->
                <div class="flex items-start justify-between mb-8">

                    <div>

                        <h2 class="text-3xl font-black text-gray-800">
                            {{ selectedEvent.title }}
                        </h2>

                        <p class="text-gray-500 mt-2">
                            Información de la reserva
                        </p>

                    </div>

                    <!-- CLOSE -->
                    <button
                        @click="showModal = false"
                        class="w-10 h-10 rounded-2xl bg-gray-100 hover:bg-gray-200 transition"
                    >
                        ✕
                    </button>

                </div>

                <!-- INFO -->
                <div class="space-y-5">

                    <!-- USER -->
                    <div class="bg-gray-50 rounded-2xl p-5">

                        <p class="text-sm text-gray-400 mb-1">
                            Usuario
                        </p>

                        <p class="font-bold text-gray-800 text-lg">
                            {{ selectedEvent.user }}
                        </p>

                    </div>

                    <!-- FECHA -->
                    <div class="bg-gray-50 rounded-2xl p-5">

                        <p class="text-sm text-gray-400 mb-1">
                            Fecha y hora
                        </p>

                        <p class="font-bold text-gray-800 text-lg">

                            {{ selectedEvent.start.toLocaleString() }}

                        </p>

                    </div>

                    <!-- ESTADO -->
                    <div class="bg-gray-50 rounded-2xl p-5">

                        <p class="text-sm text-gray-400 mb-3">
                            Estado
                        </p>

                        <!-- APROBADA -->
                        <span
                            v-if="selectedEvent.status === 'approved'"
                            class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold"
                        >
                            ✅ Aprobada
                        </span>

                        <!-- PENDIENTE -->
                        <span
                            v-else-if="selectedEvent.status === 'pending'"
                            class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-bold"
                        >
                            ⏳ Pendiente
                        </span>

                        <!-- RECHAZADA -->
                        <span
                            v-else
                            class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold"
                        >
                            ❌ Rechazada
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>

<style>

.fc .fc-toolbar-title {

    font-size: 2rem;

    font-weight: 900;

    color: #111827;

}

.fc .fc-button {

    background: #4f46e5 !important;

    border: none !important;

    padding: 12px 18px !important;

    border-radius: 16px !important;

    font-weight: 700 !important;

    transition: 0.2s;

    box-shadow: 0 4px 10px rgba(79,70,229,0.25);

}

.fc .fc-button:hover {

    background: #4338ca !important;

    transform: translateY(-1px);

}

.fc .fc-button-active {

    background: #312e81 !important;

}

.fc-theme-standard td,
.fc-theme-standard th,
.fc-theme-standard .fc-scrollgrid {

    border-color: #eef2ff !important;

}

.fc-daygrid-day-number {

    color: #374151;

    font-weight: 700;

}

.fc-col-header-cell {

    background: #f8fafc;

    padding: 14px 0;

}

.fc-day-today {

    background: rgba(99, 102, 241, 0.08) !important;

}

.fc-daygrid-day:hover {

    background: #f8fafc;

    transition: 0.2s;

    cursor: pointer;

}

.fc-event {

    cursor: pointer;

}

</style>