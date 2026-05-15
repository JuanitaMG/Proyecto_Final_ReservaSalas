<script setup>

import { ref, watch } from 'vue'

const props = defineProps({

    message: String

})

const show = ref(false)

/*
|--------------------------------------------------------------------------
| MOSTRAR ALERTA
|--------------------------------------------------------------------------
*/

watch(

    () => props.message,

    (value) => {

        if (value) {

            show.value = true

            setTimeout(() => {

                show.value = false

            }, 3500)

        }

    },

    {

        immediate: true

    }

)

</script>

<template>

    <transition
        enter-active-class="transition duration-500 ease-out"
        enter-from-class="opacity-0 translate-y-5 scale-95"
        enter-to-class="opacity-100 translate-y-0 scale-100"
        leave-active-class="transition duration-300 ease-in"
        leave-from-class="opacity-100 translate-y-0 scale-100"
        leave-to-class="opacity-0 translate-y-5 scale-95"
    >

        <div
            v-if="message && show"
            class="fixed top-6 right-6 z-50"
        >

            <div
                class="bg-white border border-green-100 shadow-2xl rounded-3xl px-6 py-5 min-w-[340px] backdrop-blur-xl"
            >

                <div class="flex items-start gap-4">

                    <!-- ICON -->
                    <div
                        class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-2xl shrink-0"
                    >
                        ✅
                    </div>

                    <!-- CONTENT -->
                    <div class="flex-1">

                        <h3
                            class="text-lg font-black text-gray-800"
                        >
                            Operación exitosa
                        </h3>

                        <p
                            class="text-gray-500 mt-1 text-sm leading-relaxed"
                        >
                            {{ message }}
                        </p>

                    </div>

                    <!-- CLOSE -->
                    <button
                        @click="show = false"
                        class="text-gray-400 hover:text-gray-700 transition"
                    >
                        ✕
                    </button>

                </div>

                <!-- PROGRESS -->
                <div
                    class="mt-4 h-1.5 bg-gray-100 rounded-full overflow-hidden"
                >

                    <div
                        class="h-full bg-green-500 rounded-full animate-progress"
                    ></div>

                </div>

            </div>

        </div>

    </transition>

</template>

<style scoped>

.animate-progress {

    animation: progress 3.5s linear forwards;

}

@keyframes progress {

    from {

        width: 100%;

    }

    to {

        width: 0%;

    }

}

</style>