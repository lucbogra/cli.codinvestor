<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import {
  CollectionIcon,
  ChevronLeftIcon,
  ArrowRightIcon,
} from "@heroicons/vue/solid";
import CheckUser from "./CheckUser.vue";
import { ref } from "vue";

const props = defineProps({
  integrations: Object,
  integration_user: Object,
})
const show = ref(false)
const name = ref(null)
const id_integrat = ref(null)
const survey_check = ref(true)

const form = useForm({
  logout : ''
})

const showCheckModal = (integration) => {
  id_integrat.value = integration.id
  show.value = !show.value
  name.value = integration.name
}

const logout = (integration) => {
  this.form.put(route('oneclickvid.logout', integration))

}
</script>
<template>
  <AppLayout title="Integrations">
    <template #page-header>
      <div class="max-w-8xl pt-6 mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="sm:hidden" aria-label="Back">
          <a href="#" class="flex items-center text-sm font-medium text-gray-400 hover:text-gray-200">
            <ChevronLeftIcon class="flex-shrink-0 -ml-1 mr-1 h-5 w-5 text-gray-500" aria-hidden="true" />
            Back
          </a>
        </nav>
        <nav class="mt-2 mx-10" aria-label="Breadcrumb">
          <ol role="list" class="flex justify-between mb-5">
            <li>
              <a href="#" class="text-2xl font-medium text-primary-800 flex hover:text-primary-600">
                <CollectionIcon class="w-7 h-7 text-primary-800 mr-2" />
                Integrations
              </a>
            </li>
          </ol>
        </nav>
      </div>
    </template>

    <template #content>
      <!-- <survey :show="survey_check"></survey> -->
      <CheckUser :id_integration="id_integrat" :key="name" :name="name" @closemodal="showCheckModal" :show="show"/>

      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 xl:mx-10 ">

      <!-- <div class="md:px-4 md:grid md:grid-cols-2 lg:grid-cols-3 gap-5 space-y-4 md:space-y-0">

        <div v-for="integration in integration_user"
          class="max-w-sm bg-white px-6 pt-6 pb-2 rounded-xl shadow-lg transform hover:scale-105 transition duration-500">
          <h3 class="mb-3 text-3xl text-center font-bold text-primary-700">
            {{ integration.name }}
          </h3>

          <div class="relative">
            <img class="w-full h-10/12" :src="integration.logo" alt="Logos" />
          </div>
          <p class="line-clamp-3 mt-4 text-primary-800 text-md cursor-pointer">
            {{ integration.description }}
          </p>
          <div v-if="integration.connected" class="flex mt-4 content-center space-x-2 lg:mt-6">
            <button @click="logout(integration)"
              class="text-center px-6 py-3 rounded bg-primary-700 text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-primary-600 focus:bg-primary-600 w-6/12">Logout</button>
            <Link :href="route('oneclickvid.index')"
              class="text-center px-3 py-3 rounded bg-primary-700 text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-primary-600 focus:bg-primary-600 w-6/12">
            Start Your Service</Link>
          </div>
          <div v-else class="flex mt-4 content-center space-x-2 lg:mt-6">
            <button @click="showCheckModal(integration.name, integration.id)"
              class="btn-primary">
              Sign In or Sign Up
            </button>
            <button @click="logout(integration)"
              class="text-center px-6 py-3 rounded bg-primary-700 text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-primary-600 focus:bg-primary-600 w-6/12">Connect</button>
          </div>
        </div>

        <div v-for="not_registered_integration in integrations"
          class="max-w-sm bg-white px-6 pt-6 pb-2 rounded-xl shadow-lg transform hover:scale-105 transition duration-500">
          <h3 class="mb-3 text-3xl text-center font-bold text-primary-700">
            {{ not_registered_integration.name }}
          </h3>

          <div class="relative">
            <img class="w-full h-10/12" :src="not_registered_integration.logo" alt="Logos" />
          </div>
          <h1 class="line-clamp-3 mt-4 text-primary-800 text-md cursor-pointer">
            {{ not_registered_integration.description }}
          </h1>
          <div class="grid grid-cols-2 my-4">
            <a :href="not_registered_integration.external_link" target="_blank" class="btn-primary inline-flex mr-2">Read
              More
              <ArrowRightIcon class="text-white w-5 ml-2" />
            </a>
            <button @click="showCheckModal(not_registered_integration.name, not_registered_integration.id)"
              class="btn-primary">
              Get Started
            </button>
          </div>
        </div>
      </div> -->

      <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4">

        <div class="w-full mb-4 border-gray-200 bg-white transform hover:scale-105 transition duration-500 border rounded-md" v-for="(item, index) in integrations" :key="index">
        <div
            class="rounded-t-md flex justify-center items-center shadow-md lg:w-full 2xl:w-full 2xl:h-44 object-cover px-4">
            <img class="h-32" :src="item.logo" />
        </div>
        <div class="bg-white px-6">
            <h2 class="text-center text-primary-700 text-2xl font-bold pt-3">
                {{ item.name }}
            </h2>
            <div class="w-5/6 m-auto">
              <!-- <p class="text-center text-gray-500 pt-3 line-clamp-2 text-sm" v-html="item.description"></p> -->
            </div>
            <div v-if="!item.integrated" class="flex justify-center items-center">
              <div class="grid grid-cols-2 my-4">
                <a :href="item.external_link" target="_blank" class="btn-primary inline-flex mr-2">Read
                  More
                  <ArrowRightIcon class="text-white w-5 ml-2" />
                </a>
                <button @click="showCheckModal(item)"
                  class="btn-primary">
                  Get Started
                </button>
              </div>
            </div>
            <div v-else class="flex justify-center items-center my-4">
              <div v-if="item.connected" class="flex mt-4 content-center space-x-2 lg:mt-6">
                <button @click="logout(integration)"
                  class="btn-danger">Logout</button>
                <Link :href="route('oneclickvid.index')" class="btn-primary">
                Start Your Service</Link>
              </div>
              <div v-else class="flex mt-4 content-center space-x-2 lg:mt-6">
                <button @click="showCheckModal(item.name, item.id)"
                  class="btn-primary">
                  Sign In or Sign Up
                </button>
                <button @click="logout(item)"
                  class="btn-primary">Connect</button>
              </div>
            </div>
        </div>
    </div>
      </div>
      </div>
    </template>
  </AppLayout>
</template>
