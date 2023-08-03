<script setup>
import { computed, defineAsyncComponent, onMounted, onUnmounted, ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3'
import pickBy from 'lodash/pickBy'
import LoadingButton from '@/Components/LoadingButton.vue'
import {
  TabGroup, TabList, Tab, TabPanels, TabPanel
} from '@headlessui/vue'
import Layout from './Layout.vue';

const props = defineProps({
  orders: Object,
  daterange: Array,
})


const form = useForm({
  search: null,
  daterange: props.daterange
});

let filteredOrders = computed(() =>
  form.search === null
    ? Object.values(props.orders)
    : Object.values(props.orders).map((orders) =>
      orders.filter((order) => (order.customer_name + order.phone + order.customer_city + order.product_name + order.status + order.status_date).toLowerCase()
        .replace(/\s+/g, '')
        .includes(form.search.toLowerCase().replace(/\s+/g, ''))
      )

    )
)
const submit = () => {
  form.get(route('orders.history'),{

  })
}

// const interval = (date) => {
//   const end = new Date()
//   const start = new Date()
//   start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
//   return !(date >= start && date <= end)
// }
// const datePickerOptions = {
//   disabledDate : interval()
// }
const shortcuts = [
  {
    text: 'Last 7 days',
    value: () => {
      const end = new Date()
      const start = new Date()
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
      return [start, end]
    },
  },
  {
    text: 'Last month',
    value: () => {
      const end = new Date()
      const start = new Date()
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
      return [start, end]
    },
  },
  {
    text: 'Last 3 months',
    value: () => {
      const end = new Date()
      const start = new Date()
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
      return [start, end]
    },
  },
]
</script>

<template>
  <Layout :selected_menu='"History"'>
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between mb-4">
        <form class="flex" @submit.prevent="submit">
          <div class="block mr-4">
            <el-date-picker v-model="form.daterange" type="daterange" range-separator="To" start-placeholder="Start date"
              end-placeholder="End date" format="YYYY-MM-DD" value-format="YYYY-MM-DD" :shortcuts="shortcuts" />
          </div>
          <div>
            <LoadingButton :loading="form.processing" class="btn-primary ml-4" type="submit">Submit</LoadingButton>
          </div>
        </form>
        <input name="" class="a ou rounded-full w-52 hidden sm:block" placeholder="search..." v-model="form.search" />
      </div>
      <TabGroup>
        <TabList class="flex space-x-1 rounded-xl bg-primary-800 p-1">
          <Tab v-for="(tab, key) in Object.keys(orders)" as="template" :key="key" v-slot="{ selected }">
            <button :class="['w-full rounded-lg py-2.5 text-sm font-medium leading-5 text-white',
              'ring-white ring-opacity-60 ring-offset-2 ring-offset-primary-400 focus:outline-none focus:ring-2',
              selected ? 'bg-white shadow text-primary-500' : 'hover:bg-white/[0.12] hover:text-white',]">
              {{ tab }}
              <span :class="['rounded px-2', selected ? 'bg-primary-500 text-white' : 'bg-white text-primary-800']">{{ ( filteredOrders[key].length ) }}</span>
            </button>
          </Tab>
        </TabList>

        <TabPanels class="mt-2">
          <TabPanel v-for="(datas, idx) in filteredOrders" :key="idx" :class="['rounded-xl bg-white p-3',
            'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',]">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div
                  class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg divide-y divide-gray-300">

                  <VTable :data="datas" class="min-w-full table-fixed divide-y divide-gray-300">
                    <template #head>
                      <tr class="bg-gray-50">
                        <th class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Last Update</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Customer Name</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">sku</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" v-if="datas[0]?.status == 'no answer'">Attempts</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" v-if="['confirmed', 'Delivered', 'Delivery In Progress', 'Returned'].includes(datas[0]?.status)">Ordered products</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" v-if="['confirmed', 'Delivered', 'Delivery In Progress'].includes(datas[0]?.status)">Commission</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" v-if="datas[0]?.status == 'cancelled'">Cancel Reason</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" v-if="datas[0]?.status == 'closed'">Reason for closing</th>
                        <!-- <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">website</th> -->
                      </tr>
                    </template>
                    <template #body="{ rows }">
                      <tr v-for="row in rows" :key="row.id"
                        class="divide-y divide-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="whitespace-nowrap py-4 px-3 text-sm font-medium text-gray-600">
                          {{ row.status_date }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {{ row.customer_name }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {{ row.phone }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {{ row.country + '-' + row.customer_city }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                          {{ row.product_name }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-orange-600"  v-if="datas[0]?.status == 'no answer'">
                          {{ row.tries }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900" v-if="['confirmed', 'Delivered', 'Delivery In Progress', 'Returned'].includes(datas[0]?.status)">
                          <span class="mr-2" v-for="(line, index) in row.supplier_products" :key="index"> {{ line.variant.sku+' ('+line.pivot.qty+')' }} </span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500" v-if="['confirmed', 'Delivered', 'Delivery In Progress'].includes(datas[0]?.status)">
                          {{ row.commission }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500" v-if="row.status == 'cancelled'">
                          {{ row.cancel_reason }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500" v-if="row.status == 'closed'">
                          {{ row.before_closed }}</td>
                      </tr>
                      <tr v-if="rows.length === 0">
                        <td class="border-t px-6 py-4" colspan="4">No order found.</td>
                      </tr>
                    </template>
                  </VTable>

                </div>
              </div>
            </div>

          </TabPanel>
        </TabPanels>
      </TabGroup>
    </div>
  </Layout>
</template>
