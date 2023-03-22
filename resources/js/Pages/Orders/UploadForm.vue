<template>
<div>
  <form @submit.prevent="submitImport" enctype="multipart/form-data" class="lg:w-3/4">
    <div class="flex items-center flex-nowrap">
      <FileInput v-model="form.file" class="pr-6 pb-8 w-full lg:w-1/2" type="file" accept=".xlsx, .xls, .csv"
        label="file" />
      <LoadingButton :loading="form.processing" class="btn-primary ml-4" type="submit" :disabled="form.file === null">Import Orders</LoadingButton>
      <a class="ml-4 btn-white flex" :href="demo_file"><i class="fa-solid fa-download mr-1"></i> Download the demo file</a>
      <a class="ml-4 btn-danger flex" href="https://youtu.be/W9_f1KSU0rc" target="_blank" ><i class="fa-brands fa-youtube fa-beat mr-1" ></i>Demo</a>

    </div>
    <div class="mb-2">
      <div class="form-error" v-for="(err, index) in form.errors" :key="index">{{ err }}</div>
    </div>
  </form>
</div>
</template>
<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import FileInput from '@/Components/FileInput.vue';
import LoadingButton from '@/Components/LoadingButton.vue';

const props = defineProps({
  demo_file: String
})

const form = useForm({
  file: null,
})

const submitImport = () => {
  form.post('orders/import', {
    errorBag : 'import',
    preserveScroll : false,
    onSuccess: () => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true,
        icon: 'success',
        title: "Orders were uploaded successfully",
      }),
      form.reset()
    }
  })
}
</script>
