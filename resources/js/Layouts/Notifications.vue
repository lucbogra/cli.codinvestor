<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-10" @close="$emit('close')">
      <div class="fixed inset-0" />

      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
            <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
              <DialogPanel class="pointer-events-auto w-screen max-w-md">
                <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl">
                  <div class="px-4 sm:px-6">
                    <div class="flex items-start justify-between">
                      <DialogTitle class="text-base font-semibold leading-6 text-gray-900">Notifications</DialogTitle>
                      <div class="ml-3 flex h-7 items-center">
                        <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2" @click="$emit('close')">
                          <span class="sr-only">Notifications</span>
                          <XIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="relative mt-6 flex-1 px-4 sm:px-6">

                    <div id="dropdownNotification" class="z-20 w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow" aria-labelledby="dropdownNotificationButton">

                      <div class="divide-y divide-gray-100 ">
                        <Link :href="route('user.notifications')" class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100">
                          <div class="inline-flex items-center ">
                            <svg class="w-4 h-4 mr-2 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                              View all
                          </div>
                        </Link>
                        <Link class="flex px-4 py-3 hover:bg-gray-100" v-for="notify in $page.props.notifications" :key="notify.id" :href="notify.link">

                          <div class="" v-if="notify.icon">
                            <div class="w-11 h-11 bg-gray-100 rounded-full flex items-center justify-center">
                              <i :class="notify.icon"></i>
                            </div>
                          </div>

                          <div class="w-full pl-3">
                            <div class="text-gray-500 text-sm mb-1.5 ">{{ notify.text }}</div>
                            <div class="text-xs text-primary-600">{{ notify.created_at }}</div>
                          </div>
                        </Link>

                        <a href="#" class="flex px-4 py-3 hover:bg-gray-100" v-if="$page.props.notifications.length == 0">
                          <div class="w-full pl-3">
                            <div class="text-gray-500 text-sm mb-1.5 ">You have no notifications at this time</div>
                          </div>
                        </a>
                      </div>
                    </div>

                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XIcon } from '@heroicons/vue/outline';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  open : Boolean
})
defineEmits(['close'])
</script>
