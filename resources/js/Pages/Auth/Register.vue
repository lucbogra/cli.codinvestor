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
import { onMounted } from 'vue';

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
  terms: false,
  recaptcha_token : ''
});

const submit = () => {
  grecaptcha.execute('6LeoF7AmAAAAAIRWR-EXHzP8l_J7We_b29lpzQFi', { action: 'register' })
    .then(function (token) {
      console.log(token);
      form.recaptcha_token = token;
      form.post(route('register'), {
      onFinish: () => form.reset('password', 'password_confirmation'),
      });
  });

};

const steps = [
  { name: 'Step 1', href: '#', status: 'current' },
  { name: 'Step 2', href: '#', status: 'upcoming' },
  { name: 'Step 3', href: '#', status: 'upcoming' },
  { name: 'Step 4', href: '#', status: 'upcoming' },
]
onMounted(() => {
  const recaptchaScript = document.createElement("script");
    recaptchaScript.setAttribute(
      "src",
      "https://www.google.com/recaptcha/api.js?render=6LeoF7AmAAAAAIRWR-EXHzP8l_J7We_b29lpzQFi"
    );
    document.head.appendChild(recaptchaScript);
})
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

    <form @submit.prevent="submit" id="registerForm">
      <input type="hidden" class="g-recaptcha" v-model="form.recaptcha_token" id="recaptcha_token">
      <div>
        <JetLabel for="first_name" value="First Name" />
        <JetInput id="first_name" v-model="form.first_name" type="text"
          :class="['mt-1 block w-full', form.errors.first_name ? 'border-red-600' : '']" required autofocus
          autocomplete="first_name" />
      </div>

      <div>
        <JetLabel for="last_name" value="Last Name" />
        <JetInput id="last_name" v-model="form.last_name" type="text"
          :class="['mt-1 block w-full', form.errors.last_name ? 'border-red-600' : '']" required
          autocomplete="last_name" />
      </div>

      <div class="mt-4">
        <JetLabel for="email" value="Email" />
        <JetInput id="email" v-model="form.email" type="email"
          :class="['mt-1 block w-full', form.errors.email ? 'border-red-600' : '']" required />
      </div>


      <div class="mt-4">
        <JetLabel for="phone" value="Phone" />
        <JetInput id="phone" v-model="form.phone" type="text"
          :class="['mt-1 block w-full', form.errors.phone ? 'border-red-600' : '']" required />
      </div>

      <div class="mt-4">
        <JetLabel for="password" value="Password" />
        <JetInput id="password" v-model="form.password" type="password"
          :class="['mt-1 block w-full', form.errors.password ? 'border-red-600' : '']" required
          autocomplete="new-password" />
      </div>


      <div class="mt-4">
        <JetLabel for="password_confirmation" value="Confirm Password" />
        <JetInput id="password_confirmation" v-model="form.password_confirmation" type="password"
          :class="['mt-1 block w-full', form.errors.password_confirmation ? 'border-red-600' : '']" required
          autocomplete="new-password" />
      </div>

      <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
        <JetLabel for="terms">
          <div class="flex items-center">
            <JetCheckbox id="terms" v-model:checked="form.terms" name="terms" />

            <div class="ml-2">
              I agree to the <a target="_blank" :href="route('terms.show')"
                class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank"
                :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy
                Policy</a>
            </div>
          </div>
        </JetLabel>
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
        Already registered?
        </Link>

        <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Register
        </JetButton>
      </div>
    </form>
  </JetAuthenticationCard>
</template>
