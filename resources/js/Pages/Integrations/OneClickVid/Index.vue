
<template >
    <Head title="OneclickVid" />
    <AppLayout title="OneclickVid">

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
                            OneClickVid
                        </div>
                    </li>
                </ol>
            </nav>
        </template>
        <template #content>
            <h1
                class="text-2xl font-medium text-primary-800 flex hover:text-primary-600 items-center space-x-2 sm:px-6 lg:max-w-7xl lg:px-8">
                OneCLickVid</h1>
            <!--Cards -->
            <Cards :request_number="requests.length" :answers_count="answers_count" :number_video="number_video"
                :investorRemain="investorRemain" :dailylimit="pack ? pack.limit : 0"></Cards>

            <!--Error Bars -->
            <div v-if="pack!=null && passlimit.length>=pack.limit" class="p-4 mx-6 mb-4 text-md bg-red-200 text-red-800" role="alert">
                    You Passed Your Daily Limit To Request Creatives <span class="font-semibold">({{ pack.limit }} Requests)</span>
            </div>
            <div v-if="pack != null && (days_left.toFixed(0) < 5 || number_video == 0)" :class="{
                'bg-red-200 text-red-800': (days_left.toFixed(0) < 10 || number_video == 0),
            }" class="p-4 mx-6 mb-4 text-md flex justify-between" role="alert">
                <span>
                    Your subscription
                    <span class="font-semibold" v-if="pack != null">{{ 'to ' + pack.name }}</span>
                    <span class="font-medium"> {{ days_left.toFixed(0) <= 0 || number_video == 0 ? ' has Been Expired'
                        : ' will expire in ' + days_left.toFixed(0) + ' days' }}</span>
                    </span>
                    <div v-if="(days_left.toFixed(0) <= 0 || number_video == 0)">
                        <button @click="togglepack" class="font-semibold">Renew Your Pack</button>
                    </div>
            </div>

            <!--buttons-->
            <div>
                <div class="flex justify-between mb-1 min-w-max my-6 mx-5">
                    <h1 class="text-primary-800 font-bold">Request Creatives</h1>
                    <div class="inline-flex">
                        <button type="button" @click="getrequets()" class="btn-primary mr-2">
                            <RefreshIcon v-bind:class="{ 'animate-spin': load === true, 'animate-none': load === false }"
                                class="w-4"></RefreshIcon>
                        </button>
                        <button v-if="pack ? passlimit.length < pack.limit : true" @click="addRequestToggle" type="button"
                            class="btn-primary cursor-pointer">Request
                            Creative</button>
                        <button v-else disabled type="button"
                            class="px-6 py-3 rounded bg-gray-400 text-white text-sm leading-4 font-bold whitespace-nowrap">Request
                            Creative</button>
                    </div>
                </div>

                <!--request table-->
                <div class="bg-gray-100 flex items-center justify-center font-sans overflow-hidden">
                    <div class="-mx-4 w-full sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <VTable :data="requests" class="min-w-full table-fixed  " :page-size="10"
                                v-model:currentPage="page" @totalPagesChanged="totalPages = $event">
                                <template #head>
                                    <VTh sortKey="ref" class="bg-gray-200 text-gray-600 py-3 px-6 text-left">Reference
                                    </VTh>
                                    <VTh sortKey="created_at" class="bg-gray-200 text-gray-600 py-3 px-6 text-left">Date
                                    </VTh>
                                    <th class="bg-gray-200 text-gray-600 py-3 px-6 text-left">Product</th>
                                    <th class="bg-gray-200 text-gray-600 py-3 px-6 text-left">Platform</th>
                                    <th class="bg-gray-200 text-gray-600 py-3 px-6 text-left">Type</th>
                                    <th class="bg-gray-200 text-gray-600 py-3 px-6 text-left">Status</th>
                                    <th class="bg-gray-200 text-gray-600 py-3 px-6 text-left">Rate</th>
                                    <th class="bg-gray-200 text-gray-600 py-3 px-6 text-left">Actions</th>


                                </template>
                                <template #body="{ rows }">
                                    <tr v-for="(request, index) in rows" :key="index"
                                        class="border-t border-gray-200 bg-white hover:bg-gray-50 focus-within:bg-gray-100"
                                        :class="index % 2 === 0 ? undefined : 'bg-gray-50'">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-9 h-9 rounded-full flex-shrink-0 bg-primary-500 my-2 mr-3">
                                                    <svg class="w-9 h-9 fill-current text-indigo-50" viewBox="0 0 36 36">
                                                        <path
                                                            d="M18 10c-4.4 0-8 3.1-8 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L18.9 22H18c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <button @click="copyRef(request.ref, index)"
                                                    class="text-primary-700 text-lg font-medium	 tracking-wide">
                                                    {{ request.ref }}
                                                    <span v-if="copy && selected_index == index"
                                                        class="block mt-2 text-center text-gray-800 text-sm">Ref Copied
                                                        !
                                                    </span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <div class="flex items-center">
                                                <span>{{ request.created_at }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <div class="flex items-center">
                                                <span>{{ request.product }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <div class="flex items-center">
                                                <span>{{ request.platform }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <div class="flex items-center">
                                                <span>{{ request.type }}</span>
                                            </div>
                                        </td>

                                        <td v-if="request.answer" class="py-4 px-6 text-center">
                                            <button type="button" @click="answerToggle(request.answer)"
                                                class="bg-green-400 hover:bg-green-300 py-1 px-2 rounded-full text-sm font-bold text-white">Answered</button>

                                        </td>
                                        <td v-else class="py-4 px-6 text-center">
                                            <button
                                                class="cursor-text bg-orange-400 hover:bg-orange-300 py-1 px-2 rounded-full text-sm font-bold text-white">
                                                Pending</button>

                                        </td>
                                        <td v-if="request.answer && request.answer.rates === null"
                                            class="py-3 px-6 text-center font-bold">
                                            <button @click="rateToggle(request.answer)" class="btn-primary">Rate</button>
                                        </td>
                                        <td v-else-if="request.answer && request.answer.rates !== null"
                                            class="py-3 px-6 text-center font-bold">
                                            <StarIcon v-for="request in Number(request.answer.rates)"
                                                class="inline-flex text-primary-600 w-5 fill-current" />
                                            <!-- <EmptyStar class="inline-flex text-primary-600 w-5 h-auto fill-current" v-for="request in 5 - Number(request.answer.rates)"/> -->
                                            <svg v-for="request in 5 - Number(request.answer.rates)"
                                                class="inline-flex text-primary-600 w-4 fill-current"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path
                                                    d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z" />
                                            </svg>
                                        </td>
                                        <td v-else class="py-3 px-6 text-center">
                                            Pending
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center">
                                                <div v-if="pack!=null ? passlimit.length<pack.limit : false" @click="toggleduplicatemodal(request, 'Duplicate')"
                                                    class="w-5 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer">
                                                    <DuplicateIcon class="text-primary-500" />
                                                </div>
                                                <Link class="w-5 mr-2 transform hover:text-purple-500 hover:scale-110"
                                                    :href="route('oneclickvid.show', request.id)">
                                                <EyeIcon class="text-primary-500 cursor-pointer" />

                                                </Link>
                                                <button v-if="request.read === false && request.answer == null"
                                                    @click="toggleduplicatemodal(request, 'update')"
                                                    class="w-5 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer">
                                                    <PencilIcon class="text-primary-500" />
                                                </button>
                                                <button @click="confimrdestroy(request, index)"
                                                    v-if="request.read === false && request.answer == null"
                                                    class="w-5 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer">
                                                    <TrashIcon class="text-primary-500" />
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </VTable>

                            <VTPagination class="flex justify-center " v-model:currentPage="page" :total-pages="totalPages"
                                :boundary-links="false" :maxPageLinks="requests.length">
                                <template #firstPage>
                                    <i class="fas fa-arrow-left text-[#BBBBBB] text-xs" />
                                </template>

                                <template #lastPage>
                                    <i class="fas fa-arrow-right text-[#BBBBBB] text-xs" />
                                </template>

                                <template #next>
                                    <i class="fas fa-chevron-right text-[#BBBBBB] text-xs" />
                                </template>

                                <template #previous>
                                    <i class="fas fa-chevron-left text-[#BBBBBB] text-xs" />
                                </template>
                            </VTPagination>
                        </div>
                    </div>
                </div>
            </div>
            <!--button of Messages -->
            <button @click="contactToggle(null)" title="Contact Sale"
                class="fixed z-40 right-5 bottom-5 shadow-lg flex justify-center items-center w-14 h-14 bg-primary-500 rounded-full focus:outline-none hover:bg-primary-600 focus:bg-primary-600 transition duration-300 ease">
                <PhoneIcon v-if="!contact" class="text-white w-6 h-6" />
                <XIcon v-else class="text-white w-6 h-6" />
                <div v-if="not_readed_messages" class="animate-ping rounded-full bg-red-600 w-3 h-3 absolute top-0 right-0">
                </div>
                <div v-if="not_readed_messages" class="rounded-full bg-red-600 w-3 h-3 absolute top-0 right-0"></div>
            </button>

            <!--Modals -->
            <Answer_Modal :answer="current_answer" :show="show_answer" @closemodal="answerToggle"></Answer_Modal>
            <Add_request :products="products" :show="show_add" @close_modal="addRequestToggle"></Add_request>
            <Rate v-if="current_answer" :id="current_answer.id" :show="show_rate"
                @closemodal="rateToggle(current_answer)" />
            <Duplicate_request v-if="selected_request != null" :action="action_request" :key="selected_request"
                :request="selected_request" :products="products" :show="show_duplicate"
                @close_modal="toggleduplicatemodal(selected_request, 'update')"></Duplicate_request>
            <Contact :key="request" :status='status' :request="request" :show="contact" @closemodal="contactToggle(null)"
                @reload_request="getrequets()"></Contact>
            <Packs :hasPackPaid="hasIntegrationPayment" :key="packModal" :show="packModal" @closemodal="togglepack" />
            <br>
            <ConfirmationModal :situation="'danger'" :show="confirm"
                :message="'Are You Sure You want to Delete this Request ?'"
                @cancel="confimrdestroy(selected_request, selected_index)"
                @confirm="destroy(selected_request, selected_index)" />
        </template>

    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { ChevronRightIcon, PaperAirplaneIcon, BellIcon, UploadIcon, RefreshIcon, StarIcon, XIcon } from '@heroicons/vue/solid'
import { EyeIcon, PencilIcon, TrashIcon, DuplicateIcon, PhoneIcon, CameraIcon, InformationCircleIcon, CurrencyDollarIcon } from '@heroicons/vue/outline'
import Add_request from './Requests/Add.vue'
import Answer_Modal from './Answer.vue'
import Rate from './Rate.vue'
import Duplicate_request from './Requests/Duplicate.vue'
import Contact from '../OneClickVid/Contact.vue'
import Packs from './Pack.vue'
import moment from 'moment'
import { Head } from '@inertiajs/inertia-vue3'
import ConfirmationModal from './ConfirmationModal.vue'
import Cards from './Cards.vue'
export default {
    name: "OneClickVid",
    props: {
        hasIntegrationPayment: Boolean,
        investorRemain: Number
    },
    components: {
        AppLayout, ChevronRightIcon, PaperAirplaneIcon, Link, UploadIcon, BellIcon,
        Add_request, EyeIcon, PencilIcon, TrashIcon, Answer_Modal, DuplicateIcon,
        Rate, Duplicate_request, RefreshIcon, StarIcon, PhoneIcon, Contact, XIcon,
        Packs, CameraIcon, InformationCircleIcon, CurrencyDollarIcon, ConfirmationModal, Cards
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
            load: false,
            contact: false,
            request: null,
            status: '',
            not_readed_messages: false,
            copy: false,
            selected_index: '',
            pack: [],
            packModal: false,
            number_video: 0,
            days_left: 0,
            products: [],
            page: 1,
            paidPayment: 0,
            mustPaidPayment: 0,
            confirm: false,
            passlimit: []

        }
    },
    methods: {
        contactToggle(request, status) {
            this.contact = !this.contact
            this.request = request
            this.status = status
            this.countNotReadedMessages()
        },
        getproducts() {
            axios.get(route('products.user'))
                .then((response) => {
                    this.products = response.data
                }).catch(response => {
                    console.log('error');
                })
        },
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
            if (this.pack != null) {
                if (moment(this.pack.pivot.end_date).isSameOrBefore(moment().format('YYYY-MM-DD')) || this.number_video <= 0)
                    this.packModal = !this.packModal
                else {
                    this.getrequets()
                    this.show_add = !this.show_add
                }

            }
            else this.packModal = !this.packModal


        },
        toggleduplicatemodal(request, action) {
            if (this.pack != null) {
                if (moment(this.pack.pivot.end_date).isSameOrBefore(moment().format('YYYY-MM-DD')) || this.number_video <= 0) {
                    if (action == 'Duplicate') this.packModal = !this.packModal
                    else {
                        this.getrequets()
                        this.selected_request = request
                        this.action_request = action
                        this.show_duplicate = !this.show_duplicate
                    }
                }
                else {
                    this.getrequets()
                    this.selected_request = request
                    this.action_request = action
                    this.show_duplicate = !this.show_duplicate
                }
            }
            else this.packModal = !this.packModal
        },
        getrequets() {
            this.load = true;
            axios.get(route('userequests'))
                .then((response) => {
                    this.passlimit = (response.data['requests'].filter((request) => (moment(request.created_at).format('YYYY-MM-DD') == moment().format('YYYY-MM-DD')) && request.pack.pack_info.id == response.data['user_pack'].id))
                    this.answers_count = 0
                    this.requests = response.data['requests']
                    this.pack = response.data['user_pack']
                    if (this.pack != null) {
                        this.number_video = response.data['user_pack'] != null ? response.data['user_pack'].number_video : 0
                        this.days_left = moment.duration(moment(this.pack.pivot.end_date).diff(moment())).asDays()

                        this.requests.map((request) => {
                            if (moment(moment(request.created_at).startOf('hour').format('YYYY-MM-DD hh:mm:ss')).isBetween(this.pack.pivot.start_date, this.pack.pivot.end_date) && request.pack?.id == response.data['user_pack'].pivot.id) this.number_video -= 1
                            if (request.answer != null) this.answers_count += 1
                        })

                    }

                    this.load = false
                })
                .catch(resonse => {
                    console.log('error');
                })
        },
        confimrdestroy(request, index) {
            this.selected_request = request
            this.selected_index = index
            this.confirm = !this.confirm
        },
        destroy(request, index) {
            this.getrequets();
            this.confirm = false
            if (this.requests[index].read === false && this.requests[index].answer == null) {
                this.form.delete(route('requests.destroy', request.id), {
                    onSuccess: () => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            timer: 5000,
                            showConfirmButton: false,
                            timerProgressBar: true,
                            icon: 'success',
                            title: 'Deleted successfully.',
                        })
                        this.getrequets();
                    }
                })
            }

        },
        countNotReadedMessages() {
            axios.get(route('messages.get'))
                .then((response) => {
                    this.not_readed_messages = false
                    Object.values(response.data.length ? response.data[0].messages : []).map((message) => {

                        if (message['read'] == null && message['response']) {
                            this.not_readed_messages = true
                        }
                    })
                })
                .catch((error) => {
                    console.error(error)
                })
        },
        timout() {
            this.copy = false
        },
        copyRef(ref, index) {
            this.selected_index = index
            navigator.clipboard.writeText(ref)
            this.copy = true
            setTimeout(this.timout, 1000)
        }
        ,
        togglepack() {
            this.getrequets();
            this.packModal = !this.packModal
        },

    },
    mounted() {
        this.getrequets();
        this.countNotReadedMessages()
        this.getproducts()
    }

}
</script>
<style>
.vt-pagination {
    @apply flex justify-center pr-1 py-2
}

.pagination {
    @apply flex
}

li.page-item {
    @apply bg-transparent mx-1 px-2 text-gray-500 rounded-lg
}

li.page-item.active {
    @apply bg-primary-500 mx-1 px-2 text-white rounded-lg
}
</style>
