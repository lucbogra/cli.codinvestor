
<template>
    <AppLayout title="Orders">
        <template #page-header>
            <div class="je jd jc ii mt-2 p-5">
                <div class="ri _y">
                    <h1 class="gu teu text-slate-800 font-bold">Orders ✨</h1>
                </div>
            </div>
            <form @submit.prevent="submitImport" enctype="multipart/form-data" class="-mt-8">
                <div class="flex justify-center">
                    <div class="flex bg-white shadow-md p-2 rounded justify-between">
                        <FileInput v-model="form.file" class="pr-6 pb-8 w-96" type="file" accept=".xlsx, .xls, .csv" label="Your order file" />

                        <div class="ml-9 mt-8">
                            <button class="btn ho xi ye disabled:opacity-50" :disabled="form.file === null">Import orders</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class=" px-8 py-16 sm:px-0 mx-6 -mt-8">
                <TabGroup :defaultIndex="0">
                    <TabList class="flex space-x-1 rounded-xl p-1" :style="'background-color :' + colorx">
                        <Tab v-slot="{ selected }" as="template" @click="colorx = '#0F7490'">
                        <button
                            :class="['w-full rounded-lg py-2.5 text-sm font-medium leading-5 text-white',
                            'ring-white ring-opacity-60 ring-offset-2 ring-offset-cyan-400 focus:outline-none focus:ring-2',
                            selected ? 'bg-white shadow text-cyan-500' : 'text-white hover:bg-white/[0.12] hover:text-white',]">
                            <!-- <UploadIcon class=" mr-1.5 h-5 w-5 text-cyan-500" aria-hidden="true"/> -->
                            Uploaded <span class=" rounded px-2 bg-cyan-500 text-white">{{ '0' }}</span>
                        </button>
                        </Tab>

                        <Tab v-slot="{ selected }" as="template" @click="colorx = '#1B2E51'">
                        <button
                            :class="['w-full rounded-lg py-2.5 text-sm font-medium leading-5 text-white',
                            'ring-white ring-opacity-60 ring-offset-2 ring-offset-primary-500 focus:outline-none focus:ring-2',
                            selected ? 'bg-white shadow text-primary-800' : 'text-white hover:bg-white/[0.12] hover:text-white',]">
                            Duplicate <span class=" rounded px-2 bg-primary-800 text-white">{{ '8' }}</span>
                        </button>
                        </Tab>

                        <Tab v-slot="{ selected }" @click="colorx = '#0C4687'" as="template">
                        <button
                            :class="['w-full rounded-lg py-2.5 text-sm font-medium leading-5 text-white',
                            'ring-white ring-opacity-60 ring-offset-2 ring-offset-primary-400 focus:outline-none focus:ring-2',
                            selected ? 'bg-white shadow text-primary-700' : 'text-white hover:bg-white/[0.12] hover:text-white',]">
                            Rejected <span class=" rounded px-2 bg-primary-700 text-white">{{ '9' }}</span>
                        </button>
                        </Tab>


                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel
                        :class="['rounded-xl bg-white p-3', 'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',]">
                        <Uploaded :orders="uploaded" />

                        </TabPanel>

                        <TabPanel
                        :class="['rounded-xl bg-white p-3', 'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',]">
                        <!-- <Duplicate :agents="agents" :orders="duplicate"></Duplicate> -->
                        sdlihfezih
                        </TabPanel>

                        <TabPanel
                        :class="['rounded-xl bg-white p-3', 'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',]">
                        <!-- <Pending :agents="agents" :orders="pendings"/> -->
                        sqdcomheomfh
                        </TabPanel>


                    </TabPanels>
                </TabGroup>
            </div>
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import FileInput from '@/Components/FileInput.vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import Input from '@/Jetstream/Input.vue';
import InputError from '@/Jetstream/InputError.vue';
import { ref, computed, onMounted } from 'vue';
import {
  TabGroup, TabList, Tab, TabPanels, TabPanel
} from '@headlessui/vue'
import Uploaded from './Uploaded.vue'
const props = defineProps({
  orders: Array,
  investors: Array
})
const filters = ref({
  all: { value: '', keys: ['customer_name', 'phone', 'country', 'city', 'product_name', 'price', 'website', 'created_at'] }
})
const colorx = ref('#0F7490')

const form = useForm({
  file: null,
})

const submitImport = () => {
  form.post('orders/import', {
    onSuccess: () => {
         Swal.fire({
            toast: true,
            position: 'top-end',
            timer: 3000,
            showConfirmButton: false,
            timerProgressBar: true,
            icon: 'success',
            title: "Orders were uploaded successfully",

      }),
        form.reset()
    }
  });
}
</script>

<script >

import axios from 'axios';
export default {
    data() {
        return {
        }
    },
    methods: {

    }
}
</script>

<style>
</style>
