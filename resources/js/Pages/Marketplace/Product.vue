<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, onMounted, computed } from 'vue';
import { InertiaLink } from '@inertiajs/inertia-vue3'

const props = defineProps({
    products: Array,
});
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
    console.log(props.products);
})

</script>
<template>
    <AppLayout title="Products">
        <template #page-header>
            <div class="vs jj ttm vl ou uf na">
                <div class="ri _y flex justify-between mb-5">
                    <h1 class="gu teu text-slate-800 font-bold">Products ✨</h1>
                    <select name="" class="a ou rounded-full w-52" v-model="seleledShowing" @change="filterByShowing($event)" id="">
                        <option value="All">See all my products</option>
                        <option value="request">Where the status is request</option>
                        <option value="denied">Where the status is canceled</option>
                        <option value="access">Where the status is approved</option>
                    </select>
                </div>

                <!-- Table -->
                <div class="bg-white bd rounded-sm border border-slate-200 rc">
                    <header class="vc vu">
                        <h2 class="gh text-slate-800">Products <span class="gq gp">{{ props.products.length }}</span>
                        </h2>
                    </header>
                    <div x-data="handleSelect">

                        <!-- Table -->
                        <div class="lf">
                            <table class="ux ou">
                                <!-- Table header -->
                                <thead class="go gh gv text-slate-500 hp co cs border-slate-200">
                                    <tr>
                                        <th class="vi wy w_ vo lm of">
                                            <div class="flex items-center">
                                                <label class="inline-flex">
                                                    <span class="d">Select all</span>
                                                    <input id="parent-checkbox" class="i" type="checkbox"
                                                        @click="toggleAll">
                                                </label>
                                            </div>
                                        </th>
                                        <th class="vi wy w_ vo lm">
                                            <div class="gh gt">#</div>
                                        </th>
                                        <th class="vi wy w_ vo lm">
                                            <div class="gh gt">Image</div>
                                        </th>
                                        <th class="vi wy w_ vo lm">
                                            <div class="gh gt">Name</div>
                                        </th>
                                        <th class="vi wy w_ vo lm">
                                            <div class="gh gt">Status</div>
                                        </th>
                                        <th class="vi wy w_ vo lm">
                                            <div class="gh gt">Created At</div>
                                        </th>
                                        <th class="vi wy w_ vo lm">
                                            <div class="gh gt">Response At</div>
                                        </th>
                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody class="text-sm le lr">
                                    <!-- Row -->
                                    <tr v-for="(product, index) in props.products.data" :key="product.id">
                                        <td class="vi wy w_ vo lm of">
                                            <div class="flex items-center">
                                                <label class="inline-flex">
                                                    <span class="d">Select</span>
                                                    <input class="table-item i" type="checkbox" @click="uncheckParent">
                                                </label>
                                            </div>
                                        </td>
                                        <td class="vi wy w_ vo lm">
                                            <div class="gp yv">{{ index + 1 }}</div>
                                        </td>
                                        <td class="vi wy w_ vo lm">
                                            <img :src="product.photo" alt="" width="50">
                                        </td>
                                        <td class="vi wy w_ vo lm">
                                            <a :href="product.link" target="_blank" class="gp ">{{ product.name }}</a>
                                        </td>
                                        <td class="vi wy w_ vo lm">
                                            <div class="inline-flex gp hf yl rounded-full gn vp vd"
                                                v-if="product.pivot.status === 'request'">{{ product.pivot.status }}
                                            </div>
                                            <div class="inline-flex gp hc ys rounded-full gn vp vd"
                                                v-if="product.pivot.status === 'access'">{{ product.pivot.status }}
                                            </div>
                                            <div class="inline-flex gp hf yl rounded-full gn vp vd"
                                                v-if="product.pivot.status === 'denied'">{{ product.pivot.status }}
                                            </div>
                                        </td>

                                        <td class="vi wy w_ vo lm">
                                            <div>{{ product.created_at }}</div>
                                        </td>

                                        <td class="vi wy w_ vo lm">
                                            <div class="flex items-center">
                                                <div v-if="product.created_at === product.updated_at">NEVER</div>
                                                <div v-if="product.created_at !== product.updated_at">{{ product.updated_at }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- Pagination -->
                <div class="rk" >
                    <div class="flex ak ja jc jd">
                        <nav class="ri _y _f" role="navigation" aria-label="Navigation" v-if="products.next_page_url || products.prev_page_url">
                            <ul class="flex justify-center">
                                <li class="ml-3 first--ml-0">
                                    <inertia-link :href="products.prev_page_url" class="btn bg-white border-slate-200  hover--border-slate-300 text-indigo-500" >&lt;-
                                        Previous</inertia-link>
                                </li>
                                <li class="ml-3 first--ml-0">
                                    <inertia-link :href="products.next_page_url" class="btn bg-white border-slate-200 hover--border-slate-300 text-indigo-500"
                                        >Next -&gt;</inertia-link>
                                </li>
                            </ul>
                        </nav>
                        <div class="text-sm text-slate-500 gn qe">
                            Showing <span class="gp g_">{{ products.per_page }}</span> to <span class="gp g_">{{ products.to }}</span> of <span
                                class="gp g_">{{ products.total }}</span> results
                        </div>
                    </div>
                </div>

            </div>
        </template>
    </AppLayout>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            seleledShowing: 'All'
        }
    },
    methods: {
        filterByShowing(event) {
            this.$inertia.get(route('marketplace.products') + '?filter_by=' + event.target.value);
            this.seleledShowing = event.target.value
        }
    }
}
</script>

<style>
</style>
