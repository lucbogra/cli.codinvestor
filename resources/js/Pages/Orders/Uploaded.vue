<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { ref, computed, onMounted } from 'vue';
import UploadForm from './UploadForm.vue';
const props = defineProps({
  orders: Array,
  demo_file: String
})

const filters = ref({
  all: { value: '', keys: ['customer_name', 'phone', 'country', 'city', 'product_name', 'price', 'website', 'created_at'] }
})

onMounted(() =>{
    console.log(props.orders);
});

const selectedOrders = ref([])
const checked = ref(false)
const indeterminate = computed(() => selectedOrders.value.length > 0 && selectedOrders.value.length < props.orders.length)

const currentPage = ref(1)
const totalPages = ref(0)
const tag = ref()
const form = useForm({
  agents: [],
  rows: ''
})

</script>

<template>
  <div>
    <UploadForm :demo_file="demo_file" />
    <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div
            class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg divide-y divide-gray-300">
            <div class="flex justify-between items-center py-2 pr-1 pl-3 bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Orders</h3>
              <input class="form-input w-full lg:w-1/4 rounded-full" placeholder="search..."
                v-model="filters.all.value" />
            </div>
            <VTable :data="orders" :filters="filters" class="min-w-full table-fixed divide-y divide-gray-300"
              :page-size="8" v-model:currentPage="currentPage" @totalPagesChanged="totalPages = $event">
              <template #head>
                <tr class="bg-gray-50">

                  <th class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Date</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Customer Name</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">sku</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">price</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">website</th>
                </tr>
              </template>
              <template #body="{ rows }">
                <tr v-for="row in rows" :key="row.id" class="divide-y divide-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100"
                  :class="[selectedOrders.includes(row.id) && 'bg-gray-50']">

                  <td
                    :class="['whitespace-nowrap py-4 px-3 text-sm font-medium', selectedOrders.includes(row.id) ? 'text-cyan-600' : 'text-gray-900']">
                    {{ row.created_at }}</td>
                  <td
                    :class="['whitespace-nowrap px-3 py-4 text-sm', selectedOrders.includes(row.id) ? 'text-cyan-600' : ' text-gray-500']">
                    {{ row.customer_name }}</td>
                  <td
                    :class="['whitespace-nowrap px-3 py-4 text-sm', selectedOrders.includes(row.id) ? 'text-cyan-600' : ' text-gray-500']">
                    {{ row.phone }}</td>
                  <td
                    :class="['whitespace-nowrap px-3 py-4 text-sm', selectedOrders.includes(row.id) ? 'text-cyan-600' : ' text-gray-500']">
                    {{ row.country + '-' + row.customer_city }}</td>
                  <td
                    :class="['whitespace-nowrap px-3 py-4 text-sm', selectedOrders.includes(row.id) ? 'text-cyan-600' : ' text-gray-900']">
                    {{ row.product_name }}</td>
                  <td
                    :class="['whitespace-nowrap px-3 py-4 text-sm', selectedOrders.includes(row.id) ? 'text-cyan-600' : ' text-gray-500']">
                    {{ row.price }}</td>
                  <td
                    :class="['whitespace-nowrap px-3 py-4 text-sm', selectedOrders.includes(row.id) ? 'text-cyan-600' : ' text-gray-500']">
                    {{ row.website }}</td>
                </tr>
                <tr v-if="rows.length === 0">
                 <td class="border-t px-6 py-4" colspan="4">No order found.</td>
                </tr>
              </template>
            </VTable>

            <VTPagination v-model:currentPage="currentPage" :total-pages="totalPages" :boundary-links="false"
              :maxPageLinks="9" class="flex">
              <template #firstPage class="flex">
                <i class="fas fa-arrow-left" />
              </template>

              <template #lastPage>
                <i class="fas fa-arrow-right" />
              </template>

              <template #next>
                <i class="fas fa-chevron-right" />
              </template>

              <template #previous>
                <i class="fas fa-chevron-left" />
              </template>
            </VTPagination>
          </div>
        </div>
      </div>
    </div>


  </div>
</template>


<style>
    .pagination{
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }
     .pagination li {
        padding: 8px 17px;
     }

     .pagination li{
       border: 1px solid #ddd;
     }

     .pagination .active {
        background-color: #1B2E51;
        color: white;
     }
</style>
