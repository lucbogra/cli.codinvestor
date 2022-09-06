<script setup>
import { UploadIcon, PhoneIcon, BanIcon, CheckCircleIcon, BadgeCheckIcon, DocumentDuplicateIcon, XCircleIcon, ShareIcon, ChartPieIcon, MinusCircleIcon, CurrencyDollarIcon } from '@heroicons/vue/solid';

const props = defineProps({
  datas: Array,
})
</script>

<template>
  <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <!-- Begin Card Uploaded-->
    <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
      <div class="p-3 mr-4 bg-cyan-100 rounded-full">
        <UploadIcon class="w-10 h-10 text-cyan-500" />
      </div>
      <div>
        <div class="mb-2 font-medium text-gray-600">
          <p class="font-bold text-gray-600">Uploaded</p>
        </div>
        <p class="text-lg font-bold text-cyan-500">
          {{ datas.uploaded }}
        </p>
      </div>
    </div>

    <!-- Begin Card Confirmed-->
    <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
      <div class="p-3 mr-4 bg-green-100 rounded-full">
        <CheckCircleIcon class="w-10 h-10 text-success" />
      </div>
      <div>
        <div class="mb-2 font-medium text-gray-600">
          <p class="font-bold text-gray-600">Confirmed</p>
        </div>
        <p class="text-lg font-bold text-success">
          {{ datas.confirmed }}
        </p>
      </div>
    </div>

    <!-- Begin Card Delivered-->
    <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
      <div class="p-3 mr-4 bg-blue-100 rounded-full">
        <BadgeCheckIcon class="w-10 h-10 text-primary-700" />
      </div>
      <div>
        <div class="mb-2 font-medium text-gray-600">
          <p class="font-bold text-gray-600">Delivered</p>
        </div>
        <p class="text-lg font-bold text-primary-700">
          {{ datas.delivered }}
        </p>
      </div>
    </div>

     <!-- Begin Commission -->
    <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
      <div class="p-3 mr-4 bg-green-100 rounded-full">
        <CurrencyDollarIcon class="w-10 h-10 text-success" />
      </div>
      <div>
        <div class="mb-2 font-medium text-gray-600">
          <p class="font-bold text-gray-600">Commission</p>
        </div>
        <p class="text-lg font-bold text-success">
          {{ '$'+datas.commission }}
        </p>
      </div>
    </div>
  </div>
</template>
