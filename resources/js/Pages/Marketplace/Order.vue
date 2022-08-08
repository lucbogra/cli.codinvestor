
<template>
    <AppLayout title="Orders">
        <template #page-header>
            <div class="je jd jc ii mt-5 p-5">
                <div class="ri _y">
                    <h1 class="gu teu text-slate-800 font-bold">Orders ✨</h1>
                </div>
            </div>
            <form enctype="multipart/form-data">
                <div class="flex justify-center">
                    <div class="flex bg-white shadow-sm p-5 rounded justify-between">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">Upload file</label>
                            <input class="block w-full p-2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">
                        </div>
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
import { onMounted, ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3';
const props = defineProps({
  orders: Array,
  investors: Array,
})
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
