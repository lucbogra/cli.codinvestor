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
import { ref } from 'vue';

const form = useForm({
  photo : ''
});

const submit = () => {
  if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }
  form.post(route('user.register.store_fourth_step'), {
  });
};
const photoInput = ref(null);

const photoPreview = ref(null);
const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const steps = [
  { name: 'Step 1', href: '#', status: 'complete' },
  { name: 'Step 2', href: '#', status: 'complete' },
  { name: 'Step 3', href: '#', status: 'complete' },
  { name: 'Step 4', href: '#', status: 'current' },
]
</script>

<template>
  <Head title="Register fourth step" />

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

      <div class="flex items-center justify-center w-full">
          <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 ">
              <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <div v-show="photoPreview" class="mt-2">
                    <span
                        class="block w-20 h-20 bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + photoPreview + '\');'"
                    />
                </div>
                  <svg  v-show="! photoPreview" aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                  <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload your CIN or Passeport</span> </p>
                  <p class="text-xs text-gray-500 ">PNG, JPG smaller than 2MB</p>
              </div>
              <input ref="photoInput" id="dropzone-file" type="file" class="hidden" @change="updatePhotoPreview" accept=".PNG, .JPG"/>
          </label>
      </div>


      <div class="flex items-center justify-end mt-4">
        <Link :href="route('logout')" method="POST" class="underline text-sm text-gray-600 hover:text-gray-900">
          Logout?
        </Link>

        <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Finish
        </JetButton>
      </div>
    </form>
  </JetAuthenticationCard>
</template>
