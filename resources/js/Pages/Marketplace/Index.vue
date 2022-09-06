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
const props = defineProps({
  filters: Object,
  products: Array,
  countries: Array,
  categories: Array,
});

const form = useForm({
  paginate : props.filters.paginate,
  search : props.filters.search,
  country : props.filters.country ?? null,
  category : props.filters.category ?? null,
})

const paginations = [12, 24, 50, 100]

watch(form, (newValue) => {
  if (newValue) {
    Inertia.get(route('marketplace.index'), pickBy(newValue), { preserveState: true })
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


      <TransitionRoot as="template" :show="open">
      <Dialog as="div" class="relative z-40 sm:hidden" @close="open = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-black bg-opacity-25" />
        </TransitionChild>

        <div class="fixed inset-0 z-40 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="translate-x-full">
            <DialogPanel class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
              <div class="flex items-center justify-between px-4">
                <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                <button type="button" class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400" @click="open = false">
                  <span class="sr-only">Close menu</span>
                  <XCircleIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <!-- Filters -->
              <div class="mx-auto max-w-2xl py-4 px-4 sm:py-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <ul class="flex flex-wrap ">
                  <li class="m-1">
                    <select class="a ou rounded-full" v-model="form.country">
                      <option disabled :value="null">Filter by country</option>
                      <option value="all">All countries</option>
                      <option v-for="country in countries" :key="country.id" :value="country.country">{{ country.country }}</option>
                    </select>
                  </li>
                  <li class="m-1">
                    <select v-model="form.category" class="a ou rounded-full">
                      <option disabled :value="null">Filter by category</option>
                      <option value="all">All categories</option>
                      <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                      </option>
                    </select>
                  </li>
                  <li class="m-1">
                    <input class="s ou me xq border-1 border-slate-200 rounded-full w-full m-0 p-1" type="search"
                      placeholder="Search product…" v-model="form.search" />
                  </li>
                  <li>
                    <select v-model="form.paginate" id="country" class="a ou rounded-full">
                      <option disabled selected>Showing</option>
                      <option v-for="(pagination, index) in paginations" :key="index"  :value="pagination">{{ pagination }}</option>
                    </select>
                  </li>
                </ul>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>

      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded shadow-md pb-4 xl:mx-20 ">

        <!-- Filters -->
        <div class="mx-auto max-w-2xl py-4 px-4 sm:py-4 sm:px-6 lg:max-w-7xl lg:px-8 hidden sm:block">
          <ul class="flex flex-wrap ">
            <li class="m-1">
              <select class="a ou rounded-full" v-model="form.country">
                <option disabled :value="null">Filter by country</option>
                <option value="all">All countries</option>
                <option v-for="country in countries" :key="country.id" :value="country.country">{{ country.country }}</option>
              </select>
            </li>
            <li class="m-1">
              <select v-model="form.category" class="a ou rounded-full">
                <option disabled :value="null">Filter by category</option>
                <option value="all">All categories</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                </option>
              </select>
            </li>
            <li class="m-1">
              <input class="s ou me xq border-1 border-slate-200 rounded-full w-full m-0 p-1" type="search"
                placeholder="Search product…" v-model="form.search" />
            </li>
            <li>
              <select v-model="form.paginate" id="country" class="a ou rounded-full">
                <option disabled>Showing</option>
                <option v-for="(pagination, index) in paginations" :key="index"  :value="pagination">{{ pagination }}</option>
              </select>
            </li>
          </ul>
        </div>

        <button type="button" class="inline-block text-sm font-medium text-gray-700 hover:text-gray-900 sm:hidden" @click="open = true">Filters</button>

        <!-- Cards 1 (Video Courses) -->
        <div>
          <div class="mx-auto max-w-2xl py-4 px-4 sm:py-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Products</h2>
            <div class="text-sm text-slate-500 mb-2" v-if="products?.data">{{ products.data.length }} {{
              (products.data.length > 1) ?
                'Products' : 'Product' }}
            </div>

           <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
              <Link v-for="product in products.data" :key="product.id" :href="route('marketplace.detail', product.slug)"
                class="group relative">
              <div
                class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8 hover:shadow-xl">
                <img :src="product.photo" :alt="product.name"
                  class="h-full w-full object-cover object-center group-hover:opacity-75" />
              </div>
              <h3 class="mt-4 text-sm text-gray-700">{{ product.name }}</h3>
              <p class="mt-1 text-lg font-medium text-primary-800">{{ product.recommanded_price+' SAR' }}</p>
              <p class="mt-1 text-lg font-medium text-primary-700">Commission : {{ '$'+product.commission }}</p>
              </Link>
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
        </div>
        <!-- Pagination -->
        <div class="rk">
          <div class="flex ak ja jc jd">
            <nav class="ri _y _f" role="navigation" aria-label="Navigation"
              v-if="products.next_page_url || products.prev_page_url">
              <ul class="flex justify-center">
                <li class="ml-3 first--ml-0">
                  <Link :href="products.prev_page_url"
                    class="btn bg-white border-slate-200 yf af hover--border-slate-300 text-indigo-500">&lt;-
                    Previous</Link>
                </li>
                <li class="ml-3 first--ml-0">
                  <Link :href="products.next_page_url"
                    class="btn bg-white border-slate-200 hover--border-slate-300 text-indigo-500">Next -&gt;
                  </Link>
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
