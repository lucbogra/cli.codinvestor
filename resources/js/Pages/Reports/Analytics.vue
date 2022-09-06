<script setup>
import { onMounted, ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import LoadingButton from '@/Components/LoadingButton.vue';
import Performance from './Performance.vue';
import ConfirmationChart from './ConfirmationChart.vue';
import Top from './Top.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  dates: Object,
})

const form = useForm({
  start: props.dates.start,
  end: props.dates.end,
})

const reports = ref(null)
onMounted(async () => {
  const res = await axios.get(route('performance', { start: props.dates.start, end: props.dates.end }))
  reports.value = res.data
})

const submit = async () => {
  const res = await axios.get(route('performance', { start: form.start, end: form.end }))
  reports.value = res.data
}
</script>

<template>
  <AppLayout >
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
            <div class="grid md:grid-cols-3 sm:grid-cols-1 gap-8 items-center">
              <div>
                <!-- <label class="form-label text-l text-gray-500 mx-2">Start:</label> -->
                <input type="date" v-model="form.start" class=" w-full relative rounded-md border-slate-300" :max="form.end"
                  required />
              </div>
              <div>
                <!-- <label class="form-label text-sm text-gray-500 mx-2">End:</label> -->
                <input type="date" v-model="form.end" class=" w-full relative rounded-md border-slate-300" :min="form.start"
                  :max="dates.max" required />
              </div>
              <div class="mx-auto">
                <LoadingButton :loading="form.processing" class="btn-primary ml-4" type="submit">Submit</LoadingButton>
              </div>
            </div>
          </form>
        </div>
        <!-- <div v-if=" auth.hasAnyRole(['Responsible', 'Admin'])" class="grid justify-end my-2">
            <a :href="'/reports/export/' + form.start + '/' + form.end" class="btn-primary"> Export Reports </a>
          </div> -->
      </div>

      <Top v-if="reports != null" :datas="reports"/>
      <div class="hidden sm:block">
        <Performance class="mb-5" v-if="reports != null" :performance="reports.datas" />
        <ConfirmationChart v-if="reports != null" :performance="reports.datas" />
      </div>

    </div>
    </template>


  </AppLayout>
</template>
