<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, onMounted, computed } from 'vue';
import { InertiaLink } from '@inertiajs/inertia-vue3'
const props = defineProps({
    categories: Array,
    products: Array,
});

const list = () => {
  return props.categories.map((category) => {
    return {
      id: category.id,
      name: category.name,
      photo: category.photo
    }
  })
}

const listProducts = () => {
    return props.products.map((product) => {
        return {
            id: product.id,
            slug: product.slug,
            description: product.description,
            name: product.name,
            photo: product.photo
        }
    })
}

onMounted(() => {
  console.log(props);
})


const datas = ref(list());
const products = ref(listProducts());
</script>
<template>
    <AppLayout title="Marketplace">
        <template #page-header >
           <div class="mx-3">
             <h1 class="text-2xl text-slate-800 font-bold">Find the right product for you ✨</h1>
                <div class="flex ak fq ja jv jm zh zx zk tnq trr tri iv">

                        <!-- Sidebar -->
                        <div>
                            <div class="bg-white bd rounded-sm border border-slate-200 dz ur">
                                <div class="sn zl tn_ fn">
                                    <!-- Group 1 -->
                                    <div>
                                        <div class="text-sm text-slate-800 gh ro">Categories</div>
                                        <ul class="text-sm gp fb">
                                            <li v-for="category in datas" :key="category.id">
                                                <inertia-link class="g_ xp capitalize text-base font-bold"  :href="route('marketplace.index') + '?category=' + category.id">{{ category.name }}</inertia-link>
                                                <!-- <img src={{ category.photo }} alt=""> -->
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Price Range -->
                                    <div>
                                        <div class="text-sm text-slate-800 gh ro">Country Range</div>
                                        <label class="d">Country</label>
                                        <select class="a ou">
                                            <option>Morocco</option>
                                            <option>France</option>
                                            <option>England</option>
                                            <option>Togo</option>
                                        </select>
                                    </div>
                                    <!-- Group 3 -->
                                    <div>
                                        <div class="text-sm text-slate-800 gh ro">Multi Select</div>
                                        <ul class="fb">
                                            <li>
                                                <label class="flex items-center">
                                                    <input type="checkbox" class="i" checked="">
                                                    <span class="text-sm g_ gp nq">Apps / Software</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex items-center">
                                                    <input type="checkbox" class="i" checked="">
                                                    <span class="text-sm g_ gp nq">Education</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex items-center">
                                                    <input type="checkbox" class="i">
                                                    <span class="text-sm g_ gp nq">Books &amp; Writing</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="flex items-center">
                                                    <input type="checkbox" class="i">
                                                    <span class="text-sm g_ gp nq">Drawing / Painting</span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Group 4 -->
                                    <div>
                                        <div class="text-sm text-slate-800 gh ro">Sort By Rating</div>
                                        <ul class="fb">
                                            <li>
                                                <!-- Rating button -->
                                                <button class="flex items-center fc mr-2">
                                                    <!-- Stars -->
                                                    <div class="flex fm">
                                                        <svg class="oo sl du yn" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yn" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yn" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yn" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yf" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="inline-flex text-sm text-slate-500 gm"><span class="d">4 Stars</span> And up</div>
                                                </button>
                                            </li>
                                            <li>
                                                <!-- Rating button -->
                                                <button class="flex items-center fc mr-2">
                                                    <!-- Stars -->
                                                    <div class="flex fm">
                                                        <svg class="oo sl du yn" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yn" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yn" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yf" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yf" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="inline-flex text-sm text-slate-500 gm"><span class="d">3 Stars</span> And up</div>
                                                </button>
                                            </li>
                                            <li>
                                                <!-- Rating button -->
                                                <button class="flex items-center fc mr-2">
                                                    <!-- Stars -->
                                                    <div class="flex fm">
                                                        <svg class="oo sl du yn" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yn" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yf" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yf" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yf" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="inline-flex text-sm text-slate-500 gm"><span class="d">2 Stars</span> And up</div>
                                                </button>
                                            </li>
                                            <li>
                                                <!-- Rating button -->
                                                <button class="flex items-center fc mr-2">
                                                    <!-- Stars -->
                                                    <div class="flex fm">
                                                        <svg class="oo sl du yn" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yf" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yf" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yf" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                        <svg class="oo sl du yf" viewBox="0 0 16 16">
                                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="inline-flex text-sm text-slate-500 gm"><span class="d">1 Stars</span> And up</div>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div>
                            <!-- Filters -->
                            <div class="ii">
                                <ul class="flex flex-wrap -m-1">
                                    <li class="m-1">
                                        <button class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border cp bv ho ye wi wu">View All</button>
                                    </li>
                                    <li class="m-1">
                                        <button class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">Featured</button>
                                    </li>
                                    <li class="m-1">
                                        <button class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">Newest</button>
                                    </li>
                                    <li class="m-1">
                                        <button class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">Price - Low To High</button>
                                    </li>
                                    <li class="m-1">
                                        <button class="inline-flex items-center justify-center text-sm gp gw rounded-full vn vf border border-slate-200 hover--border-slate-300 bv bg-white text-slate-500 wi wu">Price - High to Low</button>
                                    </li>
                                </ul>
                            </div>

                            <div class="text-sm text-slate-500 gm ri">{{ products.length }} {{ (products.length > 1) ? 'Items' : 'Item' }}</div>
                            <!-- Cards 1 (Video Courses) -->
                            <div>
                                <div class="sn ag fn" v-if="products.length > 0">
                                    <!-- Card 1 -->
                                    <div class="tz qd tns bg-white bd rounded-sm border border-slate-200 la" v-for="product in products" :key="product.id">
                                        <div class="flex ak sh">
                                            <!-- Image -->
                                            <div class="y">
                                                <img class="ou" :src="product.photo" width="301" height="226" alt="Application 21">
                                                <!-- Like button -->
                                                <button class="g k q io mr-4">
                                                    <div class="yp bg-slate-900 pf rounded-full">
                                                        <span class="d">Like</span>
                                                        <svg class="sf os du" viewBox="0 0 32 32">
                                                            <path d="M22.682 11.318A4.485 4.485 0 0019.5 10a4.377 4.377 0 00-3.5 1.707A4.383 4.383 0 0012.5 10a4.5 4.5 0 00-3.182 7.682L16 24l6.682-6.318a4.5 4.5 0 000-6.364zm-1.4 4.933L16 21.247l-5.285-5A2.5 2.5 0 0112.5 12c1.437 0 2.312.681 3.5 2.625C17.187 12.681 18.062 12 19.5 12a2.5 2.5 0 011.785 4.251h-.003z"></path>
                                                        </svg>
                                                    </div>
                                                </button>
                                                <!-- Special Offer label -->
                                                <div class="g te q ri mr-4">
                                                    <div class="inline-flex items-center go gp yp bg-slate-900 pf rounded-full gn vi vd">
                                                        <svg class="w-3 h-3 ub du yn mr-1" viewBox="0 0 12 12">
                                                            <path d="M11.953 4.29a.5.5 0 00-.454-.292H6.14L6.984.62A.5.5 0 006.12.173l-6 7a.5.5 0 00.379.825h5.359l-.844 3.38a.5.5 0 00.864.445l6-7a.5.5 0 00.075-.534z"></path>
                                                        </svg>
                                                        <span>Special Offer</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Content -->
                                            <div class="uw flex ak dz">
                                                <!-- Card body -->
                                                <div class="uw">
                                                    <header class="ru">
                                                        <a href="#0">
                                                            <h3 class="ga text-slate-800 gh rt">{{ product.name }}</h3>
                                                        </a>
                                                        <div class="text-sm">{{ product.description }}</div>
                                                    </header>
                                                </div>
                                                <!-- Rating and price -->
                                                <div class="flex flex-wrap fe items-center">
                                                   <button class="btn ou ho xi ye" href="#0">Details</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="" v-if="products.length === 0">
                                    <div class="flex justify-center">
                                        <div class="inline-flex items-center justify-center go gp vp vf bg-white border border-slate-200 rounded-full ny">
                                            Pas de produit disponible pour cette catégorie 😪
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="rk">
                                <div class="flex ak ja jc jd">
                                    <nav class="ri _y _f" role="navigation" aria-label="Navigation">
                                        <ul class="flex justify-center">
                                            <li class="ml-3 first--ml-0">
                                                <a class="btn bg-white border-slate-200 yf af" href="#0" disabled="">&lt;- Previous</a>
                                            </li>
                                            <li class="ml-3 first--ml-0">
                                                <a class="btn bg-white border-slate-200 hover--border-slate-300 text-indigo-500" href="#0">Next -&gt;</a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <div class="text-sm text-slate-500 gn qe">
                                        Showing <span class="gp g_">1</span> to <span class="gp g_">10</span> of <span class="gp g_">467</span> results
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

           </div>
        </template>
    </AppLayout>
</template>

<script>
export default {

}
</script>

<style>
</style>
