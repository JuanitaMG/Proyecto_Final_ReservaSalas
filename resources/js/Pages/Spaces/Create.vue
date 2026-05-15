<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const form = ref({
  name: '',
  capacity: '',
  description: '',
  price_per_hour: ''
})

function submit() {
  router.post('/spaces', form.value)
}
</script>

<template>
  <div class="p-8">

    <h1 class="text-2xl font-bold mb-6">Crear sala</h1>

    <form @submit.prevent="submit" class="space-y-4">

      <input v-model="form.name" placeholder="Nombre"
        class="w-full border p-2 rounded" />

      <input v-model="form.capacity" type="number"
        placeholder="Capacidad"
        class="w-full border p-2 rounded" />

      <textarea v-model="form.description"
        placeholder="Descripción"
        class="w-full border p-2 rounded"></textarea>

      <input v-model="form.price_per_hour"
        placeholder="Precio por hora"
        class="w-full border p-2 rounded" />

      <button class="bg-green-600 text-white px-4 py-2 rounded">
        Guardar
      </button>

    </form>

  </div>
</template>