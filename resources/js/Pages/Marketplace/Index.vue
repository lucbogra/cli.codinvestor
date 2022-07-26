<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, onMounted, computed } from 'vue';
import { InertiaLink } from '@inertiajs/inertia-vue3'
const props = defineProps({
    categories: Array,
    products: Array,
    countries: Array,
});

const list = () => {
    return props.categories.map((category) => {
        return {
            id: category.id,
            name: category.name,
            photo: category.photo
        }
    })
}

const listProducts = () => {
    return props.products.map((product) => {
        return {
            id: product.id,
            slug: product.slug,
            description: product.description,
            name: product.name,
            photo: product.photo
        }
    })
}
const listCountries = () => {
    return props.countries.map((country) => {
        return {
            id: country.id,
            name: country.name,
            country: country.country,
        }
    })
}

onMounted(() => {
    console.log(props);
})


const datas = ref(list());
const products = ref(listProducts());
const countriesData = ref(listCountries());
</script>
<template>
    <AppLayout title="Marketplace">
        <template #page-header>
            <div class="mx-3">
                <h1 class="text-2xl text-slate-800 font-bold">Find the right product for you ✨</h1>
                <div class="flex ak fq ja jv jm zh zx zk tnq trr tri iv">

                     <!-- Sidebar -->
                    <!-- <div>
                        <div class="bg-white bd rounded-sm border border-slate-200 dz ur">
                            <div class="sn zl tn_ fn"> -->
                                <!-- Group 1 -->
                                <!-- <div>
                                    <div class="text-sm text-slate-800 gh ro">Categories</div>
                                    <ul class="text-sm gp fb">
                                        <li v-for="category in datas" :key="category.id">
                                            <inertia-link class="g_ xp capitalize text-base font-bold"
                                                :href="route('marketplace.index') + '?category=' + category.id">{{
                                                category.name }}</inertia-link>
                                        </li>
                                    </ul>
                                </div> -->
                                <!-- Price Range -->
                                <!-- <div>
                                    <div class="text-sm text-slate-800 gh ro">Country Range</div>
                                    <label class="d">Country</label>
                                    <select class="a ou">
                                        <option disabled selected>Filter by country</option>
                                        <option v-for="country in countriesData" :key="country.id">{{ country.country }}</option>
                                    </select>
                                </div> -->
                            <!-- </div>
                        </div>
                    </div> -->

                    <!-- Content -->
                    <div>
                        <!-- Filters -->
                        <div class="ii">
                            <ul class="flex flex-wrap -m-1">
                                <!-- <li class="m-1">
                                    <inertia-link :href="route('marketplace.index')"
                                        class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border cp bv ho ye wi wu py-2">View
                                        All</inertia-link>
                                </li> -->
                                <li class="m-1">
                                    <inertia-link :href="route('marketplace.index') + '?sort_by=newest'"
                                        class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border py-2 border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">Newest</inertia-link>
                                </li>
                                <li class="m-1">
                                    <inertia-link :href="route('marketplace.index') + '?sort_by=oldest'"
                                        class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border py-2 border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">Oldest</inertia-link>
                                </li>
                                <li class="m-1">
                                    <inertia-link
                                        class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border py-2 border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">Price
                                        - Low To High</inertia-link>
                                </li>
                                <li class="m-1">
                                    <inertia-link
                                        class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border py-2 border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">Price
                                        - High to Low</inertia-link>
                                </li>
                                <li class="m-1">
                                    <select class="a ou rounded-full">
                                        <option disabled selected>Filter by country</option>
                                        <option v-for="country in countriesData" :key="country.id">{{ country.country }}</option>
                                    </select>
                                </li>
                                <li class="m-1">
                                    <select  v-model="seletedCategory" class="a ou rounded-full" @change="filterByCategory($event)">
                                        <option disabled selected value="0">Filter by category</option>
                                        <option v-for="category in datas" :key="category.id" :value="category.id">{{ category.name }}</option>
                                    </select>
                                </li>
                                <li class="m-1">
                                    <input class="s ou me xq border-1 border-slate-200 rounded-full m-0 p-1"
                                        type="search" placeholder="Search product…" v-on:keyup="search"
                                        v-model="searchValue" />
                                </li>
                            </ul>
                        </div>
                        <div class="text-sm text-slate-500 gm ri">{{ products.length }} {{ (products.length > 1) ?
                            'Products' : 'Product' }}</div>
                        <!-- Cards 1 (Video Courses) -->
                        <div>
                            <div class="sn ag fn" v-if="products.length > 0">
                                <!-- Card 1 -->
                                <div class="tz qd tns bg-white bd rounded-sm border border-slate-200 la"
                                    v-for="product in products" :key="product.id">
                                    <div class="flex ak sh">
                                        <!-- Image -->
                                        <div class="y">
                                            <img class="ou" :src="product.photo" width="301" height="226"
                                                alt="Application 21">
                                        </div>
                                        <!-- Card Content -->
                                        <div class="uw flex ak dz">
                                            <!-- Card body -->
                                            <div class="uw">
                                                <header class="ru">
                                                    <inertia-link :href="route('marketplace.detail', product.slug)">
                                                        <h3 class="ga text-slate-800 gh rt">{{ product.name }}</h3>
                                                    </inertia-link>
                                                    <div class="text-sm">{{ product.description }}</div>
                                                </header>
                                            </div>
                                            <!-- Rating and price -->
                                            <div class="flex flex-wrap fe items-center">
                                                <inertia-link class="btn ou ho xi ye" :href="route('marketplace.detail', product.slug)">Details</inertia-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="" v-if="products.length === 0">
                                <div class="flex justify-center">
                                    <div
                                        class="inline-flex items-center justify-center go gp vp vf bg-white border border-slate-200 rounded-full ny">
                                        No product available for this category 😪
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pagination -->
                        <div class="rk">
                            <div class="flex ak ja jc jd">
                                <nav class="ri _y _f" role="navigation" aria-label="Navigation">
                                    <ul class="flex justify-center">
                                        <li class="ml-3 first--ml-0">
                                            <a class="btn bg-white border-slate-200 yf af" href="#0" disabled="">&lt;-
                                                Previous</a>
                                        </li>
                                        <li class="ml-3 first--ml-0">
                                            <a class="btn bg-white border-slate-200 hover--border-slate-300 text-indigo-500"
                                                href="#0">Next -&gt;</a>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="text-sm text-slate-500 gn qe">
                                    Showing <span class="gp g_">1</span> to <span class="gp g_">10</span> of <span
                                        class="gp g_">467</span> results
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
import axios from 'axios';
export default {
    data() {
        return {
            searchValue: null,
            products: [],
            seletedCategory: 0,
        }
    },
    methods: {
        search() {
            axios.get(route('marketplace.search'), { params: { keywords: this.searchValue } }).then(response => {
                this.products = response.data
            })
        },
        filterByCategory(event) {
            this.$inertia.get(route('marketplace.index'))
        }
    }
}
</script>

<style>
</style>
