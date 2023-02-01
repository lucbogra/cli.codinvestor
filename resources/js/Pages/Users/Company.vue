<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Layout from '../Setting/Layout.vue';
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import LoadingButton from '@/Components/LoadingButton.vue';

const props = defineProps({
  investor : Object
})

const form = useForm({
  company : props.investor.company,
  phone : props.investor.phone,
  address : props.investor.address,
  city : props.investor.city,
  zip : props.investor.zip,
  country : props.investor.country,
  website : props.investor.website
})

const update = () => {
  form.put(route("users.company.update"), {
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
      })
    },
  });
}
</script>

<template>
  <Layout title="Company">
    <div class="max-w-6xl bg-white mx-auto sm:px-6 lg:px-8 p-8 ">
      <div class="sm:flex-auto mb-4">
        <h1 class="text-xl font-semibold text-gray-900">Company</h1>
        <p class="mt-2 text-sm text-gray-700">Update your campany informations</p>
      </div>
      <form @submit.prevent="update" class="">
        <div class="flex flex-wrap">
          <div class="lg:w-1/2 pr-6 pb-8">
            <JetLabel for="company" value="Company name" />
            <JetInput id="company" v-model="form.company" type="text" class="mt-1 block w-full" />
            <JetInputError :message="form.errors.company" class="mt-2" />
          </div>
          <div class="lg:w-1/2 pr-6 pb-8">
            <JetLabel for="phone" value="Phone" />
            <JetInput id="phone" v-model="form.phone" type="text" class="mt-1 block w-full" />
            <JetInputError :message="form.errors.phone" class="mt-2" />
          </div>

          <div class="lg:w-full pr-6 pb-8">
            <JetLabel for="address" value="Address" />
            <JetInput id="address" v-model="form.address" type="text" class="mt-1 block w-full" />
            <JetInputError :message="form.errors.address" class="mt-2" />
          </div>

          <div class="lg:w-1/2 pr-6 pb-8">
            <JetLabel for="country" value="Country" />
            <JetInput id="country" v-model="form.country" type="text" class="mt-1 block w-full" />
            <JetInputError :message="form.errors.country" class="mt-2" />
          </div>

          <div class="lg:w-1/2 pr-6 pb-8">
            <JetLabel for="city" value="City" />
            <JetInput id="city" v-model="form.city" type="text" class="mt-1 block w-full" />
            <JetInputError :message="form.errors.city" class="mt-2" />
          </div>

          <div class="lg:w-full pr-6 pb-8">
            <JetLabel for="website" value="Website" />
            <JetInput id="website" v-model="form.website" type="text" class="mt-1 block w-full" />
            <JetInputError :message="form.errors.website" class="mt-2" />
          </div>

        </div>
        <div class="px-8 lg:-mx-8 py-4 -mb-8 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <LoadingButton :loading="form.processing" class="btn-primary" type="submit">Update</LoadingButton>
        </div>

      </form>
    </div>
  </Layout>
</template>
