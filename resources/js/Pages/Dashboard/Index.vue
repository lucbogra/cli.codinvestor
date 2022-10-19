<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { HomeIcon, ChevronLeftIcon } from '@heroicons/vue/solid';
import axios from 'axios';
import { onMounted, ref, watch, defineAsyncComponent } from 'vue';
import Top from './Top.vue';
import ConfirmationChart from './ConfirmationChart.vue';
import Performance from './Performance.vue';
import MonthReport from './MonthReport.vue';

const time = ref('today')
const topDatas = ref(null)
const performance = ref(null)
onMounted(async () => {
  const res = await axios.get(route('dashboard.top', {time:time.value}))
  topDatas.value = res.data

  const perf = await axios.get(route('dashboard.performance'))
  performance.value = perf.data
})
const isLoading = ref(false)
watch(time, async(newValue) => {
  if (newValue) {
    isLoading.value = true
    const res = await axios.get(route('dashboard.top', {time:time.value}))
    topDatas.value = res.data
    isLoading.value = false
  }
})
const LoadingOverlay = defineAsyncComponent(() =>
  import('@/Components/LoadingOverlay.vue')
)
</script>

<template>
    <AppLayout title="Dashboard">
    <template #page-header>
      <div class="max-w-8xl pt-6 mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="sm:hidden" aria-label="Back">
          <a href="#" class="  flex items-center text-sm font-medium text-gray-400 hover:text-gray-200  ">
            <ChevronLeftIcon class="flex-shrink-0 -ml-1 mr-1 h-5 w-5 text-gray-500" aria-hidden="true" />
            Back
          </a>
        </nav>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
          <ol role="list" class="flex items-center space-x-4">
            <li>
              <a href="#" class="text-2xl font-medium text-primary-800 flex hover:text-primary-600">
                <HomeIcon class="w-7 h-7 text-primary-800 mr-2" />
                Dashboard
              </a>
            </li>
          </ol>
        </nav>
      </div>
    </template>

    <template #content>
      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">

        <div class="flex mb-8">
          <button :class="['mr-4', time=='today' ? 'btn-primary' : 'btn-white' ]" @click="time='today'">today</button>
          <button :class="['mr-4', time=='yesterday' ? 'btn-primary' : 'btn-white' ]" @click="time='yesterday'">yesterday</button>
        </div>

        <Top v-if="topDatas !=null" :datas="topDatas" />

        <div class="grid xl:grid-cols-8 grid-rows-2 gap-4">
          <div class="xl:col-span-2 row-span-2 md:col-span-8">
            <MonthReport />
          </div>
          <div class=" xl:col-span-6 md:col-span-8 hidden sm:block">
            <ConfirmationChart class="mb-8" v-if="performance !=null" :performance="performance" />
          </div>
          <div class="xl:col-span-6 md:col-span-8 hidden sm:block">
            <Performance v-if="performance !=null" :performance="performance" />
          </div>
        </div>
      </div>
      <LoadingOverlay :is-loading="isLoading" />
    </template>


    </AppLayout>
</template>
