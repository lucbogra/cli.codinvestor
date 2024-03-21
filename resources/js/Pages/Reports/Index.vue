<script setup>
import { onMounted, ref, defineAsyncComponent } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import LoadingButton from '@/Components/LoadingButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Products from './Products.vue';
import ReportTop from './ReportTop.vue';
import PageLoader from './PageLoader.vue';
import { Inertia } from '@inertiajs/inertia';
import { pickBy } from 'lodash';
import DataPagination from '@/Components/DataPagination.vue';

const props = defineProps({
  daterange: Array,
  countries: Array,
  allCountries: Array
})

const form = useForm({
  daterange: props.daterange,
  countries: props.countries
})

const dataByProducts = ref(null)
const topData = ref(null)

onMounted(async () => {
  getByProductData()
  getTopData()
})

const productsDataIsLoading = ref(false)
const getByProductData = async () => {
  productsDataIsLoading.value = true

  const res = await axios.get(route('reports.data.products', { daterange: form.daterange, countries: form.countries }))
  dataByProducts.value = res.data

    productsDataIsLoading.value = false

}

const topDataIsLoading = ref(false)
const getTopData = async () => {
  topDataIsLoading.value = true

  const res = await axios.get(route('reports.top', { daterange: form.daterange, countries: form.countries }))
  topData.value = res.data

  topDataIsLoading.value = false
}

const isLoading = ref(false)

const submit = async () => {
  isLoading.value = true
  Inertia.get(route('reports.index'), pickBy(form), {preserveState : true} )
  getByProductData()
  getTopData()
  isLoading.value = false
}


const LoadingOverlay = defineAsyncComponent(() =>
  import('@/Components/LoadingOverlay.vue')
)

const getProductsDataByPagination = async (url) => {
  productsDataIsLoading.value = true
  const res = await axios.get(url)
  dataByProducts.value = res.data
  productsDataIsLoading.value = false
}

</script>

<template>
  <AppLayout title="Reports">
     <template #page-header>
      <div class="mt-2 p-5 mx-10">
        <div class="">
          <h1 class="gu teu text-primary-800 font-bold">Reports</h1>
        </div>
      </div>
    </template>

    <template #content>
      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 -mt-12">
      <div class="bg-white p-4 grid md:grid-cols-2 sm:grid-cols-1 rounded-md mb-5">
        <div class="my-2">
          <form @submit.prevent="submit">
          <div class="flex">
            <div class="block mr-4">
              <el-date-picker v-model="form.daterange" type="daterange" range-separator="To"
                start-placeholder="Start date" end-placeholder="End date" format="YYYY-MM-DD" value-format="YYYY-MM-DD" />
            </div>
            <div class="mx-4">
              <el-select v-model="form.countries" multiple collapse-tags collapse-tags-tooltip :max-collapse-tags="5"
                placeholder="countries" style="width: 480px">
                <el-option v-for="item in allCountries" :key="item" :label="item" :value="item" />
              </el-select>
            </div>
            <div class="">
              <LoadingButton :loading="topDataIsLoading || productsDataIsLoading" class="btn-primary ml-4" type="submit">Submit</LoadingButton>
            </div>
          </div>
        </form>
        </div>
      </div>

      <PageLoader v-if="dataByProducts == null" />

      <ReportTop v-if="topData != null" :datas="topData" />

      <Products v-if="dataByProducts != null" :products="dataByProducts" >
        <template #pagination>
          <div class="py-2 flex justify-end">
            <DataPagination :links="dataByProducts.links" @get-datas="getProductsDataByPagination" />
          </div>
        </template>
      </Products>
    </div>
      <LoadingOverlay :is-loading="topDataIsLoading || productsDataIsLoading" />
    </template>


  </AppLayout>
</template>
