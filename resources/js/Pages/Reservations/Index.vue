<script setup>

import { ref, computed } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'

import AdminLayout from '@/Layouts/AdminLayout.vue'
import Alert from '@/Components/Alert.vue'

const page = usePage()

const props = defineProps({

    reservations: Array

})

/*
|--------------------------------------------------------------------------
| LOADING PDF
|--------------------------------------------------------------------------
*/

const loading = ref(false)

/*
|--------------------------------------------------------------------------
| SEARCH + FILTER
|--------------------------------------------------------------------------
*/

const search = ref('')

const statusFilter = ref('all')

const filteredReservations = computed(() => {

    return props.reservations.filter((reservation) => {

        const matchesSearch =

            reservation.space.name
                .toLowerCase()
                .includes(search.value.toLowerCase())

            ||

            reservation.user.name
                .toLowerCase()
                .includes(search.value.toLowerCase())

        const matchesStatus =

            statusFilter.value === 'all'

            ||

            reservation.status === statusFilter.value

        return matchesSearch && matchesStatus

    })

})

/*
|--------------------------------------------------------------------------
| EXPORT PDF
|--------------------------------------------------------------------------
*/

const exportPDF = async () => {

    loading.value = true

    await new Promise(resolve => setTimeout(resolve, 1200))

    const doc = new jsPDF()

    /*
    |--------------------------------------------------------------------------
    | TITLE
    |--------------------------------------------------------------------------
    */

    doc.setFontSize(22)

    doc.text('Reporte de Reservas', 14, 20)

    /*
    |--------------------------------------------------------------------------
    | DATE
    |--------------------------------------------------------------------------
    */

    doc.setFontSize(11)

    doc.setTextColor(100)

    doc.text(

        `Generado: ${new Date().toLocaleDateString()}`,

        14,

        30

    )

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    autoTable(doc, {

        startY: 40,

        head: [[

            'Sala',
            'Usuario',
            'Fecha',
            'Horario',
            'Estado'

        ]],

        body: filteredReservations.value.map((reservation) => [

            reservation.space.name,

            reservation.user.name,

            reservation.date,

            `${reservation.start_time} - ${reservation.end_time}`,

            reservation.status

        ]),

        styles: {

            fontSize: 10,
            cellPadding: 4,
            valign: 'middle'

        },

        headStyles: {

            fillColor: [79, 70, 229]

        },

        alternateRowStyles: {

            fillColor: [245, 245, 245]

        }

    })

    /*
    |--------------------------------------------------------------------------
    | SAVE
    |--------------------------------------------------------------------------
    */

    doc.save('reservas.pdf')

    loading.value = false

}

/*
|--------------------------------------------------------------------------
| MODAL ELIMINAR
|--------------------------------------------------------------------------
*/

const showDeleteModal = ref(false)

const reservationToDelete = ref(null)

const openDeleteModal = (id) => {

    reservationToDelete.value = id

    showDeleteModal.value = true

}

const closeDeleteModal = () => {

    showDeleteModal.value = false

    reservationToDelete.value = null

}

const deleteReservation = () => {

    router.delete(`/reservations/${reservationToDelete.value}`)

    closeDeleteModal()

}

</script>

