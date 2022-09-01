
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, computed } from 'vue';
import {
  TabGroup, TabList, Tab, TabPanels, TabPanel
} from '@headlessui/vue'
import Uploaded from './Uploaded.vue'
import Duplicated from './Duplicated.vue'
import Rejected from './Rejected.vue'
import WrongNumber from './WrongNumber.vue'
const props = defineProps({
  orders : Array,
})

const rejecteds = computed(() => props.orders.filter(el => el.status == 'rejected' ))
const duplicates = computed(() => props.orders.filter(el => el.duplicate == true))
const wrong_number = computed(() => props.orders.filter(el => el.status == 'wrong number'))

const filters = ref({
  all: { value: '', keys: ['customer_name', 'phone', 'country', 'city', 'product_name', 'price', 'website', 'created_at'] }
})
const colorx = ref('#0F7490')


</script>
<template>
  <AppLayout title="Orders">
    <template #page-header>
      <div class="je jd jc ii mt-2 p-5 mx-10">
        <div class="ri _y">
          <h1 class="gu teu text-slate-800 font-bold">Today's orders ✨</h1>
        </div>
      </div>
    </template>
    <template #content>

      <div class="px-8 py-16 sm:px-0 mx-10 -mt-12">
        <TabGroup :defaultIndex="0">
          <TabList class="flex space-x-1 rounded-xl p-1" :style="'background-color :' + colorx">
            <Tab v-slot="{ selected }" as="template" @click="colorx = '#0F7490'">
              <button
                :class="['w-full rounded-lg py-2.5 text-sm font-medium leading-5 text-white',
                'ring-white ring-opacity-60 ring-offset-2 ring-offset-cyan-400 focus:outline-none focus:ring-2',
                selected ? 'bg-white shadow text-cyan-500' : 'text-white hover:bg-white/[0.12] hover:text-white',]">
                <!-- <UploadIcon class=" mr-1.5 h-5 w-5 text-cyan-500" aria-hidden="true"/> -->
                Uploaded <span class=" rounded px-2 bg-cyan-500 text-white">{{ orders.length }}</span>
              </button>
            </Tab>

            <Tab v-slot="{ selected }" as="template" @click="colorx = '#1B2E51'">
              <button
                :class="['w-full rounded-lg py-2.5 text-sm font-medium leading-5 text-white',
                'ring-white ring-opacity-60 ring-offset-2 ring-offset-primary-500 focus:outline-none focus:ring-2',
                selected ? 'bg-white shadow text-primary-800' : 'text-white hover:bg-white/[0.12] hover:text-white',]">
                Duplicate <span class=" rounded px-2 bg-primary-800 text-white">{{ duplicates.length }}</span>
              </button>
            </Tab>

            <Tab v-slot="{ selected }" @click="colorx = '#F2135D'" as="template">
              <button
                :class="['w-full rounded-lg py-2.5 text-sm font-medium leading-5 text-white', 'ring-white ring-opacity-60 ring-offset-2 ring-offset-red-700 focus:outline-none focus:ring-2', selected ? 'bg-white shadow text-danger' : 'text-white hover:bg-white/[0.12] hover:text-white',]">
                Rejected <span class=" rounded px-2 bg-danger text-white">{{ rejecteds.length }}</span>
              </button>
            </Tab>

            <Tab v-slot="{ selected }" @click="colorx = '#F29104'" as="template">
              <button
                :class="['w-full rounded-lg py-2.5 text-sm font-medium leading-5 text-white',
                'ring-white ring-opacity-60 ring-offset-2 ring-offset-orange-700 focus:outline-none focus:ring-2',
                selected ? 'bg-white shadow text-orange-600' : 'text-white hover:bg-white/[0.12] hover:text-white',]">
                Wrong Number <span class=" rounded px-2 bg-orange-600 text-white">{{ wrong_number.length }}</span>
              </button>
            </Tab>


          </TabList>

          <TabPanels class="mt-2">
            <TabPanel
              :class="['rounded-xl bg-white p-3', 'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',]">
              <Uploaded :orders="orders" />

            </TabPanel>

            <TabPanel
              :class="['rounded-xl bg-white p-3', 'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',]">
              <Duplicated :orders="duplicates" />
            </TabPanel>

            <TabPanel
              :class="['rounded-xl bg-white p-3', 'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',]">
              <Rejected :orders="rejecteds" />
            </TabPanel>

            <TabPanel
              :class="['rounded-xl bg-white p-3', 'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',]">
              <WrongNumber :orders="wrong_number" />
            </TabPanel>


          </TabPanels>
        </TabGroup>
      </div>
    </template>
  </AppLayout>
</template>


<script >

import axios from 'axios';
export default {
  data() {
    return {
    }
  },
  methods: {

  }
}
</script>

<style>
</style>
