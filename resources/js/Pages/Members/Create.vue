<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Layout from '../Setting/Layout.vue';
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import LoadingButton from '@/Components/LoadingButton.vue';

const form = useForm({
  name: '',
  email: '',
  phone: '',
  password: '',
  confirm_password: '',
});

const store = () => {
  form.post(route("members.store"), {
    errorBag: "store",
    preserveScroll: true,
    onSuccess: () => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true,
        icon: 'success',
        title: usePage().props.value.flash.success,
      })
    },
  });
}
</script>

<template>
  <Layout title="Company">
    <div class="max-w-6xl bg-white mx-auto sm:px-6 lg:px-8 p-8 ">
      <div class="sm:flex-auto mb-4">
        <h1 class="text-xl font-semibold text-gray-900">Member</h1>
        <p class="mt-2 text-sm text-gray-700">Create new Member</p>
      </div>
      <form @submit.prevent="store" class="">
        <div class="flex flex-wrap">
          <div class="lg:w-1/2 pr-6 pb-8">
            <JetLabel for="name" value="Member name" />
            <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" />
            <JetInputError :message="form.errors.name" class="mt-2" />
          </div>
          <div class="lg:w-1/2 pr-6 pb-8">
            <JetLabel for="email" value="Email" />
            <JetInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" />
            <JetInputError :message="form.errors.email" class="mt-2" />
          </div>
          <div class="lg:w-1/2 pr-6 pb-8">
            <JetLabel for="password" value="Password" />
            <JetInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" />
            <JetInputError :message="form.errors.password" class="mt-2" />
          </div>

          <div class="lg:w-1/2 pr-6 pb-8">
            <JetLabel for="confirm_password" value="Confirm password" />
            <JetInput id="confirm_password" v-model="form.confirm_password" type="password" class="mt-1 block w-full" />
            <JetInputError :message="form.errors.confirm_password" class="mt-2" />
          </div>

        </div>
        <div class="px-8 lg:-mx-8 py-4 -mb-8 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <LoadingButton :loading="form.processing" class="btn-primary" type="submit">Create</LoadingButton>
        </div>

      </form>
    </div>
  </Layout>
</template>
