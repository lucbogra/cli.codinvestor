<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import { CheckIcon } from '@heroicons/vue/solid';

const form = useForm({
  company: '',
  address: '',
  country: '',
  city: '',
  zip: '',
});

const submit = () => {
  form.put(route('user.register.store_second_step'), {
  });
};

const steps = [
  { name: 'Step 1', href: '#', status: 'complete' },
  { name: 'Step 2', href: '#', status: 'current' },
  { name: 'Step 3', href: '#', status: 'upcoming' },
  { name: 'Step 4', href: '#', status: 'upcoming' },
]
</script>

<template>
  <Head title="Register second step" />

  <JetAuthenticationCard>
    <template #logo>
      <JetAuthenticationCardLogo />
    </template>

    <div class="flex flex-col sm:justify-center items-center mb-4">
      <nav aria-label="Progress">
        <ol role="list" class="flex items-center">
          <li v-for="(step, stepIdx) in steps" :key="step.name"
            :class="[stepIdx !== steps.length - 1 ? 'pr-8 sm:pr-20' : '', 'relative']">
            <template v-if="step.status === 'complete'">
              <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="h-0.5 w-full bg-primary-700" />
              </div>
              <a href="#"
                class="relative flex h-8 w-8 items-center justify-center rounded-full bg-primary-700 hover:bg-indigo-900">
                <CheckIcon class="h-5 w-5 text-white" aria-hidden="true" />
                <span class="sr-only">{{ step.name }}</span>
              </a>
            </template>
            <template v-else-if="step.status === 'current'" condition="step.status === 'current'">
              <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="h-0.5 w-full bg-gray-200" />
              </div>
              <a href="#"
                class="relative flex h-8 w-8 items-center justify-center rounded-full border-2 border-primary-700 bg-white"
                aria-current="step">
                <span class="h-2.5 w-2.5 rounded-full bg-primary-700" aria-hidden="true" />
                <span class="sr-only">{{ step.name }}</span>
              </a>
            </template>
            <template v-else>
              <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="h-0.5 w-full bg-gray-200" />
              </div>
              <a href="#"
                class="group relative flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white hover:border-gray-400">
                <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300" aria-hidden="true" />
                <span class="sr-only">{{ step.name }}</span>
              </a>
            </template>
          </li>
        </ol>
      </nav>
    </div>

    <JetValidationErrors class="mb-4" />

    <form @submit.prevent="submit">
      <div>
        <JetLabel for="company" value="Company" />
        <JetInput id="company" v-model="form.company" type="text"
          :class="['mt-1 block w-full', form.errors.company ? 'border-red-600' : '']" required autofocus/>
      </div>

      <div>
        <JetLabel for="address" value="Address" />
        <div class="mt-1">
          <textarea id="how-can-we-help" v-model="form.address" name="how-can-we-help"
            aria-describedby="how-can-we-help-description" rows="4"
            class="block w-full shadow-sm sm:text-sm focus:ring-primary-500 focus:border-primary-500 border border-gray-300 rounded-md"></textarea>
        </div>
      </div>


      <div class="mt-4">
        <JetLabel for="country" value="Country" />
        <JetInput id="country" v-model="form.country" type="text"
          :class="['mt-1 block w-full', form.errors.country ? 'border-red-600' : '']" required />
      </div>

      <div class="mt-4">
        <JetLabel for="city" value="City" />
        <JetInput id="city" v-model="form.city" type="text"
          :class="['mt-1 block w-full', form.errors.city ? 'border-red-600' : '']" required />
      </div>

      <div class="mt-4">
        <JetLabel for="zip" value="zip" />
        <JetInput id="zip" v-model="form.zip" type="text"
          :class="['mt-1 block w-full', form.errors.zip ? 'border-red-600' : '']" required />
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link :href="route('logout')" method="POST" class="underline text-sm text-gray-600 hover:text-gray-900">
          Logout?
        </Link>

        <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Next
        </JetButton>
      </div>
    </form>
  </JetAuthenticationCard>
</template>
