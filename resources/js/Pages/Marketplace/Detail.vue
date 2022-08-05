<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { onMounted, ref } from 'vue'
import { InertiaLink } from '@inertiajs/inertia-vue3'
import helpers from '@/helpers.js'
import axios from 'axios'
import {
    Disclosure, DisclosureButton, DisclosurePanel, RadioGroup, RadioGroupLabel, RadioGroupOption, Tab,
    TabGroup, TabList, TabPanel, TabPanels,
} from '@headlessui/vue'
import { StarIcon } from '@heroicons/vue/solid'
import { HeartIcon, MinusSmIcon, PlusSmIcon } from '@heroicons/vue/outline'


const props = defineProps({
    product: Object,
    variants: Array,
    colors: Array,
    warehouses: Array
});

const listVariants = () => {
    return props.variants.map((variant) => {
        return {
            id: variant.id,
            product_id: variant.product_id,
            price: variant.pu,
            colors: variant.color,
            size: variant.size,
            genre: variant.genre
        }
    })
}
const variants = ref(listVariants());

let colors = []
let sizes = []
let prices = []

</script>

<template>
    <AppLayout :title="product.name">
        <template #page-header>
            <div class="bg-slate-100">
                <div class="max-w-2xl mx-auto sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8 " style="margin-top:-70px ;">
                    <nav aria-label="Breadcrumb" class="mb-4">
                        <ol role="list"
                            class="max-w-2xl mx-auto flex items-center space-x-2 sm:px-6 lg:max-w-7xl lg:px-8">
                            <li>
                                <div class="flex items-center">
                                    <inertia-link :href="route('marketplace.index')"
                                        class="mr-2 text-sm font-medium text-gray-900">
                                        Marketplace
                                    </inertia-link>
                                    <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                        class="w-4 h-5 text-gray-300">
                                        <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                    </svg>
                                </div>
                            </li>
                            <li class="text-sm">
                                <inertia-link :href="product.href" aria-current="page"
                                    class="font-medium text-gray-500 hover:text-gray-600">
                                    {{ product.name }}
                                </inertia-link>
                            </li>
                        </ol>
                    </nav>
                    <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
                        <!-- Image gallery -->
                        <TabGroup as="div" class="flex flex-col-reverse">
                            <!-- Image selector -->
                            <div class="hidden mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
                                <TabList class="grid grid-cols-4 gap-6">
                                    <Tab v-for="image in props.product.gallery" :key="image.id"
                                        class="relative h-24 bg-white rounded-md flex items-center justify-center text-sm font-medium uppercase text-gray-900 cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring focus:ring-offset-4 focus:ring-opacity-50"
                                        v-slot="{ selected }">
                                        <span class="sr-only">
                                            <!-- {{ image.name }} -->
                                        </span>
                                        <span class="absolute inset-0 rounded-md overflow-hidden">
                                            <img :src="image.url" alt=""
                                                class="w-full h-full object-center object-cover" />
                                        </span>
                                        <span
                                            :class="[selected ? 'ring-indigo-500' : 'ring-transparent', 'absolute inset-0 rounded-md ring-2 ring-offset-2 pointer-events-none']"
                                            aria-hidden="true" />
                                    </Tab>
                                </TabList>
                            </div>

                            <TabPanels class="w-full aspect-w-1 aspect-h-1">
                                <TabPanel v-for="image in props.product.gallery" :key="image.id">
                                    <img :src="image.url"
                                        class="w-full h-full object-center object-cover sm:rounded-lg" />
                                </TabPanel>
                            </TabPanels>
                        </TabGroup>

                        <!-- Product info -->
                        <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ props.product.name }}
                            </h1>
                            <hr class="border-1 my-3">
                            <div class="mt-3">
                                <h2 class="sr-only">Product information</h2>
                                <div class="text-xl">
                                    Recommanded Price :
                                    <span class=" text-blue-700 font-bold"> {{ '$' + prices[0] }}</span>
                                </div>
                                <hr class="border-1  my-3">
                                <div class="text-xl">
                                    Original Price :
                                    <span class=" text-blue-700 font-bold"> {{ '$' + prices[1] }}</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h3 class="sr-only">Description</h3>
                                <div class="text-base text-gray-700 space-y-6" v-html="props.product.description" />
                            </div>

                            <div class="mt-6">
                                <!-- Colors -->
                                <div>
                                    <h3 class="text-md text-gray-600">Select by Colors</h3>

                                    <RadioGroup v-model="selectedColor" class="mt-2">
                                        <RadioGroupLabel class="sr-only"> Choose a color </RadioGroupLabel>
                                        <span class="flex items-center space-x-3">
                                            <RadioGroupOption as="template" v-for="color in colors" :key="color.name"
                                                :value="color" v-slot="{ active, checked }">
                                                <div
                                                    :class="[color.selectedColor, active && checked ? 'ring ring-offset-1' : '', !active && checked ? 'ring-2' : '', '-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none']">
                                                    <RadioGroupLabel as="span" class="sr-only">
                                                        {{ color }}
                                                    </RadioGroupLabel>
                                                    <span aria-hidden="true" :style="'background-color:' + color"
                                                        :class="['h-8 w-8 border border-black border-opacity-10 rounded-full']" />
                                                </div>
                                            </RadioGroupOption>
                                        </span>
                                    </RadioGroup>

                                    <div class="mt-10">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-md text-gray-600">Select by Sizes</h3>
                                            <a href="#"
                                                class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Size
                                                guide</a>
                                        </div>

                                        <RadioGroup v-model="selectedSize" class="mt-4">
                                            <RadioGroupLabel class="sr-only"> Choose a size </RadioGroupLabel>
                                            <div class="grid grid-cols-4 gap-4 sm:grid-cols-8 lg:grid-cols-4">
                                                <RadioGroupOption as="template" v-for="size in sizes" :key="size.name"
                                                    :value="size" :disabled="!size.inStock"
                                                    v-slot="{ active, checked }">
                                                    <div
                                                        :class="[size ? 'bg-white shadow-sm text-gray-900 cursor-pointer' : 'bg-gray-50 text-gray-200 cursor-not-allowed', active ? 'ring-2 ring-indigo-500' : '', 'group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6']">
                                                        <RadioGroupLabel as="span">
                                                            {{ size }}
                                                        </RadioGroupLabel>
                                                        <span v-if="size"
                                                            :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'absolute -inset-px rounded-md pointer-events-none']"
                                                            aria-hidden="true" />
                                                        <span v-else aria-hidden="true"
                                                            class="absolute -inset-px rounded-md border-2 border-gray-200 pointer-events-none">
                                                            <svg class="absolute inset-0 w-full h-full text-gray-200 stroke-2"
                                                                viewBox="0 0 100 100" preserveAspectRatio="none"
                                                                stroke="currentColor">
                                                                <line x1="0" y1="100" x2="100" y2="0"
                                                                    vector-effect="non-scaling-stroke" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </RadioGroupOption>
                                            </div>
                                        </RadioGroup>
                                    </div>
                                </div>

                                <div class="mt-10 flex sm:flex-col1 justify-around">
                                    <button type="button" v-on:click="requestModal = true"
                                        class="max-w-xs flex-1 bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500 sm:w-full">
                                        Request
                                    </button>
                                    <div class="flex items-center">
                                        <svg class="oo sl du ub gq" viewBox="0 0 16 16">
                                            <path
                                                d="M11 0c1.3 0 2.6.5 3.5 1.5 1 .9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.4 3.5l-1.2 1.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l1.1-1.2c.6-.5.9-1.3.9-2.1s-.3-1.6-.9-2.2C12 1.7 10 1.7 8.9 2.8L7.7 4c-.4.4-1 .4-1.4 0-.4-.4-.4-1 0-1.4l1.2-1.1C8.4.5 9.7 0 11 0ZM8.3 12c.4-.4 1-.5 1.4-.1.4.4.4 1 0 1.4l-1.2 1.2C7.6 15.5 6.3 16 5 16c-1.3 0-2.6-.5-3.5-1.5C.5 13.6 0 12.3 0 11c0-1.3.5-2.6 1.5-3.5l1.1-1.2c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4L2.9 8.9c-.6.5-.9 1.3-.9 2.1s.3 1.6.9 2.2c1.1 1.1 3.1 1.1 4.2 0L8.3 12Zm1.1-6.8c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-4.2 4.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l4.2-4.2Z">
                                            </path>
                                        </svg>
                                        <a target="_blank" class="text-md gp lm text-indigo-500 xh nq"
                                            :href="props.product.link">Voir le lien</a>
                                    </div>
                                </div>

                                <div id="info-modal" v-show="requestModal" class="m w tx la flex items-center np justify-center vs jj" role="dialog" aria-modal="true" >
                                    <div class="bg-white rounded bd lu up ou oe">
                                        <div class="dz flex fy">
                                            <!-- Icon -->
                                            <div class="od sy rounded-full flex items-center justify-center ub hl">
                                                <svg class="oo sl ub du text-indigo-500" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm1 12H7V7h2v5zM8 6c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <!-- Content -->
                                            <div>
                                                <!-- Modal header -->
                                                <div class="ru">
                                                    <div class="ga gh text-slate-800">Send Request for <span class="font-weight">{{ props.product.name }}</span></div>
                                                </div>
                                                <!-- Modal content -->
                                                <div class="text-sm nx">
                                                    <div class="fb">
                                                        <p>You are about to launch for this product. Your request will be processed before being validated or declined. You will receive an email after the response from our technical team.</p>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="flex flex-wrap justify-end fc">
                                                    <button class="r border-slate-200 hover--border-slate-300 g_" v-on:click="requestModal = false">Cancel</button>
                                                    <button class="r ho xi ye" v-on:click="submitRequest(props.product.id)">Yes, Create it</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </template>
    </AppLayout>
