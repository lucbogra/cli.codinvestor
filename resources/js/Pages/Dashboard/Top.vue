<script setup>
import { CheckCircleIcon, UploadIcon, DocumentDuplicateIcon, PhoneMissedCallIcon, ExclamationCircleIcon, XCircleIcon, ShareIcon, ChartPieIcon, TrendingUpIcon, CurrencyDollarIcon, PhoneIcon, BanIcon } from '@heroicons/vue/solid';

const props = defineProps({
  datas : Array,
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
      <!-- Begin Card Wrong Number-->
      <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="p-3 mr-4 bg-red-100 rounded-full">
          <PhoneIcon class="w-10 h-10 text-danger" />
        </div>
        <div>
          <div class="mb-2 font-medium text-gray-600">
            <p class="font-bold text-gray-600">Wrong Number</p>
          </div>
          <p class="text-lg font-bold text-danger">
            {{ datas.wrong_number }}
          </p>
        </div>
      </div>
      <!-- Begin Card Duplicate-->
      <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="p-3 mr-4 bg-blue-100 rounded-full">
          <DocumentDuplicateIcon class="w-10 h-10 text-primary-800" />
        </div>
        <div>
          <div class="mb-2 font-medium text-gray-600">
            <p class="font-bold text-gray-600">Duplicate</p>
          </div>
          <p class="text-lg font-bold text-primary-800">
            {{ datas.duplicate }}
          </p>
        </div>
      </div>
      <!-- Begin Card Rejected-->
      <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="p-3 mr-4 bg-red-100 rounded-full">
          <BanIcon class="w-10 h-10 text-danger" />
        </div>
        <div>
          <div class="mb-2 font-medium text-gray-600">
            <p class="font-bold text-gray-600">Rejected</p>
          </div>
          <p class="text-lg font-bold text-danger">
            {{ datas.rejected }}
          </p>
        </div>
      </div>
      <!-- Begin Card No Answer-->
      <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="p-3 mr-4 bg-orange-100 rounded-full">
          <PhoneMissedCallIcon class="w-10 h-10 text-orange-600" />
        </div>
        <div>
          <div class="mb-2 font-medium text-gray-600">
            <p class="font-bold text-gray-600">No Answer</p>
          </div>
          <p class="text-lg font-bold text-orange-600">
            {{ datas.no_answer }}
          </p>
        </div>
      </div>
       <!-- Begin Card Affected-->
      <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="p-3 mr-4 bg-gray-100 rounded-full">
          <ShareIcon class="w-10 h-10 text-gray-700" />
        </div>
        <div>
          <div class="mb-2 font-medium text-gray-600">
            <p class="font-bold text-gray-600">Processed</p>
          </div>
          <p class="text-lg font-bold text-gray-700">
            {{ datas.affected }}
          </p>
        </div>
      </div>

      <!-- Begin Card Cancelled-->
      <div class="flex items-start p-4 bg-white rounded-lg shadow-xl ">
        <div class="p-3 mr-4 bg-red-100 rounded-full">
          <XCircleIcon class="w-10 h-10 text-danger" />
        </div>
        <div>
          <div class="mb-2 font-medium text-gray-600">
            <p class="font-bold text-gray-600">Cancelled</p>
          </div>
          <p class="text-lg font-bold text-danger">
            {{ datas.cancelled }}
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
      <!-- Begin Card Delayed-->
      <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="p-3 mr-4 bg-blue-100 rounded-full">
          <ExclamationCircleIcon class="w-10 h-10 text-primary-400" />
        </div>
        <div>
          <div class="mb-2 font-medium text-gray-600">
            <p class="font-bold text-gray-600">Delayed</p>
          </div>
          <p class="text-lg font-bold text-primary-400">
            {{ datas.delayed }}
          </p>
        </div>
      </div>
       <!-- Begin Confirmation Rate-->
      <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="p-3 mr-4 bg-green-100 rounded-full">
          <ChartPieIcon class="w-10 h-10 text-success" />
        </div>
        <div>
          <div class="mb-2 font-medium text-gray-600">
            <p class="font-bold text-gray-600">Conf Rate</p>
          </div>
          <p class="text-lg font-bold text-success">
            {{ datas.confirmation_rate }}
          </p>
        </div>
      </div>
  </div>
</template>
