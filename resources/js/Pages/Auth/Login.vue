<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

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

                        <h1 class="text-3xl text-slate-800 font-bold rh">Welcome back! ✨</h1>
                        <!-- Form -->
                        <form @submit.prevent="submit">
                            <div class="fg">
                                <div>
                                    <label class="block text-sm gp rt" for="email">Email Address</label>
                                    <input id="email" v-model="form.email" type="email" class="mt-1 block w-full" required autocomplete="current-password">
                                </div>
                                <div>
                                    <label class="block text-sm gp rt" for="password">Password</label>
                                    <input id="password" v-model="form.password" type="password" class="mt-1 block w-full" required autocomplete="current-password" />
                                </div>
                            </div>
                            <div class="flex items-center fe rk text-center">
                                <JetButton class="w-96 text-uppercase text-center flex justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Log in
                                </JetButton>
                            </div>
                        </form>
                        <!-- Footer -->
                        <div class="mb rk co border-slate-200">
                            <div class="text-sm">
                                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                                    Forgot your password?
                                </Link>
                            </div>
                            <!-- Warning -->
                            <div class="rw">
                                <div class="hb ya vn vr rounded">
                                    <svg class="inline w-3 h-3 ub du" viewBox="0 0 12 12">
                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                    </svg>
                                    <span class="text-sm">
                                        To support you during the pandemic super pro features are free until March 31st.
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Image -->
            <div class="qx g k te q zi" aria-hidden="true">
                <img class="dy db ou sh" src="https://preview.cruip.com/mosaic/images/auth-image.jpg" width="760" height="1024" alt="Authentication image">
                <img class="g tg x uz ig hidden tey" src="https://preview.cruip.com/mosaic/images/auth-image.jpg" width="218" height="224" alt="Authentication decoration">
            </div>

        </div>
</template>
