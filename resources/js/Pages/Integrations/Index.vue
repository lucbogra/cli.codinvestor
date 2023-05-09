<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import {
  CollectionIcon,
  ChevronLeftIcon,
  ArrowRightIcon,
} from "@heroicons/vue/solid";
import CheckUser from "./CheckUser.vue";

export default {
  components: {
    AppLayout,
    Link,
    CollectionIcon,
    ChevronLeftIcon,
    CheckUser,
    ArrowRightIcon,
  },
  props: {
    Integrations: Object,
    Integration_user: Object,
  },
  data() {
    return {
      show: false,
      name: "",
      id_integrat: "",
    };
  },
  methods: {
    showCheckModal(name, id) {
      console.log(name);
      this.id_integrat = id;
      this.show = !this.show;
      this.name = name;
    },
  },
};
</script>
<template>
  <AppLayout title="Integrations">
    <template #page-header>
      <div class="max-w-8xl pt-6 mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="sm:hidden" aria-label="Back">
          <a
            href="#"
            class="flex items-center text-sm font-medium text-gray-400 hover:text-gray-200"
          >
            <ChevronLeftIcon
              class="flex-shrink-0 -ml-1 mr-1 h-5 w-5 text-gray-500"
              aria-hidden="true"
            />
            Back
          </a>
        </nav>
        <nav class="mt-2 mx-10" aria-label="Breadcrumb">
          <ol role="list" class="flex justify-between mb-5">
            <li>
              <a
                href="#"
                class="text-2xl font-medium text-primary-800 flex hover:text-primary-600"
              >
                <CollectionIcon class="w-7 h-7 text-primary-800 mr-2" />
                Integrations
              </a>
            </li>
          </ol>
        </nav>
      </div>
    </template>

    <template #content>
      <CheckUser
        :id_integration="id_integrat"
        :key="name"
        :name="name"
        @closemodal="showCheckModal"
        :show="show"
      >
      </CheckUser>
      <div
        class="md:px-4 md:grid md:grid-cols-2 lg:grid-cols-3 gap-5 space-y-4 md:space-y-0"
      >
        <div
          v-for="Integration in Integration_user"
          class="max-w-sm bg-white px-6 pt-6 pb-2 rounded-xl shadow-lg transform hover:scale-105 transition duration-500"
        >
          <h3 class="mb-3 text-3xl text-center font-bold text-primary-700">
            {{ Integration.name }}
          </h3>

          <div class="relative">
            <img class="w-full h-10/12" :src="Integration.logo" alt="Logos" />
            <!--p class="absolute top-0 bg-yellow-300 text-gray-800 font-semibold py-1 px-3 rounded-br-lg rounded-tl-lg">FREE
                              </p-->
          </div>
          <h1 class="line-clamp-3 mt-4 text-primary-800 text-md cursor-pointer">
            {{ Integration.description }}
          </h1>
          <div class="flex mt-4 content-center space-x-2 lg:mt-6">
            <a
              :href="Integration.external_link"
              target="_blank"
              class="inline-flex px-6 py-3 rounded bg-primary-700 text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-primary-600 focus:bg-primary-600 w-6/12"
              >Read More<ArrowRightIcon class="text-white w-5 ml-2"
            /></a>
            <Link
              :href="route('oneclickvid.index')"
              class="inline-flex px-3 py-3 rounded bg-primary-700 text-white text-sm leading-4 font-bold whitespace-nowrap hover:bg-primary-600 focus:bg-primary-600 w-6/12"
              >Start Your Service</Link
            >
          </div>
        </div>
        <div
          v-for="Integration in Integrations"
          class="max-w-sm bg-white px-6 pt-6 pb-2 rounded-xl shadow-lg transform hover:scale-105 transition duration-500"
        >
          <h3 class="mb-3 text-3xl text-center font-bold text-primary-700">
            {{ Integration.name }}
          </h3>

          <div class="relative">
            <img class="w-full h-10/12" :src="Integration.logo" alt="Logos" />
            <!--p class="absolute top-0 bg-yellow-300 text-gray-800 font-semibold py-1 px-3 rounded-br-lg rounded-tl-lg">FREE
                          </p-->
          </div>
          <h1 class="line-clamp-3 mt-4 text-primary-800 text-md cursor-pointer">
            {{ Integration.description }}
          </h1>
          <div class="grid grid-cols-2 my-4">
            <a
              :href="Integration.external_link"
              target="_blank"
              class="btn-primary inline-flex mr-2"
              >Read More<ArrowRightIcon class="text-white w-5 ml-2"
            /></a>
            <button
              @click="showCheckModal(Integration.name, Integration.id)"
              class="btn-primary"
            >
              Get Started
            </button>
          </div>
        </div>
      </div>
    </template>
  </AppLayout>
</template>
