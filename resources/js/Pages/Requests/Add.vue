<template >
    <Modal :show="show" @close="$emit('close_modal')">

        <div class=" px-6 py-12 bg-white border-0 shadow-lg sm:rounded-3xl">
            <h1 class="text-2xl font-bold mb-8">Request A Product</h1>
            <form @submit.prevent="store">
                <div class="relative z-0 w-full mb-5">
                    <JetLabel for="product" value="Product" />
                    <select v-model="form.product" name="product"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="" selected disabled hidden>{{ products === null ? 'You Have No Product' : 'Choose Your Product' }}</option>
                        <option v-if="products !== null" v-for="product in products" :value="product.name">{{ product.name
                        }}
                        </option>
                    </select>
                    <JetInputError :message="form.errors.product" />
                </div>

                <div class="relative z-0 w-full mb-5">
                    <JetLabel for="platform" value="Platform" />
                    <select name="platform" v-model="form.platform"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="" selected disabled hidden>Choose Your Platform</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Snapshat">Snapshat</option>
                        <option value="Google">Google</option>
                        <option value="Tiktok">Tiktok</option>
                        <option value="Instagram">Instagram</option>
                    </select>
                    <JetInputError :message="form.errors.platform" />
                </div>

                <div class="relative z-0 w-full mb-5">
                    <JetLabel for="type" value="Type" />
                    <select name="type" v-model="form.type"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="" selected disabled hidden>Choose Type Of Video</option>
                        <option value="Real">Real</option>
                        <option value="Presentation">Presentation</option>
                        <option value="2D">2D</option>
                        <option value="SlideShow">SlideShow</option>
                        <option value="Before & After">Before & After</option>
                    </select>
                    <JetInputError :message="form.errors.type" />
                </div>

                <div class="relative z-0 w-full mb-5">

                    <JetLabel for="duration" value="Duration (Seconds)" />
                    <JetInput v-model="form.duration" type="number" min="0" max="30" name="duration" class="w-full" />
                    <JetInputError :message="form.errors.duration" />
                </div>
                <div class="flex flex-row space-x-4">
                    <div class="relative z-0 w-full mb-5">
                        <JetLabel for="voice" value="Voice Over" />
                        <JetLabel class="mt-4 relative inline-flex items-center cursor-pointer">
                            <input v-model="form.voice" type="checkbox" class="sr-only peer">
                            <div
                                class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-primary-500">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"></span>
                        </JetLabel>
                        <JetInputError :message="form.errors.voice" />
                    </div>
                    <div class="relative z-0 w-full">
                        <JetLabel for="voice" value="Background Music" />
                        <JetLabel class="mt-4 relative inline-flex items-center cursor-pointer">
                            <input v-model="form.music" type="checkbox" class="sr-only peer">
                            <div
                                class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-primary-500">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"></span>
                        </JetLabel>
                        <JetInputError :message="form.errors.music" />
                    </div>
                </div>
                <div class="relative z-0 w-full mb-5">
                    <JetLabel for="message" value="Message" />
                    <textarea v-model="form.observation" name="message" rows="5"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                    <JetInputError :message="form.errors.observation" />
                </div>
                <button v-if="!loading" type="submit"
                    class="w-full px-6 py-3 mt-3 text-lg text-white transition-all duration-150 ease-linear rounded-lg shadow outline-none bg-primary-700 hover:bg-primary-600 hover:shadow-lg focus:outline-none">
                    Send Request
                </button>
                <button v-else type="submit"
                    class="w-full px-6 py-3 mt-3 text-lg text-white transition-all duration-150 ease-linear rounded-lg shadow outline-none bg-primary-700 hover:bg-primary-600 hover:shadow-lg focus:outline-none">
                    <div class="grid place-items-center p-3">
                        <div class="w-8 h-8 rounded-full animate-spin absolute border-2 border-solid border-white border-t-transparent">
                        </div>
                    </div>
                </button>
            </form>
        </div>
    </Modal>
</template>
<script>
import Modal from '../../Jetstream/Modal.vue'
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import LoadingButton from '@/Components/LoadingButton.vue';
export default {
    props: {
        show: Boolean
    },
    components:
    {
        Modal,
        JetInput,
        JetInputError,
        JetLabel,
        LoadingButton
    },
    data() {
        return {
            products: [],
            form: this.$inertia.form({
                product: '',
                platform: '',
                type: '',
                duration: '',
                music: false,
                voice: false,
                observation: '',
                costumer_id: ''
            }),
            loading: false
        }
    },
    methods: {
        getproducts() {
            axios.get(route('products.user'))
                .then((response) => {
                    this.products = response.data
                }).catch(response => {
                    console.log('error');
                })
        },
        store() {
            this.loading = true
            this.form.post(route('requests.store'), {

                onSuccess: () => {
                    this.loading = false
                    this.form.reset()
                    this.$emit('close_modal');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false,
                        timerProgressBar: true,
                        icon: 'success',
                        title: $this.page.props.value.flash.success,
                    })

                },
            })
        }
    },
    mounted() {

        this.getproducts();
    }
}
</script>
<style></style>
