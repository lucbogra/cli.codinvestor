<template >
    <Modal maxWidth="xl" :show="show" @close="$emit('closemodal')">

        <div class=" w-full p-8 max-w-2xl relative mx-auto my-auto rounded-xl shadow-lg  bg-white " v-if="link">

            <form @submit.prevent="store">
                <div class="w-full p-8 max-w-2xl relative mx-auto my-auto rounded-xl  bg-white ">
                    <p class="w-full text-4xl text-center leading-snug">Link Your {{ name }} account</p>
                    <div class="w-full mt-6 mr-0 mb-0 ml-0 relative space-y-8">
                        <div class="relative">
                            <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                Email</p>
                            <input v-model="form.email" placeholder="123@ex.com" type="text"
                                class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md" />
                        </div>
                        <div class="relative">
                            <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                Password
                            </p>
                            <input v-model="form.password" placeholder="Password" type="password"
                                class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md" />
                        </div>
                        <div class="mt-7">
                            <div class="flex justify-center items-center">
                                <label class="mr-2">You Don't have An Account?</label>
                                <button @click="toggle()" type="button"
                                    class=" text-blue-500 transition duration-500 ease-in-out  transform hover:-translate-x hover:scale-105">
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
                                        <div class="w-10 h-10 rounded-full animate-spin absolute
                                                            border-2 border-solid border-white border-t-transparent"></div>
                                    </div>
                                </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div v-else>
                <div v-if="have_account === null"
                    class="w-full  max-w-xl p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
                    <div class="">
                        <div class="text-center p-5 flex-auto justify-center">

                            <MailIcon class="w-16 h-16 flex items-center text-primary-500 mx-auto"></MailIcon>

                            <h2 class="text-xl font-bold py-4 ">Do You Have An Account In {{ name }} ?</h2>
                            <p class="text-sm text-gray-500 px-8"></p>
                        </div>
                        <div class="p-3  mt-2 text-center space-x-4 md:block">
                            <button @click="have_account = true"
                                class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                                No
                            </button>
                            <button @click="togglelink"
                                class="mb-2 md:mb-0 bg-primary-500 border border-primary-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-primary-600">Yes</button>
                        </div>
                    </div>
                </div>
                <div v-else class="w-full  max-w-xl p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
                    <div class="">
                        <div class="text-center p-5 flex-auto justify-center">

                            <MailIcon class="w-16 h-16 flex items-center text-primary-500 mx-auto"></MailIcon>

                            <h2 class="text-xl font-bold py-4 ">Are You Sure You Don't Have An Account In {{ name }} ?</h2>
                            <p class="text-sm text-gray-500 px-8"></p>
                        </div>
                        <div class="inline-flex p-3 mt-2 text-center space-x-4 md:block">
                            <button @click="have_account = null"
                                class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                                <div class="grid place-items-center">
                                    No
                                </div>
                            </button>
                            <button v-if="!loading" @click="togglecreate"
                                class="mb-2 md:mb-0 bg-primary-500 border border-primary-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-primary-600">
                                <div class="grid place-items-center">Yes,
                                    Create A New Account
                                </div>
                            </button>
                            <button v-else
                                class="mb-2 md:mb-0 bg-primary-500 border border-primary-500 px-7 py-4 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-primary-600">
                                <div class="grid place-items-center">
                                    <div class="w-6 h-6 rounded-full animate-spin absolute
                                                        border-2 border-solid border-white border-t-transparent"></div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    </Modal>
    <!-- <Modal maxWidth="2xl" :show="create" @close="$emit('closemodal')">
        <div class=" w-full p-8 max-w-2xl relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">

            <p class="w-full text-4xl text-center leading-snug">Sign up for an account</p>
            <div class="mt-6 mb-4"><input type="checkbox" @change="useInformation" /> Use Your Account Information</div>
            <div class="w-full mt-6 mr-0 mb-0 ml-0 relative space-y-8">
                <div class="relative">
                    <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600
                                                                                                  absolute">Name</p>
                    <input v-model="form.name" type="text"
                        class="border placeholder-gray-400 focus:outline-none
                                                                                                  focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white
                                                                                                  border-gray-300 rounded-md" />
                </div>
                <div class="relative">
                    <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                        Email</p>
                    <input v-model="form.email" placeholder="123@ex.com" type="text"
                        class="border placeholder-gray-400 focus:outline-none
                                                                                                  focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white
                                                                                                  border-gray-300 rounded-md" />
                </div>
                <div class="relative">
                    <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600
                                                                                                  absolute">Password</p>
                    <input v-model="form.password" placeholder="Password" type="password"
                        class="border placeholder-gray-400 focus:outline-none
                                                                                                  focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white
                                                                                                  border-gray-300 rounded-md" />
                </div>
                <div class="mt-7">
                    <div class="flex justify-center items-center">
                        <label class="mr-2">Do you already have an account?</label>
                        <button @click="() => { this.create = false; this.link = true }" type="button"
                            class=" text-blue-500 transition duration-500 ease-in-out  transform hover:-translate-x hover:scale-105">
                            Log in
                        </button>
                    </div>
                </div>
                <div class="relative">
                    <button type="button" @click="store"
                        class="w-full inline-block pt-4 pr-5 pb-4 pl-5 text-xl font-medium text-center text-white bg-primary-800
                                                                                                  rounded-lg transition duration-200 hover:bg-primary-600 ease">Submit</button>
                </div>
            </div>
        </div>
    </Modal> -->
    <!-- <Modal maxWidth="2xl" :show="link" @close="$emit('closemodal')">
        <form @submit.prevent="store">
            <div class="w-full p-8 max-w-2xl relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
                <p class="w-full text-4xl text-center leading-snug">Link Your {{ name }} account</p>
                <div class="w-full mt-6 mr-0 mb-0 ml-0 relative space-y-8">
                    <div class="relative">
                        <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                            Email</p>
                        <input v-model="form.email" placeholder="123@ex.com" type="text"
                            class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md" />
                    </div>
                    <div class="relative">
                        <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">Password
                        </p>
                        <input v-model="form.password" placeholder="Password" type="password"
                            class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md" />
                    </div>
                    <div class="mt-7">
                        <div class="flex justify-center items-center">
                            <label class="mr-2">You Don't have An Account?</label>
                            <button @click="toggle()" type="button"
                                class=" text-blue-500 transition duration-500 ease-in-out  transform hover:-translate-x hover:scale-105">
                                Sign up
                            </button>
                        </div>
                    </div>

                    <div class="relative">
                        <button type="submit"
                            class="w-full inline-block pt-4 pr-5 pb-4 pl-5 text-xl font-medium text-center text-white bg-primary-800
                                                                                                      rounded-lg transition duration-200 hover:bg-primary-600 ease">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </Modal> -->
