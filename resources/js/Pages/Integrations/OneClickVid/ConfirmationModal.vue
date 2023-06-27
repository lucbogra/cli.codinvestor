<script setup>
import Modal from '@/Jetstream/Modal.vue'
import {QuestionMarkCircleIcon} from '@heroicons/vue/outline'
const props = defineProps({
    show: Boolean,
    message:String,
    situation:String
})
</script>
<template>
    <Modal :show="show" @close="$emit('cancel')">

            <div class="">
                <!--body-->
                <div class="text-center p-5 flex-auto justify-center">
                    <QuestionMarkCircleIcon class="w-16 h-16 flex items-center mx-auto" :class="{'text-danger':situation=='danger','text-primary-600':situation=='confirm'}" />
                    
                    <h2 class="text-xl font-bold py-4 " >Are you sure?</h2>
                    <p class="text-sm text-gray-500 px-8" >{{message}}</p>
                </div>
                <!--footer-->
                <div class="p-3  mt-2 text-center space-x-4 md:block">
                    <button @click="$emit('cancel')"
                        class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                        No
                    </button>
                    <button
                    @click="$emit('confirm')"
                    :class="{'bg-danger border-danger':situation=='danger','bg-primary-500 border-primary-500 hover:bg-primary-600':situation=='confirm'}"
                        class="mb-2 md:mb-0 border  px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg ">Yes</button>
                </div>
            </div>
    </Modal>
</template>
