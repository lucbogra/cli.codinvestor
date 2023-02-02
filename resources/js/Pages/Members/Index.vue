<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3';
import Layout from '../Setting/Layout.vue';
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import LoadingButton from '@/Components/LoadingButton.vue';
import { ref } from 'vue';

const props = defineProps({
  members : Array
})

const tabFilters = ref({
  all: { value: '', keys: ['name', 'last_seen', 'status'] }
})

const currentPage = ref(1)
const totalPages = ref(0)
</script>

<template>
  <Layout title="Company">
    <div class="mt-8 flex flex-col">
      <div class="sm:flex sm:items-center mb-4">
        <div class="sm:flex-auto">
          <h1 class="text-xl font-semibold text-gray-900">Members</h1>
          <p class="mt-2 text-sm text-gray-700">members have limited access to your account. They can access your Marketplace and import your orders.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
          <Link :href="route('members.create')" type="button" class="btn-primary">Add member</Link>
        </div>
      </div>
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class=" overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg divide-y divide-gray-300">
            <div class="flex justify-between py-2 pr-1 pl-3 items-center bg-gray-50">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Members</h3>
              <input class="form-input w-full lg:w-1/4 rounded-full" placeholder="search..."
                v-model="tabFilters.all.value" />
            </div>
            <VTable :data="members" :filters="tabFilters" class="min-w-full divide-y divide-gray-300"
              :page-size="10" v-model:currentPage="currentPage" @totalPagesChanged="totalPages = $event">
              <template #head>
                <tr class="bg-gray-50">
                  <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                  <th class="px-3 py-3.5  text-left text-sm font-semibold text-gray-900">Last seen</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                  <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" colspan="2">Action</th>
                </tr>
              </template>
              <template #body="{ rows }">
                <tr v-for="row in rows" :key="row.id" class=" bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                  <td class="border-t py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 hover:text-cyan-600">
                     <div class="flex">
                      {{ row.user.name }}
                     </div>
                  </td>

                  <td class="border-t px-3 py-4 text-sm">
                    <Link :href="route('members.edit', row.id)" class="text-gray-500 hover:text-cyan-600" >
                     {{row.user.last_seen}} </Link>
                 </td>

                 <td :class="['border-t px-3 py-4 text-sm', row.status == 'offline' ? 'text-red-500' : 'text-green-500']" >
                     {{row.user.status}}
                 </td>

                 <td class="border-t">
                    <Link :href="route('members.edit', row.id)" class="text-primary-700 px-3 py-4 text-sm hover:text-cyan-600" >Edit </Link>
                 </td>

                 <!-- <td class="border-t text-right">
                    <Link :href="route('otheruser.login', row.id)" class="text-primary-700 px-3 py-4 text-sm hover:text-cyan-600 ml-4" >Connect as {{row.name}} </Link>
                 </td> -->
                </tr>
                <tr v-if="rows.length === 0">
                  <td class="border-t px-6 py-4" colspan="4">No Member found.</td>
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
    </div>
  </Layout>
</template>
