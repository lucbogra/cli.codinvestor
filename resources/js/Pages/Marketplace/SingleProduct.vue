<template>
    <Link :href="route('marketplace.detail', product.slug)" class="flex flex-col justify-between group border rounded overflow-hidden hover:shadow p-4 bg-white h-full font-pathway-extreme tracking-tight">
        <div class="relative h-[180px] md:h-[200px] xl:h-[230px] group-hover:opacity-75 overflow-hidden">
            <img :src="product.photo" :alt="product.slug" class="h-full w-full scale-100 group-hover:scale-105 transition-all duration-300 object-cover object-center " />

            <div class="absolute inset-0 p-2 flex flex-col justify-between">
                <div class="flex mt-1 space-x-1">
                    <span class="text-xs rounded py-1 px-2 bg-orange-400 text-white">{{ product.niche }}</span>
                    <!-- <span class="text-xs rounded py-1 px-2 bg-green-400 text-white"> {{ product.stock_status  }} </span> -->
                </div>

                <div>
                    <span v-for="(item, index) in product.countries" :key="index" :class="['fi fi-'+item.flag_code, 'mr-2']"></span>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <Link :href="route('marketplace.detail', product.slug)" class="leading-3 truncate text-sm">
                {{ product.name }}
            </Link>
            <p class="text-base font-bold text-orange-600 ">{{ '$'+product.commission }}</p>
        </div>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  product: Object,
})
</script>
