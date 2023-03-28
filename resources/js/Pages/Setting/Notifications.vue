<script setup>
import { onMounted } from '@vue/runtime-core';
import Layout from './Layout.vue';
import FileInput from '../../Components/FileInput.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { EyeIcon } from '@heroicons/vue/solid';

const close = (notify) => {
  Inertia.visit(route('user.notifications.close', notify.id), {
    method : 'PUT'
  })
}
</script>

<template>
  <Layout title="Notifications">
    <div class="max-w-6xl bg-white mx-auto sm:px-6 lg:px-8 p-8">
      <h3 class="text-xl font-bold mb-4">Notifications</h3>
      <Link  v-if="$page.props.notifications.length != 0" :href="route('user.all_notifications.close')" method="PUT" class="block py-2 text-sm font-medium text-center text-gray-500 rounded-lg bg-gray-50 hover:bg-danger hover:text-white mb-2">
        <div class="inline-flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
          Close All
        </div>
      </Link>
      <div class="overflow-hidden bg-white shadow sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">
          <li v-for="notify in $page.props.notifications" :key="notify.id">
            <a href="#" class="block hover:bg-gray-50">
              <div class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                  <p class="truncate text-sm font-medium text-primary-600">{{ notify.type }}</p>
                  <div class="ml-2 flex flex-shrink-0">
                    <p class="inline-flex rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-primary-700">{{ notify.created_at }}</p>
                  </div>
                </div>
                <div class="mt-2 sm:flex sm:justify-between">
                  <div class="sm:flex">
                    <p class="flex items-center text-sm text-gray-500">
                      <i :class="[notify.icon, 'mr-2']"></i>
                      {{ notify.text }}
                    </p>

                  </div>
                  <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                    <div>
                    <Link :href="notify.link" class="mr-2 bg-blue-50 text-primary-700 rounded-lg focus:ring-2 focus:ring-primary-500 p-1.5 hover:bg-blue-200 inline-flex h-8 w-8" aria-label="Close">
                      <span class="sr-only">Close</span>
                        <EyeIcon class="w-5 h-5" />
                    </Link>

                    <button @click="close(notify)" type="button" class="bg-red-50 text-danger rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" aria-label="Close">
                      <span class="sr-only">Close</span>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                  </div>
                  </div>
                </div>
              </div>
            </a>
          </li>
        </ul>
        <a href="#" class="flex px-4 py-3 hover:bg-gray-100" v-if="$page.props.notifications.length == 0">
          <div class="w-full pl-3">
            <div class="text-gray-900 text-sm mb-1.5 ">You have no notifications at this time</div>
          </div>
        </a>
      </div>

    </div>
  </Layout>
</template>
