<script setup>
import { usePage, Link,  } from "@inertiajs/inertia-vue3";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/solid";
import { onMounted, ref } from "vue";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";
  const props = defineProps({
    selected_id: Number,
  });
  const messages = ref([])

  onMounted( async () => {
    const res = await axios.get(route('messages.all'))
    messages.value = res.data
  })
  </script>

  <template>
    <AppLayout>
      <template #page-header>
        <div class="mt-2 p-5 mx-10">
        <div class="">
          <h1 class="gu teu text-primary-800 font-bold">Messages</h1>
        </div>
      </div>
      </template>
      <template #content>
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
          <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-4" v-if="messages != []">
            <nav class="space-y-1 h-full" aria-label="messages">
              <ul role="list" class="divide-y divide-gray-200">
                <li v-for="message in messages" :key="message.id" :class="['relative py-5 px-4 focus-within:ring-2 focus-within:ring-inset focus-within:ring-primary-600 hover:bg-gray-100', selected_id == message.id ? 'bg-primary-700 hover:bg-primary-700 ' : 'bg-white']">
                  <div class="flex justify-end" v-if="message.read_at == null">
                    <span class="-mt-6 -mr-6 text-xs font-medium bg-cyan-100 px-1 text-primary-500 rounded-lg group-hover:text-gray-800">New</span>
                  </div>
                  <div class="flex justify-between space-x-3">
                    <div class="min-w-0 flex-1">
                      <Link :href="route('messages.show', message.slug)" class="block focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true" />
                        <p :class="['truncate text-sm font-bold', selected_id == message.id ? 'text-white' : 'text-gray-900']">Technical Service</p>
                        <p :class="['truncate text-sm', selected_id == message.id ? 'text-white' : 'text-gray-500']">{{ message.title }}</p>
                      </Link>
                    </div>
                    <time :datetime="message.created_at" :class="['flex-shrink-0 whitespace-nowrap text-sm', selected_id == message.id ? 'text-white' : 'text-gray-500']">{{ message.time }}</time>
                  </div>
                  <div class="mt-1">
                    <!-- <p class="text-sm text-gray-600 line-clamp-2">{{ message.preview }}</p> -->
                  </div>
                </li>
              </ul>
            </nav>
          </aside>

          <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-8">
            <slot />
          </div>
        </div>
      </template>

    </AppLayout>
  </template>
