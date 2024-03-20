<script setup>
import { onMounted, ref, defineAsyncComponent } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import LoadingButton from '@/Components/LoadingButton.vue';
import Top from './Top.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmationsByDayChart from './ConfirmationsByDayChart.vue';
import UploadsByDayChart from './UploadsByDayChart.vue';
import DeliveriesByDayChart from './DeliveriesByDayChart.vue'
import { Inertia } from '@inertiajs/inertia';
import { pickBy } from 'lodash';

const props = defineProps({
  daterange: Array,
  countries: Array
})

const form = useForm({
  daterange: props.daterange,
  countries: props.countries
})

const reports = ref(null)
const byDayData = ref(null)
const uploadsByDay = ref(null)
const confirmationsByDay = ref(null)
const deliveriesByDay = ref(null)
const isLoading = ref(false)
const uploadsdataIsLoading = ref(false)
const confirmationsDataIsLoading = ref(false)

onMounted(async () => {
  isLoading.value = true

  getTopData()
  getUploadsData()
  getConfirmationsData()

  isLoading.value = false
})

const getTopData = async () => {
  const res = await axios.get(route('analytics.top', { daterange: form.daterange, countries: form.countries }))
  reports.value = res.data
}

const getUploadsData = async () => {
  uploadsdataIsLoading.value = true

  const res2 = await axios.get(route('analytics.byday.uploads', { daterange: form.daterange, countries: form.countries }))
  uploadsByDay.value = res2.data

  uploadsdataIsLoading.value = false
}

const getConfirmationsData = async () => {
  confirmationsDataIsLoading.value = true

  const res3 = await axios.get(route('analytics.byday.confirmations', { daterange: form.daterange, countries: form.countries }))
  confirmationsByDay.value = res3.data

  confirmationsDataIsLoading.value = false
}

const submit = async() => {
  Inertia.get(route('analytics.index'), pickBy(form), { preserveState: true })
  getTopData()
  getUploadsData()
  getConfirmationsData()
}

const LoadingOverlay = defineAsyncComponent(() =>
  import('@/Components/LoadingOverlay.vue')
)

</script>

<template>
  <AppLayout title="Analycs">
     <template #page-header>
      <div class=" mt-2 p-5 mx-10">
        <div class="">
          <h1 class="gu teu text-primary-800 font-bold">Analytics</h1>
        </div>
      </div>
    </template>

    <template #content>
      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 -mt-12">
      <div class="bg-white p-4 grid md:grid-cols-2 sm:grid-cols-1 rounded mb-5 shadow-xl">
        <div class="my-2">
          <form @submit.prevent="submit">
          <div class="flex mb-6">
            <div class="block mr-4">
              <el-date-picker v-model="form.daterange" type="daterange" range-separator="To"
                start-placeholder="Start date" end-placeholder="End date" format="YYYY-MM-DD" value-format="YYYY-MM-DD" />
            </div>
            <div class="mx-4">
              <el-select v-model="form.countries" multiple collapse-tags collapse-tags-tooltip :max-collapse-tags="5"
                placeholder="countries" style="width: 480px">
                <el-option v-for="item in countries" :key="item" :label="item" :value="item" />
              </el-select>
            </div>
            <div class="">
              <LoadingButton :loading="isLoading" class="btn-primary ml-4" type="submit">Submit</LoadingButton>
            </div>
          </div>
        </form>

        </div>

      </div>

      <Top v-if="reports != null" :datas="reports"/>
      <div class="hidden sm:block">
        <div class="grid xl:grid-cols-2 md:grid-cols-1 gap-4 mb-4">


          <LoadingOverlay :is-loading="uploadsdataIsLoading" :full-page="false" >
            <UploadsByDayChart v-if="uploadsByDay != null" :data="uploadsByDay" />
          </LoadingOverlay>

          <LoadingOverlay :is-loading="confirmationsDataIsLoading" :full-page="false" >
            <ConfirmationsByDayChart v-if="confirmationsByDay != null" :data="confirmationsByDay" />
          </LoadingOverlay>

          <!-- <DeliveriesByDayChart v-if="byDayData != null" :data="byDayData" /> -->
        </div>
      </div>

    </div>
    <LoadingOverlay :is-loading="isLoading" />
    </template>


  </AppLayout>
</template>
