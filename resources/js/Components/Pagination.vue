<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, key) in links" :key="key">
        <div v-if="link.url === null"  class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
        <Link v-else class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-cyan-500 focus:text-cyan-500" :class="{ 'bg-white': link.active }" :href="link.url" v-html="link.label" preserve-state/>
      </template>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
export default {
  components : {
    Link,
  },
  props: {
    links: Array,
  },
}
</script>
