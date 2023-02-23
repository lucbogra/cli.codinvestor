<script setup>
import Layout from './Layout.vue';

const props = defineProps({
  message : Object,
})

</script>

<template>
  <Layout :selected_id = message.id>
    <div class="flex h-full flex-col">
    <div class="flex min-h-0 flex-1">
      <main class="min-w-0 flex-1 border-t overflow-hidden border-gray-200 xl:flex">
        <section aria-labelledby="message-heading" class="flex h-full min-w-0 flex-1 flex-col overflow-hidden xl:order-last">
          <div class="min-h-0 flex-1 overflow-y-auto">
          <div class="min-h-0 flex-1">
            <ul role="list" class="space-y-2 py-4 sm:space-y-4 sm:px-6 lg:px-8">
            <li class="px-4 py-6 bg-white shadow sm:rounded-lg sm:px-6">
              <div class="sm:flex sm:items-baseline sm:justify-between">
                <h3 class="text-base font-medium">
                  <!-- <span class="text-gray-900">To {{ message.recipiants }}</span> -->
                </h3>
                <p class="mt-1 whitespace-nowrap text-sm text-gray-600 sm:mt-0 sm:ml-3">
                  <time :datetime="message.created_at">{{ message.created_at_full }}</time>
                </p>
              </div>
              <div class="mt-4 space-y-6 text-sm text-gray-800" v-html="message.content" />
            </li>
            </ul>
          </div>
        </div>
        </section>

      </main>
    </div>
    </div>
  </Layout>
</template>
