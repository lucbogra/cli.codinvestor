<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ClockIcon, UploadIcon } from '@heroicons/vue/outline'
import { usePage } from '@inertiajs/inertia-vue3'
import { Link } from '@inertiajs/inertia-vue3'
import { ChevronLeftIcon } from '@heroicons/vue/solid'
import { auth } from '../Permissions';


const props = defineProps({
  selected_menu: String,
})
const currentUrl = usePage().url.value.substr(1)
const isUrl = (...urls) => {
  let currentUrl = usePage().url.value.substr(1)
  if (urls[0] === '') {
    return currentUrl === ''
  }
  return urls.filter((url) => currentUrl.startsWith(url)).length
}

const navigation = [
  { name: 'Upload', href: route('orders.index'), icon: UploadIcon, current: isUrl('orders/index'), show : true },
  { name: 'History', href: route('orders.history'), icon: ClockIcon, current: isUrl('orders/history'), show : true },
]

</script>

<template>
  <AppLayout title="Orders">
    <template #page-header>
      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
          <div class="">
            <nav class="sm:hidden" aria-label="Back">
              <a href="#" class="flex items-center text-sm font-medium text-gray-400 hover:text-gray-200">
                <ChevronLeftIcon class="flex-shrink-0 -ml-1 mr-1 h-5 w-5 text-gray-500" aria-hidden="true" />
                Back
              </a>
            </nav>
            <nav class="hidden sm:flex" aria-label="Breadcrumb">
              <ol role="list" class="flex items-center space-x-4">
                <li>
                  <div class="flex items-center">
                    <a href="#" class="ml-4 text-sm font-medium text-gray-400 hover:text-gray-200">{{ selected_menu
                    }}</a>
                  </div>
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </template>
    <template #content>
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-2">
          <nav class="space-y-1">
            <div v-for="item in navigation" :key="item.name">
              <Link v-if="item.show" :href="item.href"
                :class="[item.current ? 'bg-gray-50 text-cyan-700 hover:text-cyan-700 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50', 'group rounded-md px-3 py-2 flex items-center text-sm font-medium']"
                :aria-current="item.current ? 'page' : undefined">
                <component :is="item.icon"
                  :class="[item.current ? 'text-cyan-500 group-hover:text-cyan-500' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']"
                  aria-hidden="true" />
                <span class="truncate">
                  {{ item.name }}
                </span>
              </Link>
            </div>

          </nav>
        </aside>

        <div class="lg:px-0 lg:col-span-10">
          <slot />
        </div>
      </div>
    </template>
  </AppLayout>
</template>
