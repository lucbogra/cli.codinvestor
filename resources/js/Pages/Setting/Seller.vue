<script setup>
import { onMounted } from '@vue/runtime-core';
import Layout from './Layout.vue';
import FileInput from '../../Components/FileInput.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { EyeIcon } from '@heroicons/vue/solid';

const get_started = () => {
  if(confirm('Do you want to switch your account to seller')){
     Inertia.visit(route('seller.get_started'), {
      method : 'PUT'
    })
  }
}
</script>

<template>
  <Layout title="Notifications">
    <div class="max-w-6xl bg-white mx-auto sm:px-6 lg:px-8 p-8">
      <div class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:flex lg:items-center lg:justify-between lg:px-8">
      <h2 class="text-3xl font-bold tracking-tight text-primary-800 sm:text-4xl">Ready to dive in?<br />Start for free today.</h2>
      <div class="mt-10 flex items-center gap-x-6 lg:mt-0 lg:flex-shrink-0" v-if="$page.props.auth.user.seller_status == 'none'">
        <button @click="get_started" class="btn-primary">Get started</button>
        <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Learn more <span aria-hidden="true">→</span></a>
      </div>
      <div class="mt-10 flex items-center gap-x-6 lg:mt-0 lg:flex-shrink-0" v-if="$page.props.auth.user.seller_status == 'approved'">
        <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Seller Dashboard <span aria-hidden="true">→</span></a>
      </div>
      <div class="mt-10 flex items-center gap-x-6 lg:mt-0 lg:flex-shrink-0" v-if="$page.props.auth.user.seller_status == 'request'">
        <a href="#" class="btn-primary">Account Verification <i class="fa-solid fa-gear fa-spin text-white"></i></a>
      </div>
    </div>
  </div>
    </div>
  </Layout>
</template>
