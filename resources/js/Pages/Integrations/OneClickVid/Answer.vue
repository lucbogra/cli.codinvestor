<template>
    <Modal :show="show" @close="$emit('closemodal')">
        <div class=" text-white bg-primary-700">
            <h1 class="ml-2 p-2 font-semibold text-xl text-center">Answer Information</h1>
        </div>
        <!-- {{ answer }} -->
        <div class="flex flex-col justify-center items-center">
            <div
                class="relative flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white bg-clip-border shadow-3xl shadow-shadow-500  p-3">
                <div class="grid grid-cols-1 gap-4 px-2 w-full">
                    <div
                        class=" flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                        <p class="text-sm text-gray-600">Link</p>
                        <a :href="answer.link" target="_blank"
                            class="text-base font-medium text-primary-500 hover:text-blue-400 ">
                            {{ answer.link }}
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 px-2 w-full">

                    <div
                        class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500">
                        <p class="text-sm text-gray-600">Product</p>
                        <p class="text-base font-medium text-navy-700">
                            {{ answer.requests_info.product }}
                        </p>
                    </div>

                    <div
                        class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                        <p class="text-sm text-gray-600">Platform</p>
                        <p class="text-base font-medium text-navy-700">
                            {{ answer.requests_info.platform }}
                        </p>
                    </div>

                    <div
                        class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500">
                        <p class="text-sm text-gray-600">Type Of Creative</p>
                        <p class="text-base font-medium text-navy-700 ">
                            {{ answer.requests_info.type }}
                        </p>
                    </div>


                    <div
                        class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                        <p class="text-sm text-gray-600">Duration</p>
                        <p class="text-base font-medium text-navy-700">
                            {{ answer.requests_info.duration }} Seconds
                        </p>
                    </div>

                    <div
                        class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500">
                        <p class="text-sm text-gray-600">Voice Over</p>
                        <p class="text-base font-medium text-navy-700">
                            {{ answer.requests_info.voice_over }}
                        </p>
                    </div>
                    <div
                        class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500">
                        <p class="text-sm text-gray-600">Music</p>
                        <p class="text-base font-medium text-navy-700 ">
                            {{ answer.requests_info.music }}
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 px-2 w-full">
                    <div
                        class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500">
                        <p class="text-sm text-gray-600">Request Observation</p>
                        <p class="text-base font-medium text-navy-700">
                            {{ answer.requests_info.observation }}
                        </p>
                    </div>
                </div>
                <div v-if="answer.observation" class="grid grid-cols-1 gap-4 px-2 w-full">
                    <div
                        class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500">
                        <p class="text-sm text-gray-600">Video Observation</p>
                        <p class="text-base font-medium text-navy-700">
                            {{ answer.observation }}
                        </p>
                    </div>
                </div>
                <div v-if="answer.rates != null" class="grid grid-cols-1 gap-4 px-2 w-full">
                    <div
                        class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500">
                        <p class="text-sm text-gray-600">Your Rate Of This Creative</p>
                        <p class="text-base font-medium text-navy-700 ">
                            <svg v-for="request in Number(answer.rates)"
                                class="inline-flex text-primary-600 w-8 h-auto fill-current"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path
                                    d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z" />
                            </svg>
                            <svg v-for="request in 5 - Number(answer.rates)"
                                class="inline-flex text-primary-600 w-8 h-auto fill-current"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path
                                    d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z" />
                            </svg>
                        </p>
                    </div>
                </div>
                <div v-if="answer.compaign_data != null" class="grid grid-cols-2 gap-4  px-2 w-full ">

                    <div v-if="JSON.parse(answer.compaign_data).cpl!=''"
                        class="mt-2 flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                        <p class="text-sm text-gray-600">CPL (Cost Per Lead)</p>
                        <p class="text-base font-medium text-navy-700 ">
                            {{ JSON.parse(answer.compaign_data).cpl }}
                        </p>
                    </div>

                    <div v-if="JSON.parse(answer.compaign_data).cpc!=''"
                        class="mt-2 flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 ">
                        <p class="text-sm text-gray-600">CPC (Cost Per Click)</p>
                        <p class="text-base font-medium text-navy-700 ">
                            {{ JSON.parse(answer.compaign_data).cpc }}
                        </p>
                    </div>
                </div>
                <div v-if="answer.rates_Observations" class="grid grid-cols-1 gap-4 px-2 w-full">
                    <div v-if="answer.rates_Observations.rate_observation!=''"
                        class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500">
                        <p class="text-sm text-gray-600">Your Rate Observation</p>
                        <p class="text-base font-medium text-navy-700">
                            {{ answer.rates_Observations.rate_observation }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>
<script>
import Modal from "../../../Jetstream/Modal.vue"
export default {
    components: {
        Modal
    },
    props: {
        show: Boolean,
        answer: Object
    }
}
</script>
<style></style>
