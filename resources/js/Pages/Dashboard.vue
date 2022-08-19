<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { onMounted, ref } from "@vue/runtime-core";
import 'animate.css';
import { TemplateIcon, CheckCircleIcon, UploadIcon, DocumentDuplicateIcon, PhoneMissedCallIcon, ExclamationCircleIcon, XCircleIcon, ShareIcon, ChartPieIcon, TrendingUpIcon, CurrencyDollarIcon, PhoneIcon, BanIcon, ShoppingBagIcon } from '@heroicons/vue/solid';

const props = defineProps({
    uploaded: Number,
    duplicate: Number,
    wrong_number: Number,
    rejected: Number,
    confirmed: Number,
    cancelled: Number,
    no_answer: Number,
    delayed: Number,
    request: Number,
    denied: Number,
    access: Number
});

const datas = ref(null)
const lineSeries = ref(null)
const lineChartOptions = ref(null)
onMounted( async() => {
  const res = await axios.get(route('dashboard.performance'))
  datas.value = res.data

  lineSeries.value = [{
  name: 'Confirmation Rate',
  type: 'line',
  data: Object.values(datas.value),
  color: '#52B12C'
}]

lineChartOptions.value = {
  chart: {
    height: 350,
    type: 'line',
    dropShadow: {
      enabled: true,
      color: '#000',
      top: 18,
      left: 7,
      blur: 10,
      opacity: 0.2
    },
    toolbar: {
      show: true
    }
  },
  dataLabels: {
    enabled: true
  },
  stroke: {
    curve: 'smooth'
  },
  xaxis: {
    type: 'date',
    categories:  Object.keys(datas.value),
  },
  title: {
    text: 'Confirmation rate',
    align: 'left'
  },
  grid: {
    row: {
      colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
      opacity: 0.5
    },
  },
}


})


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
                                    {{ $request ? $request : 0 }}
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
                                    {{ $denied ? $denied : 0 }}
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
                                    {{ $access ? $access : 0 }}
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


            <div class="text-xl font-bold text-primary-700 flex m-7">
                <TemplateIcon class="w-7 h-7 text-primary-700 " />
                <span class="mt-1">Orders Stats</span>
            </div>
            <div class="grid gap-6 mb-8 md:grid-cols-4 xl:grid-cols-4 mt-7 mx-7">
                <!-- Begin Card Uploaded-->
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-cyan-100 rounded-full">
                        <UploadIcon class="w-5 h-5 text-cyan-500" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Uploaded</p>
                        </div>
                        <p class="text-lg font-bold text-cyan-500">
                            {{ uploaded }}
                        </p>
                    </div>
                </div>
                <!-- Begin Card Wrong Number-->
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-red-100 rounded-full">
                        <PhoneIcon class="w-5 h-5 text-danger" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Wrong Number</p>
                        </div>
                        <p class="text-lg font-bold text-danger">
                            {{ wrong_number }}
                        </p>
                    </div>
                </div>
                <!-- Begin Card Duplicate-->
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-blue-100 rounded-full">
                        <DocumentDuplicateIcon class="w-5 h-5 text-green-600" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Duplicated</p>
                        </div>
                        <p class="text-lg font-bold text-green-600">
                            {{ duplicate }}
                        </p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-blue-100 rounded-full">
                        <BanIcon class="w-5 h-5 text-red-700" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Rejected</p>
                        </div>
                        <p class="text-lg font-bold text-red-700">
                            {{ rejected }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="grid gap-6 mb-8 md:grid-cols-4 xl:grid-cols-4 mt-7 mx-7">
                <!-- Begin Card Uploaded-->
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-cyan-100 rounded-full">
                        <UploadIcon class="w-5 h-5 text-cyan-500" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Process</p>
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
                            <p class="font-bold text-gray-600">Confirmed</p>
                        </div>
                        <p class="text-lg font-bold text-danger">
                            {{ confirmed }}
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
                            <p class="font-bold text-gray-600">Cancelled</p>
                        </div>
                        <p class="text-lg font-bold text-green-600">
                            {{ cancelled }}
                        </p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-blue-100 rounded-full">
                        <PhoneMissedCallIcon class="w-5 h-5 text-violet-700" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">No answer</p>
                        </div>
                        <p class="text-lg font-bold text-violet-700">
                            {{ no_answer }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mx-7 bg-white p-4 rounded animate__animated animate__zoomIn">
                <apexchart type="line" height="350" :options="lineChartOptions" :series="lineSeries"></apexchart>
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
