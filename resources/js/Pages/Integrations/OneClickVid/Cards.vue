<template>
<div class="grid gap-6 mb-8 md:grid-cols-4 xl:grid-cols-4 mt-7 mx-7">
                <!-- Begin Card Uploaded-->
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-cyan-100 rounded-full">
                        <UploadIcon class="w-5 h-5 text-cyan-500" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Requests</p>
                        </div>
                        <p class="text-lg font-bold text-gray-600">
                             {{ request_number }} Requests <span class="text-md font-semibold text-green-500">({{ answers_count }} Answered)</span>
                        </p>
                    </div>
                </div>
                <!-- Begin Card Wrong Number-->
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-green-100 rounded-full">
                        <CalendarIcon class="w-5 h-5 text-success" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Daily Limit</p>
                        </div>
                        <p class="text-lg font-bold text-gray-600">
                            {{ dailylimit }} Request(s)
                        </p>
                    </div>
                </div>
                <!-- Begin Card Duplicate-->
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-blue-100 rounded-full">
                        <CameraIcon class="w-5 h-5 text-blue-400" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Number Of Creatives Left</p>
                        </div>
                        <p class="text-lg font-bold text-gray-600">
                            {{ number_video }} Creative(s)
                        </p>

                    </div>
                </div>
                <!-- Begin Card Duplicate-->
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-red-100 rounded-full">
                        <CurrencyDollarIcon class="w-6 h-6 text-red-400" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Remaining Amount To Pay</p>
                        </div>
                        <p class="text-lg font-bold text-gray-600">
                            ${{ investorRemain }}
                        </p>

                    </div>
                </div>
            </div>
</template>
<script setup>
import { UploadIcon} from '@heroicons/vue/solid'
import { CameraIcon, CurrencyDollarIcon,CalendarIcon } from '@heroicons/vue/outline'

 defineProps({
    request_number:Number,
    answers_count:Number,
    number_video:Number,
    investorRemain:Number,
    dailylimit:Number
 })
</script>