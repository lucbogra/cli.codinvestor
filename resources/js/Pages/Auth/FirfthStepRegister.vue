<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import { CheckIcon } from '@heroicons/vue/solid';

const steps = [
  { name: 'Step 1', description : 'registration', href: '#', status: 'complete' },
  // { name: 'Step 2', description : 'personnal informations', href: '#', status: 'complete' },
  { name: 'Step 2', description : 'survey', href: '#', status: 'complete' },
  // { name: 'Step 4', description : 'document uploading', href: '#', status: 'complete' },
  { name: 'Step 3', description : 'verification', href: '#', status: 'current' },
]

</script>

<template>
  <Head title="Register" />

  <JetAuthenticationCard>
    <template #logo>
      <JetAuthenticationCardLogo />
    </template>

    <div class="flex flex-col sm:justify-center items-center mb-4">
      <nav aria-label="Progress">
        <ol role="list" class="overflow-hidden">
          <li v-for="(step, stepIdx) in steps" :key="step.name" :class="[stepIdx !== steps.length - 1 ? 'pb-10' : '', 'relative']">
            <template v-if="step.status === 'complete'">
              <div v-if="stepIdx !== steps.length - 1" class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-primary-600" aria-hidden="true" />
              <a :href="step.href" class="group relative flex items-start">
                <span class="flex h-9 items-center">
                  <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-primary-600 group-hover:bg-primary-800">
                    <CheckIcon class="h-5 w-5 text-white" aria-hidden="true" />
                  </span>
                </span>
                <span class="ml-4 flex min-w-0 flex-col">
                  <span class="text-sm font-medium">{{ step.name }}</span>
                  <span class="text-sm text-gray-500">{{ step.description }}</span>
                </span>
              </a>
            </template>
            <template v-else-if="step.status === 'current'" condition="step.status === 'current'">
              <div v-if="stepIdx !== steps.length - 1" class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true" />
              <a :href="step.href" class="group relative flex items-start" aria-current="step">
                <span class="flex h-9 items-center" aria-hidden="true">
                  <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-primary-600 bg-white">
                    <i class="fa-solid fa-gear fa-spin text-primary-600"></i>
                  </span>
                </span>
                <span class="ml-4 flex min-w-0 flex-col">
                  <span class="text-sm font-medium text-primary-600">{{ step.name }}</span>
                  <span class="text-sm text-gray-500">{{ step.description }}</span>
                </span>
              </a>
            </template>
            <template v-else>
              <div v-if="stepIdx !== steps.length - 1" class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true" />
              <a :href="step.href" class="group relative flex items-start">
                <span class="flex h-9 items-center" aria-hidden="true">
                  <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
                    <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300" />
                  </span>
                </span>
                <span class="ml-4 flex min-w-0 flex-col">
                  <span class="text-sm font-medium text-gray-500">{{ step.name }}</span>
                  <span class="text-sm text-gray-500">{{ step.description }}</span>
                </span>
              </a>
            </template>
          </li>
        </ol>
      </nav>
    </div>

    <p class="mb-4 text-sm text-gray-600">
      Thank you for trusting us and submitting your information. We are verifying your information to give you access to the application. You will receive a validation email once the process is complete
    </p>

    <div class="flex items-center justify-end mt-4">
      <Link :href="route('logout')" method="POST" class="underline text-sm text-gray-600 hover:text-gray-900">
        Logout?
      </Link>
    </div>

  </JetAuthenticationCard>
</template>