<template>

    <AdminLayout>

        <!-- ALERT -->
        <Alert :message="page.props.flash.success" />

        <div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 p-8">

            <!-- HEADER -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">

                <div>

                    <h1 class="text-4xl font-black text-gray-800">
                        Reservas
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Gestión de reservas de salas
                    </p>

                </div>

                <!-- BUTTONS -->
                <div class="flex flex-wrap gap-3">

                    <!-- PDF -->
                    <button
                        @click="exportPDF"
                        :disabled="loading"
                        class="bg-white border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 text-gray-700 px-6 py-3 rounded-2xl shadow-sm transition font-semibold disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                    >

                        <!-- SPINNER -->
                        <svg
                            v-if="loading"
                            class="animate-spin h-5 w-5 text-indigo-600"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >

                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            />

                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8v8z"
                            />

                        </svg>

                        <span v-if="loading">
                            Procesando...
                        </span>

                        <span v-else>
                            📄 Exportar PDF
                        </span>

                    </button>

                    <!-- NUEVA -->
                    <a
                        href="/reservations/create"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl shadow-lg transition font-semibold"
                    >
                        + Nueva reserva
                    </a>

                </div>

            </div>

            <!-- SEARCH + FILTER -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8">

                <div class="flex flex-col lg:flex-row gap-4">

                    <!-- SEARCH -->
                    <div class="relative flex-1">

                        <!-- ICON -->
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            🔍
                        </div>

                        <input
                            v-model="search"
                            type="text"
                            placeholder="Buscar por sala o usuario..."
                            class="w-full pl-12 pr-4 py-4 rounded-3xl border border-gray-200 bg-white shadow-sm hover:border-indigo-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition duration-300"
                        >

                    </div>

                    <!-- FILTER -->
                    <div class="relative w-full lg:w-72">

                        <select
                            v-model="statusFilter"
                            class="w-full appearance-none px-5 py-4 rounded-3xl border border-gray-200 bg-white shadow-sm hover:border-indigo-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition duration-300 font-semibold text-gray-700"
                        >

                            <option value="all">
                                Todos los estados
                            </option>

                            <option value="approved">
                                ✅ Aprobadas
                            </option>

                            <option value="pending">
                                ⏳ Pendientes
                            </option>

                            <option value="rejected">
                                ❌ Rechazadas
                            </option>

                            <option value="cancelled">
                                🚫 Canceladas
                            </option>

                        </select>

                        <!-- ARROW -->
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-lg">
                            ⌄
                        </div>

                    </div>

                </div>

            </div>

            <!-- STATS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

                <!-- TOTAL -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

                    <p class="text-gray-500 text-sm">
                        Totales
                    </p>

                    <h2 class="text-4xl font-black text-gray-800 mt-2">
                        {{ reservations.length }}
                    </h2>

                </div>

                <!-- PENDIENTES -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

                    <p class="text-gray-500 text-sm">
                        Pendientes
                    </p>

                    <h2 class="text-4xl font-black text-yellow-500 mt-2">
                        {{ reservations.filter(r => r.status === 'pending').length }}
                    </h2>

                </div>

                <!-- APROBADAS -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

                    <p class="text-gray-500 text-sm">
                        Aprobadas
                    </p>

                    <h2 class="text-4xl font-black text-green-600 mt-2">
                        {{ reservations.filter(r => r.status === 'approved').length }}
                    </h2>

                </div>

                <!-- CANCELADAS -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

                    <p class="text-gray-500 text-sm">
                        Canceladas
                    </p>

                    <h2 class="text-4xl font-black text-red-500 mt-2">
                        {{ reservations.filter(r => r.status === 'cancelled').length }}
                    </h2>

                </div>

            </div>

            <!-- TABLE -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[900px]">

                        <!-- HEAD -->
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">

                            <tr>

                                <th class="p-5 text-left">
                                    Sala
                                </th>

                                <th class="p-5 text-left">
                                    Usuario
                                </th>

                                <th class="p-5 text-left">
                                    Fecha
                                </th>

                                <th class="p-5 text-left">
                                    Horario
                                </th>

                                <th class="p-5 text-left">
                                    Estado
                                </th>

                                <th class="p-5 text-center">
                                    Acciones
                                </th>

                            </tr>

                        </thead>

                        <!-- BODY -->
                        <tbody>

                            <tr
                                v-for="r in filteredReservations"
                                :key="r.id"
                                class="border-t border-gray-100 hover:bg-gray-50 transition"
                            >

                                <!-- SALA -->
                                <td class="p-5 font-bold text-gray-800">
                                    {{ r.space.name }}
                                </td>

                                <!-- USER -->
                                <td class="p-5 text-gray-600">
                                    {{ r.user.name }}
                                </td>

                                <!-- DATE -->
                                <td class="p-5 text-gray-600">
                                    {{ r.date }}
                                </td>

                                <!-- TIME -->
                                <td class="p-5 text-gray-600">
                                    {{ r.start_time }} - {{ r.end_time }}
                                </td>

                                <!-- STATUS -->
                                <td class="p-5">

                                    <span
                                        v-if="r.status === 'pending'"
                                        class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-xs font-bold"
                                    >
                                        ⏳ Pendiente
                                    </span>

                                    <span
                                        v-else-if="r.status === 'approved'"
                                        class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-xs font-bold"
                                    >
                                        ✅ Aprobada
                                    </span>

                                    <span
                                        v-else-if="r.status === 'cancelled'"
                                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-xs font-bold"
                                    >
                                        🚫 Cancelada
                                    </span>

                                    <span
                                        v-else
                                        class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-xs font-bold"
                                    >
                                        ❌ Rechazada
                                    </span>

                                </td>

                                <!-- ACTIONS -->
                                <td class="p-5">

                                    <div class="flex flex-wrap justify-center gap-2">

                                        <template v-if="page.props.auth.user.role === 'admin'">

                                            <!-- APROBAR -->
                                            <button
                                                v-if="r.status === 'pending'"
                                                @click="$inertia.post(`/reservations/${r.id}/approve`)"
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl shadow text-xs font-semibold transition"
                                            >
                                                ✔ Aprobar
                                            </button>

                                            <!-- RECHAZAR -->
                                            <button
                                                v-if="r.status === 'pending'"
                                                @click="$inertia.post(`/reservations/${r.id}/reject`)"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl shadow text-xs font-semibold transition"
                                            >
                                                ✖ Rechazar
                                            </button>

                                            <!-- CANCELAR -->
                                            <button
                                                v-if="r.status === 'approved'"
                                                @click="$inertia.post(`/reservations/${r.id}/cancel`)"
                                                class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-xl shadow text-xs font-semibold transition"
                                            >
                                                🚫 Cancelar
                                            </button>

                                            <!-- EDITAR -->
                                            <a
                                                :href="`/reservations/${r.id}/edit`"
                                                class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl hover:bg-yellow-200 transition text-xs font-semibold"
                                            >
                                                ✏️ Editar
                                            </a>

                                            <!-- ELIMINAR -->
                                            <button
                                                @click="openDeleteModal(r.id)"
                                                class="bg-red-100 text-red-600 px-4 py-2 rounded-xl hover:bg-red-200 transition text-xs font-semibold"
                                            >
                                                🗑️ Eliminar
                                            </button>

                                        </template>

                                    </div>

                                </td>

                            </tr>

                            <!-- EMPTY -->
                            <tr v-if="filteredReservations.length === 0">

                                <td colspan="6" class="p-16">

                                    <div class="flex flex-col items-center justify-center text-center">

                                        <!-- ICON -->
                                        <div class="w-24 h-24 rounded-full bg-indigo-100 flex items-center justify-center text-5xl mb-6 shadow-inner">

                                            📭

                                        </div>

                                        <!-- TITLE -->
                                        <h2 class="text-2xl font-black text-gray-800 mb-2">

                                            No hay reservas

                                        </h2>

                                        <!-- TEXT -->
                                        <p class="text-gray-500 max-w-md mb-8">

                                            No se encontraron reservas con los filtros seleccionados.
                                            Puedes crear una nueva reserva para comenzar.

                                        </p>

                                        <!-- BUTTON -->
                                        <a
                                            href="/reservations/create"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl shadow-lg transition font-semibold"
                                        >

                                            + Crear reserva

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- MODAL -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        >

            <div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl">

                <!-- ICON -->
                <div class="text-6xl text-center mb-4">
                    🗑️
                </div>

                <!-- TITLE -->
                <h2 class="text-2xl font-black text-gray-800 text-center mb-3">
                    Eliminar reserva
                </h2>

                <!-- TEXT -->
                <p class="text-gray-500 text-center mb-8">
                    Esta acción no se puede deshacer
                </p>

                <!-- BUTTONS -->
                <div class="flex gap-4">

                    <!-- CANCELAR -->
                    <button
                        @click="closeDeleteModal"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-2xl font-semibold transition"
                    >
                        Cancelar
                    </button>

                    <!-- ELIMINAR -->
                    <button
                        @click="deleteReservation"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white py-3 rounded-2xl font-semibold shadow-lg transition"
                    >
                        Eliminar
                    </button>

                </div>

            </div>

        </div>

    </AdminLayout>

</template>