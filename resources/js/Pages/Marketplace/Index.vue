<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3'
import { Link } from '@inertiajs/inertia-vue3';
import pickBy from 'lodash/pickBy'
import { Inertia } from '@inertiajs/inertia';
import { XCircleIcon } from '@heroicons/vue/outline'
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { auth } from '../Permissions';
import "/node_modules/flag-icons/css/flag-icons.min.css";
import Pagination from './Pagination.vue';
import JetInput from '@/Jetstream/Input.vue';

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


      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded pb-4 xl:mx-10 ">

        <!-- Filters -->
        <div class="max-w-2xl py-4 px-4 sm:py-4 sm:px-6 lg:max-w-7xl lg:px-8 hidden sm:block">
          <ul class="flex flex-wrap gap-x-4 gap-y-2">
            <li class="">
              <select class="block w-full rounded-full border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" v-model="form.country">
                <option :value="null">All countries</option>
                <option v-for="country in countries" :key="country.id" :value="country.country">{{ country.country }}</option>
              </select>
            </li>
            <li class="">
              <select v-model="form.category" class="block w-full rounded-full border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                <option :value="null">All categories</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                </option>
              </select>
            </li>
            <li class="">
              <select v-model="form.paginate" id="country" class="block w-full border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm rounded-full">
                <option disabled>Showing</option>
                <option v-for="(pagination, index) in paginations" :key="index"  :value="pagination">{{ "Showing "+pagination }}</option>
              </select>
            </li>
            <li class="">
              <JetInput class="block w-full rounded-full"  type="search"
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

           <!-- <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-4 md:gap-y-0">
              <Link v-for="product in products.data" :key="product.id" :href="route('marketplace.detail', product.slug)"
                class="group relative border px-2 pt-2 mb-6">
              <div
                class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8 hover:shadow-xl">
                <img :src="product.photo" :alt="product.name"
                  class="h-full w-full object-cover object-center group-hover:opacity-75" />
              </div>
              <h3 class="mt-4 text-sm text-gray-700">{{ product.name }}</h3>
              <p class="mt-1 text-lg font-medium text-primary-800">{{ product.recommanded_price+' SAR' }}</p>
              <p class="mt-1 text-lg font-medium text-primary-700">Commission : {{ '$'+product.commission }}</p>
              </Link>
            </div> -->

            <!-- <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
              <div v-for="product in products.data" :key="product.id" class="group relative">
                <div class="min-h-80 aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                  <img :src="product.photo" :alt="product.name" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                </div>
                <div class="mt-4 flex justify-between">
                  <div>
                    <h3 class="text-sm text-gray-700">
                      <Link :href="route('marketplace.detail', product.slug)">
                        <span aria-hidden="true" class="absolute inset-0 truncate" />
                        {{ product.name }}
                      </Link>
                    </h3>
                    <p class="mt-1 text-sm text-orange-600">{{ 'Commission : $'+product.commission }}</p>
                  </div>
                  <p class="text-sm font-medium text-gray-900">{{ product.recommanded_price+' SAR' }}</p>
                </div>
              </div>
            </div> -->

            <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:grid-cols-3 lg:gap-x-8">
              <div v-for="product in products.data" :key="product.id" class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white">
                <div class="aspect-h-4 aspect-w-3 bg-gray-200 sm:aspect-none group-hover:opacity-75 sm:h-96">
                  <img :src="product.photo" :alt="product.name" class="h-full w-full object-cover object-center sm:h-full sm:w-full" />
                </div>
                <div class="flex justify-between">
                   <div class="flex flex-1 flex-col space-y-2 p-4">
                    <h3 class="text-sm font-medium text-gray-900">
                      <a :href="route('marketplace.detail', product.slug)">
                        <span aria-hidden="true" class="absolute inset-0" />
                        {{ product.name }}
                      </a>
                    </h3>
                    <div class="flex flex-1 flex-col justify-end" v-if="auth.hasRole('Investor')">
                      <p class="text-sm text-gray-900">{{ 'starts from '+ product.recommanded_price+' SAR' }}</p>
                      <p class="text-base font-medium text-orange-600">{{ 'Commission : up to $'+product.commission }}</p>
                    </div>
                    <div v-for="(item, index) in product.countries" :key="index">
                      <span v-if="item.country == 'Saudi Arabia'" :class="['fi fi-'+item.flag_code, 'mr-2']"></span>
                    </div>
                  </div>

                  <!-- <div class="">
                    <span v-for="(item, index) in product.countries" :key="index" :class="['fi fi-'+item.flag_code]"></span>
                  </div> -->
                </div>

              </div>
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


        <Pagination :datas="products" />
      </div>

    </template>
  </AppLayout>
</template>
