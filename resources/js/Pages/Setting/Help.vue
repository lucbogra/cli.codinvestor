<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { onMounted } from "@vue/runtime-core";
import 'animate.css';
import { CheckCircleIcon, MailIcon, UploadIcon, DocumentDuplicateIcon, ExclamationCircleIcon, XCircleIcon, ShareIcon, ChartPieIcon, TrendingUpIcon, CurrencyDollarIcon, PhoneIcon, BanIcon, ShoppingBagIcon } from '@heroicons/vue/solid';
</script>

<template>
    <AppLayout title="Dashboard" >
        <template #page-header>
                <div class="grid grid-cols-4 gap-4 m-4">
                    <div class="p-4 shadow-sm rounded bg-white text-center">
                        <div class="flex">
                            <div class="p-3 mr-4 bg-red-100 rounded-full">
                                <MailIcon class="w-5 h-5 text-danger"/>
                            </div>
                            <h4 class="text-lg font-bold mt-2">E-mail Address</h4>
                        </div>
                        <p>cod@gmail.com</p>
                    </div>
                    <div class="p-4 shadow-sm rounded bg-white text-center">
                        <div class="flex">
                            <div class="p-3 mr-4 bg-primary-400 rounded-full">
                                <PhoneIcon class="w-5 h-5 text-white"/>
                            </div>
                            <h4 class="text-lg font-bold mt-2">Phone Number</h4>
                        </div>
                        <p>+212 00000000</p>
                    </div>
                    <div class="p-4 shadow-sm rounded bg-white text-center">
                        <div class="flex">
                            <div class="p-3 mr-4 bg-red-100 rounded-full">
                                <MailIcon class="w-5 h-5 text-danger"/>
                            </div>
                            <h4 class="text-lg font-bold mt-2">E-mail Address</h4>
                        </div>
                        <p>cod@gmail.com</p>
                    </div>
                    <div class="p-4 shadow-sm rounded bg-white text-center">
                        <div class="flex">
                            <div class="p-3 mr-4 bg-red-100 rounded-full">
                                <MailIcon class="w-5 h-5 text-danger"/>
                            </div>
                            <h4 class="text-lg font-bold mt-2">E-mail Address</h4>
                        </div>
                        <p>cod@gmail.com</p>
                    </div>
                </div>
        </template>


    </AppLayout>
</template>

<script>
import {
    CashIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    SearchIcon,
    UsersIcon,
    ShoppingCartIcon,
    ViewListIcon,
} from "@heroicons/vue/solid";
export default {
    data() {
        return {

        };
    },
    created() {

    },
};
</script>
