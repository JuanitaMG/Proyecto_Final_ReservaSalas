<script setup>
import { Head, useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
})

const submit = () => {
  form.post('/forgot-password')
}
</script>

<template>

  <Head title="Recuperar contraseña" />

  <div class="min-h-screen flex">

    <!-- LEFT -->
    <div
      class="hidden lg:flex w-1/2 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 relative overflow-hidden"
    >

      <!-- CIRCLES -->
      <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full"></div>

      <div class="absolute bottom-0 right-0 w-72 h-72 bg-white/10 rounded-full"></div>

      <!-- CONTENT -->
      <div class="relative z-10 flex flex-col justify-center px-20 text-white">

        <h1 class="text-7xl font-black mb-8 tracking-tight">
          ReservasPro
        </h1>

        <p class="text-2xl leading-relaxed text-white/90">
          Recupera el acceso a tu cuenta y continúa gestionando
          reservas, salas y disponibilidad en tiempo real.
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

        <!-- TITLE -->
        <div class="mb-8 text-center">

          <h2 class="text-5xl font-black text-gray-800 mb-3">
            Recuperar
          </h2>

          <p class="text-gray-500">
            Ingresa tu correo electrónico
          </p>

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
              placeholder="correo@ejemplo.com"
              class="w-full rounded-2xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 py-4"
            >

            <p
              v-if="form.errors.email"
              class="text-red-500 text-sm mt-2"
            >
              {{ form.errors.email }}
            </p>

          </div>

          <!-- SUCCESS -->
          <div
            v-if="form.recentlySuccessful"
            class="bg-green-100 text-green-700 px-4 py-3 rounded-2xl text-sm"
          >
            Link enviado correctamente 📩
          </div>

          <!-- BUTTON -->
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:opacity-90 text-white py-4 rounded-2xl font-bold text-lg shadow-lg transition"
          >
            Enviar enlace
          </button>

        </form>

      </div>

    </div>

  </div>

</template>