<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { onMounted, ref } from 'vue'
import { InertiaLink } from '@inertiajs/inertia-vue3'
import helpers from '@/helpers.js'
import axios from 'axios'
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
} from '@headlessui/vue'
import { StarIcon } from '@heroicons/vue/solid'
import { HeartIcon, MinusSmIcon, PlusSmIcon } from '@heroicons/vue/outline'


const props = defineProps({
    product: Object,
    variants: Array,
    colors: Array,
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
                <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
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
                            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ props.product.name }}</h1>
                            <div class="mt-3">
                                <h2 class="sr-only">Product information</h2>
                                <p class="text-3xl text-blue-700 font-bold">{{ prices[0] }} - {{ prices[1] + ' DHS' }}</p>
                            </div>

                            <div class="mt-6">
                                <h3 class="sr-only">Description</h3>

                                <div class="text-base text-gray-700 space-y-6" v-html="props.product.description" />
                            </div>

                            <div class="mt-6">
                                <!-- Colors -->
                                <div>
                                    <h3 class="text-sm text-gray-600">Color</h3>

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
                                                    <span aria-hidden="true" :style="'background-color:'+ color"
                                                        :class="['h-8 w-8 border border-black border-opacity-10 rounded-full']" />
                                                </div>
                                            </RadioGroupOption>
                                        </span>
                                    </RadioGroup>

                                     <div class="mt-10">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm text-gray-900 font-medium">Size</h3>
                                            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Size guide</a>
                                        </div>

                                        <RadioGroup v-model="selectedSize" class="mt-4">
                                            <RadioGroupLabel class="sr-only"> Choose a size </RadioGroupLabel>
                                            <div class="grid grid-cols-4 gap-4 sm:grid-cols-8 lg:grid-cols-4">
                                            <RadioGroupOption as="template" v-for="size in sizes" :key="size.name" :value="size" :disabled="!size.inStock" v-slot="{ active, checked }">
                                                <div :class="[size ? 'bg-white shadow-sm text-gray-900 cursor-pointer' : 'bg-gray-50 text-gray-200 cursor-not-allowed', active ? 'ring-2 ring-indigo-500' : '', 'group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6']">
                                                <RadioGroupLabel as="span">
                                                    {{ size }}
                                                </RadioGroupLabel>
                                                <span v-if="size" :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'absolute -inset-px rounded-md pointer-events-none']" aria-hidden="true" />
                                                <span v-else aria-hidden="true" class="absolute -inset-px rounded-md border-2 border-gray-200 pointer-events-none">
                                                    <svg class="absolute inset-0 w-full h-full text-gray-200 stroke-2" viewBox="0 0 100 100" preserveAspectRatio="none" stroke="currentColor">
                                                    <line x1="0" y1="100" x2="100" y2="0" vector-effect="non-scaling-stroke" />
                                                    </svg>
                                                </span>
                                                </div>
                                            </RadioGroupOption>
                                            </div>
                                        </RadioGroup>
                                        </div>
                                </div>

                                <div class="mt-10 flex sm:flex-col1">
                                    <button type="button" v-on:click="submitRequest(props.product.id)"
                                        class="max-w-xs flex-1 bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500 sm:w-full">
                                        Request
                                    </button>
                                </div>
                            </div>

                            <!-- <section aria-labelledby="details-heading" class="mt-12">
                                <h2 id="details-heading" class="sr-only">Additional details</h2>

                                <div class="border-t divide-y divide-gray-200">
                                    <Disclosure as="div" v-for="detail in product.details" :key="detail.name"
                                        v-slot="{ open }">
                                        <h3>
                                            <DisclosureButton
                                                class="group relative w-full py-6 flex justify-between items-center text-left">
                                                <span
                                                    :class="[open ? 'text-indigo-600' : 'text-gray-900', 'text-sm font-medium']">
                                                    {{ detail.name }}
                                                </span>
                                                <span class="ml-6 flex items-center">
                                                    <PlusSmIcon v-if="!open"
                                                        class="block h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                                        aria-hidden="true" />
                                                    <MinusSmIcon v-else
                                                        class="block h-6 w-6 text-indigo-400 group-hover:text-indigo-500"
                                                        aria-hidden="true" />
                                                </span>
                                            </DisclosureButton>
                                        </h3>
                                        <DisclosurePanel as="div" class="pb-6 prose prose-sm">
                                            <ul role="list">
                                                <li v-for="item in detail.items" :key="item">{{ item }}</li>
                                            </ul>
                                        </DisclosurePanel>
                                    </Disclosure>
                                </div>
                            </section> -->
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
        selectedSize : null
    },
    methods: {
        submitRequest(product_id) {
            axios.post(route('marketplace.request'), { productId: product_id }).then((response) => {
                if(response.data) {
                    alert('Request envoyé avec succès')
                } else {
                    alert('Nous rencontré une erreur')
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
    },
     created() {
        this.sizes = this.getAllAttributes('size', this.product.variants)
        this.colors = this.getAllAttributes('color', this.product.variants)
        this.prices = this.getAllAttributes('pu', this.product.variants)
        this.selectedColor = ref(this.colors[0])
        this.selectedSize = ref(this.sizes[0])
    }
}
</script>

<style>
</style>
