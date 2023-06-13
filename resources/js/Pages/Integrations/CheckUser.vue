<template>
    <Modal maxWidth="xl" :show="show" @close="$emit('closemodal')">
        <form @submit.prevent="store">
            <div class="w-full p-8 max-w-2xl relative mx-auto my-auto rounded-xl shadow-lg bg-white" v-if="link">
                <div class="w-full p-8 max-w-2xl relative mx-auto my-auto rounded-xl bg-white">
                    <p class="w-full text-4xl text-center leading-snug">
                        Link Your {{ name }} account
                    </p>
                    <div class="w-full mt-6 mr-0 mb-0 ml-0 relative space-y-8">
                        <div class="relative">
                            <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                Email
                            </p>
                            <input v-model="form.email" required placeholder="123@ex.com" type="text"
                                class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md" />
                        </div>
                        <div class="relative">
                            <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                Password
                            </p>
                            <input v-model="form.password" required placeholder="Password" type="password"
                                class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md" />
                        </div>
                        <div class="mt-7">
                            <div class="flex justify-center items-center">
                                <label class="mr-2">You Don't have An Account?</label>
                                <button @click="toggle()" type="button"
                                    class="text-blue-500 transition duration-500 ease-in-out transform hover:-translate-x hover:scale-105">
                                    Sign up
                                </button>
                            </div>
                        </div>

                        <div class="relative">
                            <button v-if="!loading" type="submit"
                                class="w-full inline-block pt-4 pr-5 pb-4 pl-5 text-xl font-medium text-center text-white bg-primary-800 rounded-lg transition duration-200 hover:bg-primary-600 ease">
                                Submit
                            </button>
                            <button v-else type="button"
                                class="w-full inline-block pt-4 pr-5 pb-4 pl-5 text-xl font-medium text-center text-white bg-primary-800 rounded-lg transition duration-200 hover:bg-primary-600 ease">
                                <div class="grid place-items-center p-3">
                                    <div
                                        class="w-10 h-10 rounded-full animate-spin absolute border-2 border-solid border-white border-t-transparent">
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div v-if="have_account === null"
                    class="w-full max-w-xl p-5 relative mx-auto my-auto rounded-xl shadow-lg bg-white">
                    <div class="">
                        <div class="text-center p-5 flex-auto justify-center">
                            <MailIcon class="w-16 h-16 flex items-center text-primary-500 mx-auto"></MailIcon>

                            <h2 class="text-xl font-bold py-4">
                                Do You Have An Account In {{ name }} ?
                            </h2>
                            <p class="text-sm text-gray-500 px-8"></p>
                        </div>
                        <div class="p-3 mt-2 text-center space-x-4 md:block">
                            <button @click="have_account = true"
                                class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                                No
                            </button>
                            <button @click="togglelink"
                                class="mb-2 md:mb-0 bg-primary-500 border border-primary-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-primary-600">
                                Yes
                            </button>
                        </div>
                    </div>
                </div>
                <div v-else class="w-full max-w-xl p-5 relative mx-auto my-auto rounded-xl shadow-lg bg-white">
                    <div v-if="!survey" class="">
                        <div class="text-center p-5 flex-auto justify-center">
                            <MailIcon class="w-16 h-16 flex items-center text-primary-500 mx-auto"></MailIcon>

                            <h2 class="text-xl font-bold py-4">
                                Are You Sure You Don't Have An Account In {{ name }} ?
                            </h2>
                            <p class="text-sm text-gray-500 px-8"></p>
                        </div>
                        <div class="inline-flex p-3 mt-2 text-center space-x-4 md:block">
                            <button @click="have_account = null"
                                class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                                <div class="grid place-items-center">No</div>
                            </button>
                            <button @click="survey = true"
                                class="mb-2 md:mb-0 bg-primary-500 border border-primary-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-primary-600">
                                <div class="grid place-items-center">
                                    Yes, Create A New Account
                                </div>
                            </button>

                        </div>
                    </div>
                    <div v-else>
                        <div class="relative py-4 px-5 md:px-10 bg-white rounded">
                            <div class="w-full flex justify-start text-gray-600 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-wallet"
                                    width="52" height="52" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>
                                <h1 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4 mt-4">
                                    Survey
                                </h1>
                            </div>

                            <div>
                                <jetLabel>what type of platforms do you use the most for your
                                    advertising campaigns ?</jetLabel>
                                <el-select class="w-full" v-model="form.platforms" multiple placeholder="Select Platforms">
                                        <el-option v-for="platform in platforms" :key="platform" :label="platform"
                                            :value="platform" />
                                    </el-select>
                            </div>

                            <div class="mt-4">
                                <jetLabel>what is your average number of leads/day?</jetLabel>
                                <jetInput type="number" class="block w-full p-2" v-model="form.leads"></jetInput>
                            </div>

                            <div class="mt-4">
                                <jetLabel>what is your CPL?</jetLabel>
                                <jetInput type="number" class="block w-full p-2" v-model="form.cpl"></jetInput>
                            </div>

                            <div class="mt-4">
                                <jetLabel>have you ever used a similar service?</jetLabel>
                                <div class="inline-flex space-x-3">
                                    <span class="block font-medium text-sm text-gray-700"><input type="radio"
                                            name="similaire" value="Yes" v-model="form.similar_service" />
                                        Yes
                                    </span>
                                    <span class="block font-medium text-sm text-gray-700"><input type="radio"
                                            name="similaire" value="No" v-model="form.similar_service" />
                                        No
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4" v-if="form.similar_service === 'No'">
                                <jetLabel>tell us more about this service</jetLabel>
                                <textarea v-model="form.service_observation"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"></textarea>
                            </div>

                            <div class="mt-4">
                                <jetLabel>why you subscribe to this service?</jetLabel>
                                <ul class="list-disc ml-7">
                                    <li>
                                        <input class="rounded border-gray-300 text-primary-600 shadow-sm" type="checkbox"
                                            @click="check" value="Gain Time" v-model="form.subscribe" />
                                        Gain Time
                                    </li>
                                    <li>
                                        <input class="rounded border-gray-300 text-primary-600 shadow-sm" type="checkbox"
                                            value="I have no experience in creating videos." v-model="form.subscribe" />

                                        have no experience in creating videos.
                                    </li>
                                    <li>
                                        <input class="rounded border-gray-300 text-primary-600 shadow-sm" type="checkbox"
                                            value="to have the best videos and a better conversion rate"
                                            v-model="form.subscribe" />

                                        To have the best videos and a better conversion rate
                                    </li>
                                    <li>
                                        <input class="rounded border-gray-300 text-primary-600 shadow-sm" type="checkbox"
                                            value="others" v-model="form.subscribe" />
                                        Others
                                        <jetInput v-model="form.others_observation" v-if="form.subscribe.includes('others')"
                                            type="text"></jetInput>
                                    </li>
                                </ul>
                            </div>

                            <div class="flex items-center justify-center mt-6 w-full">
                                <button @click="$emit('closemodal')"
                                    class="btn-primary bg-gray-100 text-primary-800 mr-2 hover:bg-primary-600 hover:text-white">
                                    Cancel
                                </button>
                                <button v-if="!loading" class="btn-primary" type="button" @click="togglecreate()">
                                    Create Account
                                </button>
                                <button v-else
                                    class="mb-2 md:mb-0 bg-primary-500 border border-primary-500 px-7 py-4 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-primary-600">
                                    <div class="grid place-items-center">
                                        <div
                                            class="w-6 h-6 rounded-full animate-spin absolute border-2 border-solid border-white border-t-transparent">
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </Modal>
</template>
<script>
import Modal from "../../Jetstream/Modal.vue";
import { MailIcon } from "@heroicons/vue/solid";
import jetInput from "@/Jetstream/Input.vue";
import jetLabel from "@/Jetstream/Label.vue";
export default {
    components: {
        Modal,
        MailIcon,
        jetInput,
        jetLabel
    },
    props: {
        show: Boolean,
        name: String,
        id_integration: Number,
    },
    data() {
        return {
            create: false,
            link: false,
            use_info: false,
            form: this.$inertia.form({
                id: this.$page.props.user.investor.id,
                id_integration: this.id_integration,
                name: this.$page.props.user.name,
                email: this.$page.props.user.email,
                password: this.$page.props.user.password,
                type: "",
                subscribe: [],
                platforms: [],
                leads: "",
                cpl: "",
                similar_service: "Yes",
                service_observation: "",
                others_observation: ""
            }),
            have_account: null,
            loading: false,
            survey: false,
            value: [
            ],
            platforms : ['Facebook','Google','Snapshat','Tiktok']
        };
    },
    methods: {
        toggle() {
            this.have_account = true;
            this.link = false;
            this.loading = false;
        },
        togglecreate() {
            this.form.type = "Create";

            this.store();
        },
        togglelink() {
            this.form.type = "Link";
            this.link = !this.link;
            this.loading = false;
            this.survey = false;
            this.form.password = "";
        },
        store() {
            this.loading = true;
            this.form.post(route("users.oneclickvid"), {
                onSuccess: () => {
                    this.loading = false;
                    this.create = false;
                    this.link = false;
                    this.use_info = false;
                    this.survey = false
                    this.form.reset();
                    this.$emit("closemodal");
                },
            });
        },
        useInformation() {
            if (this.use_info) {
                this.form.name = this.$page.props.user.name;
                this.form.email = this.$page.props.user.email;
                this.use_info = false;
            } else {
                this.form.name = "";
                this.form.email = "";
                this.use_info = true;
            }
        },
    },
    mounted() {
        // console.log([this.name,this.id])
    },
};
</script>
<style lang=""></style>
