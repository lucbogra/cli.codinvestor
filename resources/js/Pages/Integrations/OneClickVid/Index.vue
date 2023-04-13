<template >
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
                    <li class="text-sm">
                        <div class="font-medium text-gray-500 hover:text-gray-600">
                            One Click Vid
                        </div>
                    </li>
                </ol>
            </nav>
        </template>
        <template #content>

            <h1
                class="text-2xl font-medium text-primary-800 flex hover:text-primary-600flex items-center space-x-2 sm:px-6 lg:max-w-7xl lg:px-8">
                One CLick Vid</h1>
            <div class="grid gap-6 mb-8 md:grid-cols-3 xl:grid-cols-3 mt-7 mx-7">
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
                            {{ requests.length }}
                        </p>
                    </div>
                </div>
                <!-- Begin Card Wrong Number-->
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-green-100 rounded-full">
                        <PaperAirplaneIcon class="w-5 h-5 text-success" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Answers</p>
                        </div>
                        <p class="text-lg font-bold text-gray-600">
                            {{ answers_count }}
                        </p>
                    </div>
                </div>
                <!-- Begin Card Duplicate-->
                <div class="flex items-start p-4 bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="p-3 mr-4 bg-red-100 rounded-full">
                        <BellIcon class="w-5 h-5 text-danger" />
                    </div>
                    <div>
                        <div class="mb-2 font-medium text-gray-600">
                            <p class="font-bold text-gray-600">Not Readed Responses</p>
                        </div>
                        <p class="text-lg font-bold text-gray-600">
                           {{ this.$page.props.not_readed_responses }}
                        </p>
                    </div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-1 min-w-max my-6 mx-5">
                    <h1 class="text-primary-800 font-bold">Request Creatives</h1>
                    <div class="inline-flex">
                        <button type="button" @click="getrequets()" class="btn-primary mr-2">
                            <RefreshIcon v-bind:class="{'animate-spin':load===true,'animate-none':load===false}" class="w-4"></RefreshIcon>
                        </button>
                        <button @click="addRequestToggle" type="button" class="btn-primary cursor-pointer" >Request Creative</button>
                    </div>
                </div>
                <div class="bg-gray-100 flex items-center justify-center font-sans overflow-hidden">
                    <div class="w-full ">
                        <div class="bg-white shadow-md rounded my-6 mx-5">
                            <table class="min-w-max w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">Requests</th>
                                        <th class="py-3 px-6 text-left">Platform</th>
                                        <th class="py-3 px-6 text-left">Type</th>
                                        <th class="py-3 px-6 text-center ">Status</th>
                                        <th class="py-3 px-6 text-center">Rate</th>
                                        <th class="py-3 px-6 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    <tr v-if="requests" v-for="request in requests"
                                        class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-9 h-9 rounded-full flex-shrink-0 bg-primary-500 my-2 mr-3">
                                                    <svg class="w-9 h-9 fill-current text-indigo-50" viewBox="0 0 36 36">
                                                        <path
                                                            d="M18 10c-4.4 0-8 3.1-8 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L18.9 22H18c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z">
                                                        </path>
                                                    </svg>

                                                </div>
                                                <span class="font-medium text-lg">{{ request.product }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <div class="flex items-center font-bold">
                                                <span>{{ request.platform }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <div class="flex items-center  font-bold">
                                                <span>{{ request.type }}</span>
                                            </div>
                                        </td>
                                        <td v-if="request.answer" class="py-4 px-6 text-center">
                                            <button type="button" @click="answerToggle(request.answer)"
                                                class="bg-green-400 hover:bg-green-300 py-2 px-3 rounded-full text-sm font-bold text-white">Answered</button>

                                        </td>
                                        <td v-else class="py-4 px-6 text-center">
                                            <button
                                                class="cursor-text bg-orange-400 hover:bg-orange-300 py-2 px-3 rounded-full text-sm font-bold text-white">
                                                Pending</button>

                                        </td>
                                        <td v-if="request.answer && request.answer.rates === null"
                                            class="py-3 px-6 text-center font-bold">
                                            <button @click="rateToggle(request.answer)"
                                                class="bg-primary-400 p-2 w-7/12 rounded text-white hover:bg-primary-500">Rate</button>
                                        </td>
                                        <td v-else-if="request.answer && request.answer.rates !== null"
                                            class="py-3 px-6 text-center font-bold">
                                            <StarIcon v-for="request in Number(request.answer.rates)"
                                                class="inline-flex text-primary-600 w-7 h-auto fill-current" />
                                            <!-- <EmptyStar class="inline-flex text-primary-600 w-5 h-auto fill-current" v-for="request in 5 - Number(request.answer.rates)"/> -->
                                            <svg v-for="request in 5 - Number(request.answer.rates)"
                                                class="inline-flex text-primary-600 w-5 h-auto fill-current"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path
                                                    d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z" />
                                            </svg>
                                        </td>
                                        <td v-else class="py-3 px-6 text-center font-bold">
                                            Pending
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center">
                                                <div @click="toggleduplicatemodal(request, 'Duplicate')"
                                                    class="w-5 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer">
                                                    <DuplicateIcon class="text-primary-500" />
                                                </div>
                                                <Link class="w-5 mr-2 transform hover:text-purple-500 hover:scale-110"
                                                    :href="route('oneclickvid.show', request.id)">
                                                <EyeIcon class="text-primary-500 cursor-pointer" />

                                                </Link>
                                                <button v-if="request.read===false"
                                                    @click="toggleduplicatemodal(request, 'update')"
                                                    class="w-5 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer">
                                                    <PencilIcon class="text-primary-500" />

                                                </button>
                                                <button @click="destroy(request.id)" v-if="request.read===false"
                                                    class="w-5 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer">
                                                    <TrashIcon class="text-primary-500" />
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <Answer_Modal :answer="current_answer" :show="show_answer" @closemodal="answerToggle"></Answer_Modal>
            <Add_request :show="show_add" @close_modal="addRequestToggle"></Add_request>
            <Rate v-if="current_answer" :id="current_answer.id" :show="show_rate"
                @closemodal="rateToggle(current_answer)" />
            <Duplicate_request v-if="selected_request != null" :action="action_request" :key="selected_request"
                :request="selected_request" :products="products" :show="show_duplicate"
                @close_modal="toggleduplicatemodal(selected_request, 'Duplicate')"></Duplicate_request>
        </template>

    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { ChevronRightIcon, PaperAirplaneIcon, BellIcon, UploadIcon, RefreshIcon, StarIcon } from '@heroicons/vue/solid'
import { EyeIcon, PencilIcon, TrashIcon, DuplicateIcon } from '@heroicons/vue/outline'
import Add_request from '../../Requests/Add.vue'
import Answer_Modal from './Answer.vue'
import Rate from './Rate.vue'
import Duplicate_request from '../../Requests/Duplicate.vue'
export default {
    components: {
        AppLayout,
        ChevronRightIcon,
        PaperAirplaneIcon,
        Link,
        UploadIcon, BellIcon,
        Add_request, EyeIcon, PencilIcon, TrashIcon, Answer_Modal, DuplicateIcon,
        Rate, Duplicate_request, RefreshIcon, StarIcon
    },
    props: {
        products:Object
    },
    data() {
        return {
            show_add: false,
            show_answer: false,
            show_rate: false,
            requests: [],
            current_answer: [],
            selected_request: null,
            answers_count: 0,
            show_duplicate: false,
            action_request: 'Duplicate',
            form: this.$inertia.form({}),
            load:false

        }
    },
    methods: {
        answerToggle(answer) {
            if (answer !== null) {
                this.current_answer = answer
                this.show_answer = !this.show_answer
            }

        },
        rateToggle(answer) {
            this.getrequets()
            this.current_answer = answer
            this.show_rate = !this.show_rate
        },
        addRequestToggle() {
            this.getrequets()
            this.show_add = !this.show_add
        },
        toggleduplicatemodal(request, action) {
            this.getrequets()
            this.selected_request = request
            this.action_request = action
            this.show_duplicate = !this.show_duplicate
        },
        getrequets() {
            this.load = true;
            axios.get(route('userequests'))
                .then((response) => {
                    this.answers_count = 0
                    this.requests = response.data
                    this.requests.map(item => {
                        if (item.answer != null) {
                            this.answers_count += 1
                        }
                    })

                    this.load=false
                })
                .catch(resonse => {
                    console.log('error');
                })
        },
        destroy(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete(route('requests.destroy', id), {
                        onSuccess: () => {
                            this.getrequets();
                            Swal.fire(
                                'Deleted!',
                                'Your Request has been deleted.',
                                'success'
                            )
                        }
                    })

                }
            })

        }
    },
    mounted() {
        this.getrequets();
    }

}
</script>
<style></style>
