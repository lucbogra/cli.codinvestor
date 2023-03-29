<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const verificationLinkSent = ref(null);
const show = ref(true)

const sendEmailVerification = () => {
  verificationLinkSent.value = true;
};
</script>

<template>
  <div class="mx-4">
    <div v-if="$page.props.jetstream.hasEmailVerification && $page.props.user.email_verified_at === null && show" class="flex p-4 mb-4 text-danger rounded-lg bg-red-50 border border-red-300" role="alert">
      <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
      <span class="sr-only">Info</span>
      <div class="ml-3 text-sm font-medium">
        Your email address is unverified. <Link :href="route('verification.send')"  method="post" as="button" @click.prevent="sendEmailVerification" class="font-semibold underline hover:no-underline">Click here to re-send the verification email.</Link>
      </div>
      <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-danger rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" @click="show = false">
        <span class="sr-only">Close</span>
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
      </button>
    </div>

    <div v-show="verificationLinkSent" id="alert-3" class="flex p-4 mb-4 text-success border border-green-500 rounded-lg bg-green-50" role="alert">
      <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
      <span class="sr-only">Info</span>
      <div class="ml-3 text-sm font-medium">
        A new verification link has been sent to your email address.
      </div>
    </div>
  </div>
</template>
