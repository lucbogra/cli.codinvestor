<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, onMounted, computed } from 'vue';
import { InertiaLink } from '@inertiajs/inertia-vue3'
import { Link } from '@inertiajs/inertia-vue3';
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
  console.log(products);
})

const datas = ref(list());
const products = props.products;
const countriesData = ref(listCountries());
</script>
<template>
  <AppLayout title="Marketplace">
    <template #page-header>
      <div class="bg-slate-100 m-10">
        <div class="flex justify-between">
          <h1 class="text-2xl text-slate-800 font-bold">Find the right product for you ✨</h1>
          <select v-model="seleledShowing" id="country" class="a" @change="filterByShowing($event)">
            <option disabled selected>Showing</option>
            <option :value="10">10</option>
            <option :value="20">20</option>
            <option :value="50">50</option>
          </select>
        </div>
      </div>
    </template>
    <template #content>
      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded ">

        <!-- Filters -->
        <div class="mx-auto max-w-2xl py-4 px-4 sm:py-4 sm:px-6 lg:max-w-7xl lg:px-8">
          <ul class="flex flex-wrap ">
            <li class="m-1">
              <inertia-link :href="route('marketplace.index') + '?sort_by=newest'"
                class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border py-2 border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">
                Newest</inertia-link>
            </li>
            <li class="m-1">
              <inertia-link :href="route('marketplace.index') + '?sort_by=oldest'"
                class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border py-2 border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">
                Oldest</inertia-link>
            </li>
            <li class="m-1">
              <inertia-link
                class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border py-2 border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">
                Price
                - Low To High</inertia-link>
            </li>
            <li class="m-1">
              <inertia-link
                class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border py-2 border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">
                Price
                - High to Low</inertia-link>
            </li>
            <li class="m-1">
              <select class="a ou rounded-full">
                <option disabled selected>Filter by country</option>
                <option v-for="country in countriesData" :key="country.id">{{ country.country }}</option>
              </select>
            </li>
            <li class="m-1">
              <select v-model="seletedCategory" class="a ou rounded-full" @change="filterByCategory($event)">
                <option disabled selected value="0">Filter by category</option>
                <option v-for="category in datas" :key="category.id" :value="category.id">{{ category.name }}
                </option>
              </select>
            </li>
            <li class="m-1">
              <input class="s ou me xq border-1 border-slate-200 rounded-full m-0 p-1" type="search"
                placeholder="Search product…" v-on:keyup="search" v-model="searchValue" />
            </li>
          </ul>
        </div>


        <!-- Cards 1 (Video Courses) -->
        <div>
          <div class="mx-auto max-w-2xl py-4 px-4 sm:py-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Products</h2>
            <div class="text-sm text-slate-500 mb-2" v-if="products?.data">{{ products.data.length }} {{
              (products.data.length > 1) ?
                'Products' : 'Product' }}
            </div>
            <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
              <Link v-for="product in products.data" :key="product.id" :href="route('marketplace.detail', product.slug)"
                class="group">
              <div
                class="aspect-w-1 aspect-h-1 w-full h-72 overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                <img :src="product.photo" :alt="product.name"
                  class="h-full w-full object-cover object-center group-hover:opacity-75" />
              </div>
              <h3 class="mt-4 text-sm text-gray-700">{{ product.name }}</h3>
              <p class="mt-1 text-lg font-medium text-primary-800">{{ product.recommanded_price }} SAR</p>
              <p class="mt-1 text-lg font-medium text-primary-700">Commission : {{ product.commission }} SAR</p>
              </Link>
            </div>
          </div>

          <div class="" v-if="products.length === 0">
            <div class="flex justify-center">
              <div
                class="inline-flex items-center justify-center go gp vp vf bg-white border border-slate-200 rounded-full ny p-4 text-lg">
                No product available for this category 😪
              </div>
            </div>
          </div>
        </div>
        <!-- Pagination -->
        <div class="rk">
          <div class="flex ak ja jc jd">
            <nav class="ri _y _f" role="navigation" aria-label="Navigation"
              v-if="products.next_page_url || products.prev_page_url">
              <ul class="flex justify-center">
                <li class="ml-3 first--ml-0">
                  <inertia-link :href="products.prev_page_url"
                    class="btn bg-white border-slate-200 yf af hover--border-slate-300 text-indigo-500">&lt;-
                    Previous</inertia-link>
                </li>
                <li class="ml-3 first--ml-0">
                  <inertia-link :href="products.next_page_url"
                    class="btn bg-white border-slate-200 hover--border-slate-300 text-indigo-500">Next -&gt;
                  </inertia-link>
                </li>
              </ul>
            </nav>
            <div class="text-sm text-slate-500 gn qe">
              Showing <span class="gp g_">{{ products.per_page }}</span> to <span class="gp g_">{{ products.to
              }}</span> of <span class="gp g_">{{ products.total }}</span> results
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
      seleledShowing: 10
    }
  },
  methods: {
    search() {
      axios.get(route('marketplace.search'), { params: { keywords: this.searchValue } }).then(response => {
        this.products = response.data
      })
    },
    filterByCategory(event) {
      this.$inertia.get(route('marketplace.index') + '?category=' + event.target.value)
    },
    filterByShowing(event) {
      this.$inertia.get(route('marketplace.index') + '?showing=' + event.target.value)
    }
  }
}
</script>

<style>
</style>
