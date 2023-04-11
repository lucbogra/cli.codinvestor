<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Tutos from './Totos.vue'
const props = defineProps({
  tutos : Array
})
</script>

<template>
  <AppLayout>
    <template #page-header>
      <div class="mt-2 p-5 mx-10">
        <div class="">
          <h1 class="gu teu text-primary-800 font-bold">Help</h1>
        </div>
      </div>
    </template>
    <template #content>
      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 hidden sm:block">
        <Tutos />
      </div>
    </template>
  </AppLayout>
</template>