</template>
<script>
import Modal from '../../Jetstream/Modal.vue'
import { MailIcon } from '@heroicons/vue/solid';
export default {
    components: {
        Modal,
        MailIcon
    },
    props: {
        show: Boolean,
        name: String,
        id_integration: Number
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
                type: ''
            }),
            have_account: null,
            loading: false
        }
    },
    methods: {
        toggle() {
            this.have_account = true
            this.link = false
            this.loading = false
        },
        togglecreate() {
            this.form.type = 'Create'
            this.store()
        },
        togglelink() {
            this.form.type = 'Link'
            this.link = !this.link
            this.loading=false
        },
        store() {
            this.loading = true
            this.form.post(route('users.oneclickvid'), {
                onSuccess: () => {
                    this.loading = false
                    this.create = false
                    this.link = false
                    this.use_info = false
                    this.form.reset();
                    this.$emit('closemodal')
                }
            })

        },
        useInformation() {
            if (this.use_info) {
                this.form.name = this.$page.props.user.name
                this.form.email = this.$page.props.user.email
                this.use_info = false
            }
            else {
                this.form.name = ''
                this.form.email = ''
                this.use_info = true
            }
        }
    },
    mounted() {
        // console.log([this.name,this.id])
    }
}
</script>
<style lang="">

</style>
