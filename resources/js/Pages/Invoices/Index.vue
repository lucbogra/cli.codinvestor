<script setup>
  import AppLayout from '@/Layouts/AppLayout.vue'
  import { ref, } from 'vue';
  import { Link, useForm } from '@inertiajs/inertia-vue3'
  import { InformationCircleIcon, PencilAltIcon, DocumentDuplicateIcon, DownloadIcon } from '@heroicons/vue/solid';
import Pagination from '@/Components/Pagination.vue';

  const props = defineProps({
    invoices: Object,
  });

  const filters = ref({
  all: { value: '', keys: ['date', 'slug', 'amount', 'status'] }
})
const url =  (invoice) => { return route('invoice.download', invoice.slug) }

  </script>
  <template>
    <AppLayout title="Invoices">
      <template #page-header>
        <div class="mt-2 p-5 mx-10">
          <div class=" flex justify-between mb-5">
            <h1 class="gu teu text-primary-800 font-bold">Invoices</h1>
            <input name="" class="a ou rounded-full w-52 hidden sm:block" placeholder="search..." v-model="filters.all.value"/>
          </div>
        </div>
      </template>
      <template #content>
        <div class="vs jj ttm vl ou uf na -mt-12">
          <div class="bg-white overflow-x-auto rounded-lg border-slate-200">
            <div class="overflow-hidden">
              <VTable :data="invoices.data" :filters="filters" class="min-w-full bg-gray-50">
                <template #head>
                  <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Date</th>
                    <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">#</th>
                    <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Amount</th>
                    <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Status</th>
                    <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Actions</th>
                  </tr>
                </template>
                <template #body="{ rows }">
                  <tr v-for="(invoice, index) in rows" :key="invoice.id" class="border-t border-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6 font-medium text-gray-900"> {{ invoice.created_at }} </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500">{{ invoice.slug }} </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ invoice.amount+' USD' }}</td>
                    <td :class="['whitespace-nowrap px-3 py-4 text-sm font-medium']">
                      <span :class="['px-2 py-1 rounded-xl text-white', invoice.status == 'paid' ? ' bg-green-300' : ' bg-primary-400']">{{invoice.status}}</span>
                    </td>

                    <td class="whitespace-nowrap flex justify-between px-3 py-4 text-sm font-medium text-primary-500 hover:text-primary-400">
                      <Link :href="route('invoice.show', invoice.slug)">Show Details</Link>
                      <div v-if="invoice.invoiceable.can_download" class="">
                        <a :href="url(invoice)"><DownloadIcon class="w-5 h-5" /> </a>
                      </div>
                    </td>

                  </tr>
                  <tr v-if="rows.length === 0">
                   <td class="border-t px-3 py-4" colspan="6">No Invoice found.</td>
                  </tr>
                </template>
              </VTable>

            </div>
          </div>
          <pagination class="mt-6" :links="invoices.links" />
        </div>
      </template>
    </AppLayout>
  </template>
