<template>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="$emit('sidebarClose')">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>
        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
          <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-primary-800">
            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
              <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="$emit('sidebarClose')">
                  <span class="sr-only">Close sidebar</span>
                  <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                </button>
              </div>
            </TransitionChild>
            <div class="flex-shrink-0 flex items-center px-4">
              <img class="h-8 w-auto" :src="$page.props.logo" :alt="'CodInvestor'" alt="Easywire logo" />
            </div>
            <nav class="mt-5 flex-shrink-0 h-full divide-y divide-primary-600 overflow-y-auto" aria-label="Sidebar">
              <div class="px-2 space-y-1">
                <div v-for="item in navigation" :key="item.name">
                  <Link v-if="item.show" :href="item.href" :class="[item.current ? 'bg-primary-700 text-white' : 'text-white hover:text-white hover:bg-primary-700', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']" :aria-current="item.current ? 'page' : undefined">
                    <component :is="item.icon" class="mr-4 flex-shrink-0 h-6 w-6 text-white" aria-hidden="true" />
                    {{ item.name }}
                  </Link>
                </div>

              </div>
              <div class="mt-6 pt-6">
                <div class="px-2 space-y-1">
                  <div v-for="item in secondaryNavigation" :key="item.name">
                    <Link v-if="item.show" :href="item.href" class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-white hover:text-white hover:bg-primary-700">
                      <component :is="item.icon" class="mr-4 h-6 w-6 text-white" aria-hidden="true" />
                      {{ item.name }}
                    </Link>
                  </div>
                </div>
              </div>
            </nav>
          </div>
        </TransitionChild>
        <div class="flex-shrink-0 w-14" aria-hidden="true">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </Dialog>
    </TransitionRoot>
</template>
<script>
import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import {
  Dialog,
  DialogOverlay,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  XIcon,
} from '@heroicons/vue/outline'

export default {
  components: {
    Dialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
    XIcon,
    Link,
  },
   props : {
    navigation : Array,
    secondaryNavigation : Array,
    sidebarOpen : Boolean,
  },
  emits: ['sidebarClose'],
  setup() {

    return {

    }
  },
}
</script>
