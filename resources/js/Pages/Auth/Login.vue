<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import Checkbox from '@/Jetstream/Checkbox.vue';
import JetInput from '@/Jetstream/Input.vue';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>

  <Head title="Log in" />

  <!-- <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo />
        </template>

        <JetValidationErrors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <JetLabel for="email" value="Email" />
                <JetInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                />
            </div>

            <div class="mt-4">
                <JetLabel for="password" value="Password" />
                <JetInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <JetCheckbox v-model:checked="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Forgot your password?
                </Link>

                <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </JetButton>
            </div>
        </form>
    </JetAuthenticationCard> -->

  <div class="y flex">

    <!-- Content -->
    <div class="ou zi">

      <div class="on sh flex ak wl  bg-white p-4">

        <!-- Header -->
        <div class="ug">
          <div class="flex items-center fe sa vs jj ttm">
            <!-- Logo -->

          </div>
        </div>

        <div class="ul na vs vl">
          <div class="flex justify-center items-center mb-4">
            <JetAuthenticationCardLogo class="mx-auto" />
          </div>
          <div class="flex justify-center items-center mb-4">
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Sign in to your account</h2>
          </div>

          <!-- Form -->
          <JetValidationErrors class="mb-4" />
          <form @submit.prevent="submit">
            <div class="fg">
              <div>
                <label class="block text-sm gp rt" for="email">Email Address</label>
                <JetInput id="email" v-model="form.email" type="email"
                  class="mt-1" required autocomplete="current-password"
                  placeholder="Enter your e-mail address"/>
              </div>
              <div>
                <label class="block text-sm gp rt" for="password">Password</label>
                <JetInput id="password" v-model="form.password" type="password"
                  class="mt-1 " required
                  autocomplete="current-password" />
              </div>
              <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>
            </div>
            <div class="flex items-center fe rk text-center">
              <JetButton class="w-96 text-uppercase text-center flex justify-center"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Log in
              </JetButton>
            </div>
          </form>
          <!-- Footer -->
          <div class="mb rk co border-slate-200">
            <div class="text-sm">
              <Link v-if="canResetPassword" :href="route('password.request')"
                class="underline text-sm text-gray-600 hover:text-gray-900">
              Forgot your password?
              </Link>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Image -->
    <div class="relative hidden w-0 flex-1 lg:block bg-primary-800" aria-hidden="true">
      <!-- <img class="dy db ou sh" src="https://preview.cruip.com/mosaic/images/auth-image.jpg" width="760" height="1024" alt="Authentication image">
                <img class="g tg x uz ig hidden tey" src="https://preview.cruip.com/mosaic/images/auth-image.jpg" width="218" height="224" alt="Authentication decoration"> -->
    </div>

  </div>


</template>
