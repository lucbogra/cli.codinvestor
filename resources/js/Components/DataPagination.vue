<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, key) in links" :key="key">
        <div v-if="link.url === null"  class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
        <Link href="#" @click="$emit('getDatas', link.url)" v-else class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary-500 focus:text-primary-500" :class="{ 'bg-white': link.active }" v-html="link.label" preserve-state preserve-scroll/>
      </template>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3'
const props = defineProps({
  links : Array
})
const emit = defineEmits(['getDatas'])

</script>
