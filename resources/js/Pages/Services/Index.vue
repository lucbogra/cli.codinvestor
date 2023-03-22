<script setup>
  import AppLayout from '@/Layouts/AppLayout.vue'
  import { ref, } from 'vue';
  import { Link, useForm } from '@inertiajs/inertia-vue3'
  import {CollectionIcon, ChevronLeftIcon } from '@heroicons/vue/solid';

  const props = defineProps({
    services: Array,
  });

  </script>
  <template>
    <AppLayout title="Services">
      <template #page-header>
      <div class="max-w-8xl pt-6 mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="sm:hidden" aria-label="Back">
          <a href="#" class="  flex items-center text-sm font-medium text-gray-400 hover:text-gray-200  ">
            <ChevronLeftIcon class="flex-shrink-0 -ml-1 mr-1 h-5 w-5 text-gray-500" aria-hidden="true" />
            Back
          </a>
        </nav>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
          <ol role="list" class="flex items-center space-x-4">
            <li>
              <a href="#" class="text-2xl font-medium text-primary-800 flex hover:text-primary-600">
                <CollectionIcon class="w-7 h-7 text-primary-800 mr-2" />
                Services
              </a>
            </li>
          </ol>
        </nav>
      </div>
    </template>

    <template #content>
      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <div class="relative mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-4">

        <div v-for="(service, i) in services" :key="i" class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ service.name }}</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700">{{ service.description }}</p>
            <div class="flex justify-between">
               <a target="" href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center btn-primary">
                Read more
                <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </a>
              <Link class="btn-primary"> Get started</Link>
            </div>

        </div>

        </div>
      </div>
    </template>

    </AppLayout>
  </template>
