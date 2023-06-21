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
                        <!-- <option :value="this.request.product">{{ this.request.product }}</option> -->
                        <option v-if="products !== null" v-for="product in products" :key="product.name" :value="product.name.trim()">{{ product.name}}</option>
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
                    <JetLabel for="video_size" value="Size" />
                    <select name="video_size" v-model="form.video_size"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="" selected disabled hidden>Choose Size Of Video</option>
                        <option v-for="size in video_sizes" :value="size">{{size}} pixels</option>
                        
                    </select>
                    <JetInputError :message="form.errors.type" />
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
                    <JetLabel for="duration" value="Duration" />
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
                    {{ action }} Request
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
import Modal from '../../../../Jetstream/Modal.vue'
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import LoadingButton from '@/Components/LoadingButton.vue';
export default {
    props: {
        show: Boolean,
        request: Object,
        action: String,
        products:Object
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
            loading: false,
            form: this.$inertia.form({
                product: this.request.product.trim(),
                platform: this.request.platform,
                type: this.request.type,
                duration: this.request.duration,
                music: this.request.music === 1 ? true : false,
                voice: this.request.voice_over === 1 ? true : false,
                observation: this.request.observation,
                costumer_id: '',
                video_size:this.request.video_size
            }),
            facebook:['1920 x 1080','1080 x 1080','1080 x 1920'],
            tiktok:['1080 x 1920','1080 x 1080'],
            google:['1280 x 720','1920 x 1080'],
        }
    },
    methods: {
        getproducts() {
            // console.log(this.products)
            // axios.get(route('products.user'))
            //     .then((response) => {
            //         // console.log(response.data)
            //         this.products = response.data
            //     }).catch(response => {
            //         console.log('error');
            //     })
        },
        store() {
            this.loading=true
            if (this.action === 'Duplicate') {

                this.form.post(route('requests.store'), {
                    onSuccess: () => {
                        this.loading = false
                        this.$emit('close_modal');
                    },
                })
            }
            else {
                this.form.put(route('requests.update', this.request.id), {
                    onSuccess: () => {
                        this.loading = false
                        this.$emit('close_modal');
                      
                    },
                })
            }

        }
    },
    mounted() {

        this.getproducts();
    },
    computed: {
        video_sizes()
        {
            if(this.form.platform=='') return []
            else{
                if(this.form.platform=='Facebook') return this.facebook
                else if(this.form.platform=='Snapchat' || this.form.platform=='Tiktok' || this.form.platform=='Instagram') return this.tiktok
                else if(this.form.platform=='Google') return this.google
            }
        }
    }
}
</script>
<style></style>
