<template>
  <div class="flex flex-col flex-grow bg-primary-800 pt-5 pb-4 overflow-y-auto">
    <div class="flex items-center flex-shrink-0 px-4">
      <img class="h-8 w-auto text-white" :src="$page.props.logo" :alt="'CodInvestor'" />
    </div>
    <nav class="mt-5 flex-1 flex flex-col divide-y divide-primary-600 overflow-y-auto" aria-label="Sidebar">
      <div class="px-2 space-y-1">
        <div v-for="item in navigation" :key="item.name">
          <Link v-if="item.show" :href="item.href"
            :class="[item.current ? 'bg-primary-600 text-white' : 'text-white hover:text-white hover:bg-primary-700', 'group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md']"
            :aria-current="item.current ? 'page' : undefined">
            <component :is="item.icon" class="mr-4 flex-shrink-0 h-6 w-6 text-white" aria-hidden="true" />
            {{ item.name }}
        </Link >
        </div>
      </div>
      <div class="mt-6 pt-6">
        <div class="px-2 space-y-1">
          <div v-for="item in secondaryNavigation" :key="item.name" >
            <Link v-if="item.show" :href="item.href"
              :class="[item.current ? 'bg-primary-600 text-white' : 'text-white hover:text-white hover:bg-primary-700', 'group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md']"
              :aria-current="item.current ? 'page' : undefined">
              <component :is="item.icon" class="mr-4 h-6 w-6 text-white" aria-hidden="true" />
              {{ item.name }}
              <span v-if="item.indicator" class="ml-2 bg-danger text-white rounded-full px-1 text-xs"> {{ item.indicator }}</span>
            </Link>
          </div>

        </div>
      </div>
    </nav>
  </div>
</template>
<script>
import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'

export default {
  components: {
    Link
},
  props: {
    navigation: Array,
    secondaryNavigation: Array,
  },
  setup() {

    return {

    }
  },
}
</script>
