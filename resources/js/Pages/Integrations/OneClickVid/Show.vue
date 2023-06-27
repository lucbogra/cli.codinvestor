<template>
    <AppLayout>
        <template #page-header>
            <nav aria-label="Breadcrumb" class="mt-8">
                <ol role="list" class="max-w-2xl mx-3 flex items-center space-x-2 sm:px-6 lg:max-w-7xl lg:px-8">
                    <li>
                        <div class="flex items-center">
                            <Link :href="route('integrations.index')" class="mr-2 text-sm font-medium text-gray-900">
                            Integrations
                            </Link>
                            <ChevronRightIcon class="w-5 h-5 text-gray-400" />
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <Link :href="route('oneclickvid.index')" class="mr-2 text-sm font-medium text-gray-900">
                            One Click Vid
                            </Link>
                            <ChevronRightIcon class="w-5 h-5 text-gray-400" />
                        </div>
                    </li>
                    <li class="text-sm">
                        <div class="font-medium text-gray-500 hover:text-gray-600">
                            Show
                        </div>
                    </li>
                </ol>
            </nav>
        </template>
        <template #content>
            
            <div class="flex flex-col justify-center items-center">
                
                <div
                    class="relative flex flex-col items-center rounded-[20px] w-8/12 max-w-[95%] mx-auto bg-gray-50 bg-clip-border shadow-3xl shadow-shadow-500    p-3">
                    <h1
                class="text-2xl mt-6 mb-6 font-medium text-primary-800 hover:text-primary-600 space-x-2 sm:px-6 lg:max-w-3xl lg:px-8">
                Request Details </h1>
                    <div class="grid grid-cols-1 gap-4 px-2 w-full mb-4">
                        <div
                            class=" flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                            <p class="text-sm text-gray-600">Product</p>
                            <div class="text-base font-medium text-primary-700  ">
                                {{ request.product }}
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4 px-2 w-full">

                        <div
                            class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                            <p class="text-sm text-gray-600">Platform</p>
                            <p class="text-base font-medium text-navy-700 ">
                                {{ request.platform }}
                            </p>
                        </div>

                        <div
                            class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                            <p class="text-sm text-gray-600">Type Of Creative</p>
                            <p class="text-base font-medium text-navy-700 ">
                                {{ request.type }}
                            </p>
                        </div>

                        <div
                            class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                            <p class="text-sm text-gray-600">Duration</p>
                            <p class="text-base font-medium text-navy-700 ">
                                {{ request.duration }} Seconds
                            </p>
                        </div>


                        <div
                            class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                            <p class="text-sm text-gray-600">Voice Over</p>
                            <p class="text-base font-medium text-navy-700 ">
                                {{ request.voice_over === 1 ? 'Yes' : 'No' }}
                            </p>
                        </div>
                        <div
                            class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                            <p class="text-sm text-gray-600">Music</p>
                            <p class="text-base font-medium text-navy-700 ">
                                {{ request.music === 1 ? 'Yes' : 'No' }}
                            </p>
                        </div>
                        <div v-if="request.video_size!=null"
                            class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                            <p class="text-sm text-gray-600">Music</p>
                            <p class="text-base font-medium text-navy-700 ">
                                {{ request.video_size }}
                            </p>
                        </div>
                    </div>
                    <div v-if="request.observation" class="grid grid-cols-1 gap-4 px-2 w-full mb-4">
                        <div
                            class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                            <p class="text-sm text-gray-600">Request Observation</p>
                            <p class="text-base font-medium text-navy-700 ">
                                {{ request.observation }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="request.answer != null" class="mt-8">
                
                <div class="flex flex-col justify-center items-center">
                    <div
                        class="relative flex flex-col items-center rounded-[20px] w-8/12 max-w-[95%] mx-auto bg-gray-50 bg-clip-border shadow-3xl shadow-shadow-500    p-3">
                        <h1
                        class="text-2xl mt-6 mb-6 font-medium text-primary-800 hover:text-primary-600 space-x-2 sm:px-6 lg:max-w-3xl lg:px-8">
                    Creative Details </h1>
                        <div class="grid grid-cols-1 gap-4 px-2 w-full mb-4">
                            <div
                                class=" flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">Link</p>
                                <a :href="request.answer.link" target="_blank"
                                    class="text-lg font-semibold text-primary-500 hover:text-blue-400 ">
                                    Creative Link
                                </a>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 px-2 w-full mb-4">

                            <div
                                class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">Product</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    {{ request.answer.requests_info.product }}
                                </p>
                            </div>

                            <div
                                class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">Platform</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    {{ request.answer.requests_info.platform }}
                                </p>
                            </div>

                            <div
                                class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">Type Of Creative</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    {{ request.answer.requests_info.type }}
                                </p>
                            </div>


                            <div
                                class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">Duration</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    {{ request.answer.requests_info.duration }} Seconds
                                </p>
                            </div>

                            <div
                                class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">Voice Over</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    {{ request.answer.requests_info.voice_over === true ? 'Yes' : 'No' }}
                                </p>
                            </div>
                            <div
                                class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">Music</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    {{ request.answer.requests_info.music === true ? 'Yes' : 'No' }}
                                </p>
                            </div>
                        </div>
                        <div v-if="request.answer.observation" class="grid grid-cols-1 gap-4 px-2 w-full">
                            <div
                                class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">Answer Observation</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    {{ request.answer.observation }}
                                </p>
                            </div>
                        </div>
                        <div v-if="request.answer.rates!=null" class="grid grid-cols-1 gap-4 px-2 w-full mb-4">
                            <div
                                class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">Your Rate Of This Creative</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    <StarIcon v-for="request in Number(request.answer.rates)" class="inline-flex text-primary-600 w-10 h-auto fill-current" />
                                    <EmptyStar v-for="request in 5 - Number(request.answer.rates)" class="inline-flex text-primary-600 w-8 h-auto" />
                                </p>
                            </div>
                        </div>
                        
                        <div v-if="request.answer.compaign_data != null" class="grid grid-cols-2 gap-4 mb-4 px-2 w-full ">

                            <div v-if="JSON.parse(request.answer.compaign_data).cpl!=''"
                                class="mt-2 flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">CPL (Cost Per Lead)</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    ${{ JSON.parse(request.answer.compaign_data).cpl }}
                                </p>
                            </div>

                            <div v-if="JSON.parse(request.answer.compaign_data).cpc!=''"
                                class="mt-2 flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">CPC (Cost Per Click)</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    ${{ JSON.parse(request.answer.compaign_data).cpc }}
                                </p>
                            </div>
                        </div>
                        <div v-if="request.answer.rates_Observations " class="grid grid-cols-1 gap-4 mb-4 px-2 w-full">
                            <div v-if="request.answer.rates_Observations.rate_observation!=''"
                                class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                                <p class="text-sm text-gray-600">Your Rate Observation</p>
                                <p class="text-base font-medium text-navy-700 ">
                                    {{ request.answer.rates_Observations.rate_observation }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { ChevronRightIcon,StarIcon } from '@heroicons/vue/solid'
import { StarIcon as EmptyStar } from '@heroicons/vue/outline'

export default {
    components: {
        AppLayout,
        Link,
        ChevronRightIcon,
        EmptyStar,
        StarIcon
    },
    props: {
        id: Number,
        request: Object
    },

}
</script>
<style></style>