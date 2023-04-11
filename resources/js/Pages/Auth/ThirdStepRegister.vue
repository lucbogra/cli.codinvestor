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
  affiliate_experience: '',
  working_country: '',
  ads_platforms: [],
  other_networks: '',
  survey: '',
});
const affiliate_experience_options = [
  { label : 'yes', value: 'yes' },
  { label : 'no', value: 'no' }
]

const ads_platforms_options = [
  { label : 'Google Ads', value: 'Google Ads' },
  { label : 'Facebook Ads', value: 'Facebook Ads' },
  { label : 'Native Ads', value: 'Native Ads' },
  { label : 'Snapchat Ads', value: 'Snapchat Ads' },
  { label : 'Tiktok Ads', value: 'Tiktok Ads' },
  { label : 'Others' },

]
const submit = () => {
  form.put(route('user.register.store_third_step'), {
  });
};

const steps = [
  { name: 'Step 1', href: '#', status: 'complete' },
  { name: 'Step 2', href: '#', status: 'complete' },
  { name: 'Step 3', href: '#', status: 'current' },
  { name: 'Step 4', href: '#', status: 'upcoming' },
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
        <JetLabel for="affiliate_experience" value="Do you have any experience with COD affiliate marketing ?" />
        <div class="flex items-center mb-2" v-for="(option, index) in affiliate_experience_options" :key="index">
          <input  id="budget-under-25k" v-model="form.affiliate_experience" name="budget" :value="option.value" type="radio"
            class="focus:ring-primary h-4 w-4 text-primary border-gray-300" />
          <label for="budget-under-25k" class="ml-3">
            <span class="block text-sm text-gray-700">{{ option.label }}</span>
          </label>
        </div>
      </div>

      <div class="mt-4" v-if="form.affiliate_experience == 'yes'">
        <JetLabel for="other_networks" value="Can you talk about your experience and share their names with us?" />
        <textarea id="how-can-we-help" v-model="form.other_networks" name="how-can-we-help"
            aria-describedby="how-can-we-help-description" rows="4"
            class="block w-full shadow-sm sm:text-sm focus:ring-primary-500 focus:border-primary-500 border border-gray-300 rounded-md"></textarea>
      </div>

      <div class="mt-4">
        <JetLabel for="working_country" value="In which country are you currently working ?" />
        <JetInput id="working_country" v-model="form.working_country" type="text"
          :class="['mt-1 block w-full', form.errors.working_country ? 'border-red-600' : '']" required />
      </div>


      <div class="mt-4">
        <JetLabel for="ads_platforms" value="What are the advertising platforms you use ?" />
        <div class="mt-4 grid grid-cols-1 gap-y-4">
          <div class="flex items-center" v-for="(option, index) in ads_platforms_options" :key="index">
            <input id="platform1" v-model="form.ads_platforms" name="platform1" :value="option.value"
              type="checkbox" class="focus:ring-primary h-4 w-4 text-primary border-gray-300" />
            <label for="ads_platforms" class="ml-3">
              <span class="block text-sm text-gray-700">{{ option.label }}</span>
            </label>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <JetLabel for="survey" value="How did you hear about us ?" />
        <textarea id="how-can-we-help" v-model="form.survey" name="how-can-we-help"
            aria-describedby="how-can-we-help-description" rows="4"
            :class="['block w-full shadow-sm sm:text-sm focus:ring-primary-500 focus:border-primary-500 border border-gray-300 rounded-md', form.errors.survey ? 'border-red-600' : '']"></textarea>
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
