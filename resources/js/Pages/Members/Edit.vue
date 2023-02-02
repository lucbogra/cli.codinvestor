<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import Layout from '../Setting/Layout.vue';
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import LoadingButton from '@/Components/LoadingButton.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  member : Object
})
const form = useForm({
  user_id : props.member.user.id,
  name: props.member.user.name,
  email: props.member.user.email,
  type: 'infos'
});

const passwordForm = useForm({
  user_id : props.member.user.id,
  password: '',
  confirm_password: '',
  type: 'password'
})

const store = () => {
  form.put(route("members.update", props.member.id), {
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

const updatePassword = () => {
  passwordForm.put(route("members.update", props.member.id), {
    errorBag: "update",
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
      }),
        passwordForm.reset()
    },
  });
}

const destroy = () => {
  if (confirm('Are you sure you want to delete this member ?')) {
    Inertia.delete(route('members.destroy', props.member.id))
  }
}
</script>

<template>
  <Layout title="Company">
    <div class="max-w-6xl bg-white mx-auto sm:px-6 lg:px-8 p-8 ">
      <div class="sm:flex-auto mb-4">
        <h1 class="text-xl font-semibold text-gray-900">Member</h1>
        <p class="mt-2 text-sm text-gray-700">Update Member</p>
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
        </div>
        <div class="px-8 lg:-mx-8 py-4 -mb-8 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button"
            @click="destroy">Delete Member</button>
          <LoadingButton :loading="form.processing" class="btn-primary" type="submit">Update</LoadingButton>
        </div>

      </form>
    </div>

    <div class="max-w-6xl bg-white mx-auto sm:px-6 lg:px-8 p-8 mt-12">
      <form @submit.prevent="updatePassword" class="">
        <div class="flex flex-wrap">
          <div class="lg:w-1/2 pr-6 pb-8">
            <JetLabel for="password" value="password" />
            <JetInput id="password" v-model="passwordForm.password" type="password" class="mt-1 block w-full" />
            <JetInputError :message="passwordForm.errors.password" class="mt-2" />
          </div>
          <div class="lg:w-1/2 pr-6 pb-8">
            <JetLabel for="confirm_password" value="confirm password" />
            <JetInput id="confirm_password" v-model="passwordForm.confirm_password" type="password"
              class="mt-1 block w-full" />
            <JetInputError :message="passwordForm.errors.confirm_password" class="mt-2" />
          </div>
        </div>
        <div class="px-8 lg:-mx-8 py-4 -mb-8 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <LoadingButton :loading="passwordForm.processing" class="btn-primary" type="submit">Update password
          </LoadingButton>
        </div>
      </form>
    </div>
  </Layout>
</template>
