
<script setup>
import { ref, computed } from 'vue';
import {
  TabGroup, TabList, Tab, TabPanels, TabPanel
} from '@headlessui/vue'
import Uploaded from './Uploaded.vue'
import Duplicated from './Duplicated.vue'
import Rejected from './Rejected.vue'
import WrongNumber from './WrongNumber.vue'
import UploadForm from './UploadForm.vue';
import Layout from './Layout.vue';
const props = defineProps({
  orders : Array,
  demo_file: String,
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
  <Layout :selected_menu="'Today\'s orders'">
    <!-- <template #page-header>
      <div class="mt-2 p-5 mx-10">
        <div class="">
          <h1 class="gu teu text-primary-800 font-bold">Today's orders</h1>
        </div>
      </div>
    </template> -->

    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 sm:hidden">
      <UploadForm />
      <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Orders</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Number</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr>
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Uploaded</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{orders.length}}</td>
                </tr>
                <tr>
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Duplicate</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{duplicates.length}}</td>
                </tr>
                <tr>
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Rejected</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{rejecteds.length}}</td>
                </tr>
                <tr>
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Wrong Number</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{wrong_number.length}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>


      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 hidden sm:block">
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
              <Uploaded :orders="orders" :demo_file="demo_file" />

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
  </Layout>
</template>

