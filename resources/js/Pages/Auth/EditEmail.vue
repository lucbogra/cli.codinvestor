<script setup>
import { computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';

const props = defineProps({
    status: String,
});

const form = useForm({
  email : usePage().props.value.user.email
});

const submit = () => {
    form.put(route('user.change_email'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Email Verification" />

    <JetAuthenticationCard>
        <template #logo>
            <JetAuthenticationCardLogo />
        </template>

        <form @submit.prevent="submit">
          <div class="mt-4 mb-2">
            <JetLabel for="email" value="Email" />
            <JetInput id="email" v-model="form.email" type="email" placeholder="Email"
              :class="['mt-1 block w-full', form.errors.email ? 'border-red-600' : '']" required />
          </div>
          <div class="flex justify-end">
            <JetButton class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Save
            </JetButton>
          </div>

        </form>
    </JetAuthenticationCard>
</template>
