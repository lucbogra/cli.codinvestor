<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, watch } from 'vue';
import { Link, useForm } from '@inertiajs/inertia-vue3'
import pickBy from 'lodash/pickBy'
import { Inertia } from '@inertiajs/inertia';
import { auth } from '../Permissions';
import "/node_modules/flag-icons/css/flag-icons.min.css";
import Pagination from './Pagination2.vue';
import JetInput from '@/Jetstream/Input.vue';
import SingleProduct from './SingleProduct.vue';

const props = defineProps({
  filters: Object,
  products: Array,
  countries: Array,
  categories: Array,
});

const form = useForm({
  paginate : props.filters.paginate ?? 12,
  search : props.filters.search,
  country : props.filters.country ?? null,
  category : props.filters.category ?? null,
  niche : props.filters.niche
})

const paginations = [12, 24, 50, 100]

watch(form, (newValue) => {
  if (newValue) {
    Inertia.get(route('marketplace.index'), pickBy(newValue), { preserveState: false })
  }

})
const open = ref(false)

</script>
<template>
  <AppLayout title="Marketplace">
    <template #page-header>
       <div class="mt-2 p-5 mx-10">
        <div class="">
          <h1 class="gu teu text-primary-800 font-bold">Marketplace</h1>
        </div>
      </div>
    </template>
    <template #content>


      <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 rounded pb-4 xl:mx-10 ">

        <!-- Filters -->
        <div class="max-w-2xl py-4 sm:py-4 lg:max-w-7xl hidden sm:block">
          <ul class="flex flex-wrap gap-x-4 gap-y-2">
            <li class="">
              <select class="block w-full border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" v-model="form.country">
                <option :value="null">All countries</option>
                <option v-for="country in countries" :key="country.id" :value="country.country">{{ country.country }}</option>
              </select>
            </li>
            <li class="">
              <select v-model="form.category" class="block w-full border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                <option :value="null">All categories</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                </option>
              </select>
            </li>
            <li class="">
              <select v-model="form.paginate" id="country" class="block w-full border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                <option disabled>Showing</option>
                <option v-for="(pagination, index) in paginations" :key="index"  :value="pagination">{{ "Showing "+pagination }}</option>
              </select>
            </li>
            <li class="">
              <JetInput class="block"  type="search"
                placeholder="Search product…" v-model="form.search" />
            </li>

          </ul>
        </div>

        <button type="button" class="inline-block text-sm font-medium text-gray-700 hover:text-gray-900 sm:hidden" @click="open = true">Filters</button>


          <div class="mx-auto py-4 px-4 sm:py-4 sm:px-6 lg:max-w-8xl lg:px-8">
            <h2 class="sr-only">Products</h2>
            <div class="text-sm text-slate-500 mb-2" v-if="products?.data">{{ products.data.length }} {{
              (products.data.length > 1) ?
                'Products' : 'Product' }}
            </div>
          </div>



          <div class="-mx-px grid grid-cols-1 gap-4 border-gray-200 sm:mx-0 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <div v-for="product in products.data" :key="product.id" class="">
                <SingleProduct :product="product" />
            </div>
          </div>

          <div class="" v-if="products.length === 0">
            <div class="flex justify-center">
              <div
                class="inline-flex items-center justify-center go gp vp vf bg-white border border-slate-200 rounded-full ny p-4 text-lg">
                No product available
              </div>
            </div>
          </div>


        <Pagination class="mt-4" :datas="products" />
      </div>

    </template>
  </AppLayout>
</template>
