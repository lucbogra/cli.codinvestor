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
        <div class="relative mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-3">
          <div v-for="(service, i) in services" :key="i"
            class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200 bg-white">
            <div class="p-6 flex flex-1 flex-col justify-between">
              <h2 class="text-lg leading-6 font-medium text-gray-900">{{ service.name }}</h2>
              <p class="mt-4 text-sm text-gray-500">{{ service.description }}</p>

              <div class="self-end">
                <div>
                  <p class="mt-8 mb-2">
                    <span class="text-4xl font-extrabold text-gray-900">{{ service.price }} {{ service.currency }}</span>
                  {{ ' ' }}
                  <span class="text-base font-medium text-gray-500">/mo</span>
                  </p>
                </div>
                <div class="">
                   <Link href="/contact" class="btn-primary">
                  Suscribe to{{ service.name }}
                </Link>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </template>

    </AppLayout>
  </template>
