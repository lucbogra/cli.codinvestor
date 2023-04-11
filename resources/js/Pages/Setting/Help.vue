<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import {  InformationCircleIcon, ChevronUpIcon } from '@heroicons/vue/outline';

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
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 hidden sm:block">
        <div class="w-full rounded-2xl bg-white p-2">
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
      </div>
    </template>
  </AppLayout>
</template>
