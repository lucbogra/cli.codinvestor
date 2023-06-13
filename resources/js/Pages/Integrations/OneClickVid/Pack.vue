<template>
    <Modal maxWidth="6xl" :show="show" @close="$emit('closemodal')">
        <div class="flex flex-col items-center justify-center relative mr-4">
            <div class="bg-white rounded-lg p-6">
                <h1 class="text-2xl text-gray-700 font-semibold mb-4 text-center">You Need To Subscribe in One Of Packages 
                </h1>
                <h1 v-if="errorMessage!=''" class="text-md bg-red-200 text-red-800 p-2 mx-6 mb-4 rounded-md text-center">{{ errorMessage }}
                </h1>
                <div class="flex">
                    <div v-if="freePack != null" class="w-1/3 rounded-lg bg-primary-800 p-3 mr-6 flex flex-col">
                        <div class="flex-1">

                            <div class='max-w-md mx-auto space-y-6 mr-2 rounded-lg p-6 flex-grow'>

                                <div class="bg-primary-800 rounded-lg">
                                    <div class="relative flex flex-col flex-wrap items-center" style="cursor: auto;">
                                        <span
                                            class="absolute px-3 py-1 text-xs font-medium text-white bg-opacity-25 rounded-full bg-gradient-to-r from-pink-500 to-red-400 -top-3 ">{{
                                                freePack.cost == 0 ? 'Free Package' : 'Paid Package' }}</span>

                                        <h3 class="text-4xl font-medium text-white my-7">{{ freePack.name }}</h3>

                                        <ul class="w-full text-lg text-white text-opacity-70">
                                            <li class="flex items-center py-2 text-white">
                                                <div
                                                    class="flex items-center justify-center w-6 h-6 mr-3 bg-green-800 rounded-full">
                                                    <CalendarIcon class="h-4 w-4 text-white" />
                                                </div> {{ freePack.duration }} {{ freePack.duration_type }}
                                            </li>
                                            <li class="flex items-center py-2 text-white">
                                                <div
                                                    class="flex items-center justify-center w-6 h-6 mr-3 bg-green-800 rounded-full">
                                                    <CurrencyDollarIcon class="h-4 w-4 text-white" />
                                                </div>{{ freePack.cost }}$ For {{ freePack.duration }} {{
                                                    freePack.duration_type }}
                                            </li>
                                            <li class="flex items-center py-2 text-white">
                                                <div
                                                    class="flex items-center justify-center w-6 h-6 mr-3 bg-green-800 rounded-full">
                                                    <VideoCameraIcon class="h-4 w-4 text-white" />
                                                </div>
                                                {{ freePack.number_video }} Creatives
                                            </li>
                                            <li class="flex items-center py-2 text-white">


                                                <div class="block">
                                                    <div class="block">
                                                        <span class="inline-flex">
                                                            <div
                                                                class="flex items-center justify-center w-6 h-6 mr-3 bg-green-800 rounded-full">
                                                                <ClipboardIcon class="h-4 w-4 text-white" />
                                                            </div>More Features :
                                                        </span>
                                                    </div>
                                                    <div class="px-8"><span v-html="freePack.description"> </span></div>
                                                </div>
                                            </li>
                                        </ul>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center items-center mb-4">
                            <button disabled
                                class="flex items-center justify-center w-10/12 py-3 space-x-2 text-center bg-gray-400 rounded-lg text-white">
                                <span>{{ freePack.cost == 0 ? 'Free Trial' : 'Subscribe' }}</span>
                            </button>
                        </div>
                    </div>
                    <div v-for="pack in packs" :key="pack.id"
                        class="w-1/3 rounded-lg bg-primary-800 p-3 mr-6 flex flex-col">
                        <div class="flex-1">
                            <div class='max-w-md mx-auto space-y-6 mr-2 rounded-lg p-6 flex-grow'>

                                <div class="bg-primary-800 rounded-lg">
                                    <div class="relative flex flex-col flex-wrap items-center" style="cursor: auto;">
                                        <span
                                            class="absolute px-3 py-1 text-xs font-medium text-white bg-opacity-25 rounded-full bg-gradient-to-r from-pink-500 to-red-400 -top-3 ">{{
                                                pack.cost == 0 ? 'Free Package' : 'Paid Package' }}</span>

                                        <h3 class="text-4xl font-medium text-white my-7">{{ pack.name }}</h3>

                                        <ul class="w-full text-lg text-white text-opacity-70">
                                            <li class="flex items-center py-2 text-white">
                                                <div
                                                    class="flex items-center justify-center w-6 h-6 mr-3 bg-green-800 rounded-full">
                                                    <CalendarIcon class="h-4 w-4 text-white" />
                                                </div> {{ pack.duration }} {{ pack.duration_type }}
                                            </li>
                                            <li class="flex items-center py-2 text-white">
                                                <div
                                                    class="flex items-center justify-center w-6 h-6 mr-3 bg-green-800 rounded-full">
                                                    <CurrencyDollarIcon class="h-4 w-4 text-white" />
                                                </div>{{ pack.cost }}$ For {{ pack.duration }} {{ pack.duration_type }}
                                            </li>
                                            <li class="flex items-center py-2 text-white">
                                                <div
                                                    class="flex items-center justify-center w-6 h-6 mr-3 bg-green-800 rounded-full">
                                                    <VideoCameraIcon class="h-4 w-4 text-white" />
                                                </div>
                                                {{ pack.number_video }} Creatives
                                            </li>
                                            <li class="flex items-center py-2 text-white">


                                                <div class="block">
                                                    <div class="block">
                                                        <span class="inline-flex">
                                                            <div
                                                                class="flex items-center justify-center w-6 h-6 mr-3 bg-green-800 rounded-full">
                                                                <ClipboardIcon class="h-4 w-4 text-white" />
                                                            </div>More Features :
                                                        </span>
                                                    </div>
                                                    <div class="px-8"><span v-html="pack.description"> </span></div>
                                                </div>
                                            </li>
                                        </ul>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center items-center mb-4">
                            <button v-if="hasPackPaid==false" @click="submit(pack)"
                                class="flex items-center justify-center w-10/12 py-3 space-x-2 text-center bg-primary-400 rounded-lg text-white">
                                <span>{{ pack.cost == 0 ? 'Free Trial' : 'Subscribe' }}</span>
                            </button>
                            <button v-else disabled
                                class="flex items-center justify-center w-10/12 py-3 space-x-2 text-center bg-gray-400 rounded-lg text-white">
                                <span>{{ pack.cost == 0 ? 'Free Trial' : 'Subscribe' }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import Modal from '@/Jetstream/Modal.vue'
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { VideoCameraIcon, CalendarIcon, CurrencyDollarIcon, ClipboardIcon } from '@heroicons/vue/outline'
import { useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    show: Boolean,
    hasPackPaid: Boolean
})
const emit = defineEmits('closemodal')

const packs = ref([])
const freePack = ref([])
onMounted(() => {
    getPacks()
    if(props.hasPackPaid)
    {
        errorMessage.value='You need to wait for your next invoice to pay the remaining Payments'
    }

})

const getPacks = () => {
    if (props.show) {
        axios.get(route('getpacks'))
            .then((response) => {
                packs.value = response.data['paid_packs']
                freePack.value = response.data['free_pack']
            })
            .catch(() => console.log('error'))
    }
}

const form = useForm({
    pack: '',
})

const errorMessage=ref('')

const submit = (pack) => {
    form.pack = pack
    if (props.hasPackPaid==false) {
        form.post(route('subscribe'), {
            onSuccess: () => {
                emit('closemodal')
            }
        })
    }

}
</script>
<style>
.container {
    margin-top: 5rem;
    max-width: 30%;
}
</style>