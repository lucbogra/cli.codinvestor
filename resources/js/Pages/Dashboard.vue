<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { onMounted } from "@vue/runtime-core";
import 'animate.css';
import { TemplateIcon, CheckCircleIcon, UploadIcon, DocumentDuplicateIcon, PhoneMissedCallIcon, ExclamationCircleIcon, XCircleIcon, ShareIcon, ChartPieIcon, TrendingUpIcon, CurrencyDollarIcon, PhoneIcon, BanIcon, ShoppingBagIcon } from '@heroicons/vue/solid';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #page-header>
            <div class="sn ag fn">
                <div class="ak tns ">
                    <div
                        class="animate__animated animate__zoomIn y pr dw jk rounded-md shadow-sm hover:shadow-xl la rc mt-12 ml-7 cursor-pointer ">
                        <div class="y">
                            <h1 class="gu text-2xl text-slate-800 font-bold rt">
                                {{ sayHello }}, {{ $page.props.user.name }}.
                            </h1>
                            <p>Here's what's happening on your dashboard today:</p>
                        </div>
                    </div>
                </div>
                <div class="ak tni ">
                    <div class="grid gap-6 mb-8 md:grid-cols-3 xl:grid-cols-2 mt-7">
                        <!-- Begin Card Uploaded-->
                        <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                            <div class="p-3 mr-4 bg-cyan-100 rounded-full">
                                <UploadIcon class="w-5 h-5 text-cyan-500" />
                            </div>
                            <div>
                                <div class="mb-2 font-medium text-gray-600">
                                    <p class="font-bold text-gray-600">Products Requests</p>
                                </div>
                                <p class="text-lg font-bold text-cyan-500">
                                    30
                                </p>
                            </div>
                        </div>
                        <!-- Begin Card Wrong Number-->
                        <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                            <div class="p-3 mr-4 bg-red-100 rounded-full">
                                <XCircleIcon class="w-5 h-5 text-danger" />
                            </div>
                            <div>
                                <div class="mb-2 font-medium text-gray-600">
                                    <p class="font-bold text-gray-600">Products cancelled</p>
                                </div>
                                <p class="text-lg font-bold text-danger">
                                    20
                                </p>
                            </div>
                        </div>
                        <!-- Begin Card Duplicate-->
                        <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                            <div class="p-3 mr-4 bg-blue-100 rounded-full">
                                <CheckCircleIcon class="w-5 h-5 text-green-600" />
                            </div>
                            <div>
                                <div class="mb-2 font-medium text-gray-600">
                                    <p class="font-bold text-gray-600">Products Access</p>
                                </div>
                                <p class="text-lg font-bold text-green-600">
                                    10
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                            <div class="p-3 mr-4 bg-blue-100 rounded-full">
                                <ShoppingBagIcon class="w-5 h-5 text-violet-700" />
                            </div>
                            <div>
                                <div class="mb-2 font-medium text-gray-600">
                                    <p class="font-bold text-gray-600">Orders</p>
                                </div>
                                <p class="text-lg font-bold text-violet-700">
                                    10
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-xl font-bold text-primary-700 flex m-7 mt-7">
                <TemplateIcon class="w-7 h-7 text-primary-700 " />
                <span class="mt-1">Orders Stats</span>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
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
            sayHello: null,
        };
    },
    created() {
        var day = new Date();
        var hr = day.getHours();
        if (hr >= 0 && hr < 12) {
            this.sayHello = "Hello";
        } else if (hr >= 12 && hr <= 17) {
            this.sayHello = "Good afternoon";
        } else {
            this.sayHello = "Good evening";
        }
    },
};
</script>