</template>

<script>
export default {
    props: {
        product: Object,
        sizes: [],
        colors: [],
        prices: [],
        selectedColor: null,
        selectedSize: null,
        requestModal : false
    },
    methods: {
        submitRequest(product_id) {
            this.requestModal = false
            axios.post(route('marketplace.request'), { productId: product_id }).then((response) => {
                if (response.data) {
                    // alert('Request envoyé avec succès')
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        timer: 5000,
                        showConfirmButton: false,
                        timerProgressBar: true,
                        icon: 'success',
                        title: 'Product requested successfully. ',
                    })
                } else {
                    // alert('Nous rencontré une erreur')
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        timer: 5000,
                        showConfirmButton: false,
                        timerProgressBar: true,
                        icon: 'error',
                        title: 'We encountered an error',
                    })
                }
            })

        },
        filterDuplicateData(arr) {
            return arr.filter(function (value, index, array) {
                return array.indexOf(value) === index;
            });
        },
        getVariants(attribute, value) {
            const variants = this.product.variants.filter(x => x[attribute] == value)
            console.log(variants)
        },
        getAllAttributes(attribute, array) {
            return this.filterDuplicateData(array.map(el => el[attribute]))
        },
        showRequestModal() {
            this.requestModal = !this.requestModal
        }
    },
    created() {
        this.sizes = this.getAllAttributes('size', this.product.variants)
        this.colors = this.getAllAttributes('color', this.product.variants)
        this.prices = this.getAllAttributes('pu', this.product.variants)
        this.selectedColor = ref(this.colors[0])
        this.selectedSize = ref(this.sizes[0])
        console.log(this.product.variants);
    }
}
</script>

<style>
</style>
