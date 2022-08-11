<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { onMounted } from "@vue/runtime-core";
import 'animate.css';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #page-header>
            <div class="animate__animated animate__zoomIn y pr dw jk rounded-md shadow-sm hover:shadow-xl la rc m-8 cursor-pointer ">
                <div class="y">
                    <h1 class="gu teu text-slate-800 font-bold rt">
                        {{ sayHello }}, {{ $page.props.user.name }}. 👋
                    </h1>
                    <p>Here's what's happening on your dashboard today:</p>
                </div>
            </div>
            <div class="sn ag fn m-7">
                <!-- Card 1 -->
                <div class="tz _c tns bg-white bd rounded-md border border-slate-200">
                    <div class="flex ak sh">
                        <!-- Card top -->
                        <div class="uw dz">
                            <!-- Bio -->
                            <div class="rb">
                                <div class="text-xl font-extrabold">34 Products</div>
                                <div>
                                    View all products
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
