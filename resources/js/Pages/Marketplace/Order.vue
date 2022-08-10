
<template>
    <AppLayout title="Orders">
        <template #page-header>
            <div class="je jd jc ii mt-2 p-5">
                <div class="ri _y">
                    <h1 class="gu teu text-slate-800 font-bold">Orders ✨</h1>
                </div>
            </div>
            <form @submit.prevent="submitImport" enctype="multipart/form-data">
                <div class="flex justify-center">
                    <div class="flex bg-white shadow-sm p-5 rounded justify-between">
                        <FileInput v-model="form.file" class="pr-6 pb-8 w-full w-96 " type="file" accept=".xlsx, .xls, .csv" label="file" />

                        <div class="ml-9 mt-8">
                            <button class="btn ho xi ye">Import orders</button>
                        </div>
                    </div>
                </div>
            </form>
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3';
import FileInput from '@/Components/FileInput.vue';
const props = defineProps({
  orders: Array,
  investors: Array,
})

const form = useForm({
  file: null,
})

const submitImport = () => {
  form.post('orders/import', {

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
