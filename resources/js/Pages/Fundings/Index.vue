<script setup>
  import { ref } from 'vue'
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { PaperClipIcon } from '@heroicons/vue/solid';

  const props = defineProps({
    fundings: Array,
  })

  const filters = ref({
    all: { value: '', keys: ['date', 'slug', 'status','amount'] }
  })

  const currentPage = ref(1)
  const totalPages = ref(0)

</script>

<template>
  <AppLayout title="Fundings">
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
        <div class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg divide-y divide-gray-300">
          <VTable :data="fundings" :filters="filters" class="min-w-full table-fixed bg-gray-50 " :page-size="10"
            v-model:currentPage="currentPage" @totalPagesChanged="totalPages = $event">
            <template #head>
              <VTh sortKey="date" class="px-6 pr-3 text-left text-sm font-semibold text-gray-900">Date</VTh>
              <VTh sortKey="slug" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">#</VTh>
              <VTh sortKey="amount" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Amount</VTh>
              <VTh sortKey="remain" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Left to pay</VTh>
              <VTh sortKey="file" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">File</VTh>
              <VTh sortKey="status" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</VTh>
            </template>
            <template #body="{ rows }">
              <tr v-for="(row, index) in rows" :key="index"
                class="border-t border-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100"
                :class="index % 2 === 0 ? undefined : 'bg-gray-50'">
                <td class="whitespace-nowrap py-4 pl-6 pr-4 text-sm sm:pl-6">
                  {{ row.date }}
                </td>

                <td class="['whitespace-nowrap px-3 py-4 text-sm  text-gray-500']">
                  {{ row.slug }}</td>
                <td class="['whitespace-nowrap px-3 py-4 text-sm  text-gray-500']">
                  {{ row.amount }}</td>
                <td class="['whitespace-nowrap px-3 py-4 text-sm  text-gray-500']">
                  {{ row.remain }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm  text-gray-500">
                  <div class="flex w-0 flex-1 items-center">
                    <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                    <span class="ml-2 w-0 flex-1 truncate">file</span>
                    <a :href="row.file" target="_blank"
                      class="font-medium text-primary-600 hover:text-primary-500">Download</a>
                  </div>
                </td>
                <td
                  :class="['whitespace-nowrap px-3 py-4 text-sm', row.status == 'Paid' ? 'text-success' : 'text-gray-500']">
                  {{ row.status }}</td>
              </tr>
              <tr v-if="rows.length === 0">
                <td class="border-t px-6 py-4" colspan="4">No funding found.</td>
              </tr>
            </template>
          </VTable>

          <VTPagination v-model:currentPage="currentPage" :total-pages="totalPages" :boundary-links="false"
            :maxPageLinks="9">
            <template #firstPage>
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
    </template>
  </AppLayout>
</template>
