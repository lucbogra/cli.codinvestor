<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import { QuestionMarkCircleIcon, ChevronRightIcon, MailIcon, ClipboardCheckIcon, MailOpenIcon } from '@heroicons/vue/solid'
import { Link } from '@inertiajs/inertia-vue3'
import pickBy from 'lodash/pickBy'

import { InboxIcon, InboxInIcon } from '@heroicons/vue/outline';

const props = defineProps({
  messages: Array,
})

</script>
<template>
  <AppLayout>
    <template #page-header>
      <div class="mt-2 p-5 mx-10">
        <div class="">
          <h1 class="gu teu text-primary-800 font-bold">Messages</h1>
        </div>
      </div>
    </template>
    <template #content>
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="bg-white shadow sm:rounded-md">
        <ul role="list" class="divide-y-2 divide-gray-200">
          <li v-for="message in messages" :key="message.id">
            <div class="flex justify-end" v-if="message.read_at == null">
              <span class="-mt-2 -mr-2 text-xs font-medium bg-cyan-100 px-1 text-primary-500 rounded-lg group-hover:text-gray-800">New</span>
            </div>
            <Link :href="route('messages.show', message.slug)" class="block hover:bg-gray-50">
            <div class="flex items-center px-4 py-4 sm:px-6">
              <div class="min-w-0 flex-1 flex items-center">
                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                  <div class="flex">
                    <InboxInIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-primary-800"/>
                    <p class="text-sm font-medium text-primary-800 truncate">{{ message.title }}</p>
                  </div>
                  <div class="hidden md:block">
                    <div>
                      <p class="text-sm text-gray-900">
                        Received at
                        {{ ' ' }}
                        <time :datetime="message.created_at">{{ message.created_at_full }}</time>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div>
                <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
              </div>
            </div>
            </Link>
          </li>
        </ul>
      </div>
    </div>
    </template>

  </AppLayout>

</template>
