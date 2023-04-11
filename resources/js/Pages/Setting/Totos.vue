<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import {  InformationCircleIcon, ChevronUpIcon } from '@heroicons/vue/outline';
import axios from 'axios';
import { onMounted, ref } from 'vue';
const tutos = ref(null)
onMounted( async () => {
  const res = await axios.get(route('tutos'))
  tutos.value = res.data
})
</script>
<template>
  <div class="w-full rounded-2xl bg-white p-2" v-if="tutos != null">
    <Disclosure v-slot="{ open }" v-for="tuto in tutos" :key="tuto.id">
      <DisclosureButton
        class="flex w-full justify-between mb-4 rounded-lg border border-primary-500 bg-primary-200  px-4 py-2 text-left text-lg font-medium text-white hover:bg-gray-200 focus:outline-none focus-visible:ring focus-visible:ring-primary-500 focus-visible:ring-opacity-75">
        <div class="flex items-center text-primary-800">
          <InformationCircleIcon class="w-5 h-5 mr-1.5" />
          <span>{{tuto.title}}</span>
        </div>
        <ChevronUpIcon :class="open ? 'rotate-180 transform' : ''" class="h-5 w-5 text-primary-800" />
      </DisclosureButton>
      <DisclosurePanel class="px-4 pt-4 pb-2 text-sm text-gray-900">
        <div>
          <p v-html="tuto.description" class="mb-4"></p>
          <div class="flex justify-center">
            <iframe class="w-full aspect-video" :src="tuto.url" frameborder="0"></iframe>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>
  </div>
</template>
