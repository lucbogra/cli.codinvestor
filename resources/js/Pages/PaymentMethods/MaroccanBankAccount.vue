<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import LoadingButton from '../../Components/LoadingButton.vue';
import InputError from '@/Jetstream/InputError.vue';
import { Switch } from '@headlessui/vue'

const props = defineProps({
  datas : Object,
  defaultMethod: String
})
const form = useForm({
  type : 'Maroccan Bank Account',
  account_type : props.datas.account_type,
  email : props.datas.email,
  bank_name : props.datas.bank_name,
  account_owner_name : props.datas.account_owner_name,
  iban : props.datas.iban,
  address : props.datas.address,
  city : props.datas.city,
  zip_code : props.datas.zip_code,
  rib : props.datas.rib,
  swift_code : props.datas.swift_code,
  default : props.defaultMethod == 'Maroccan Bank Account' ? true : false,
})

const submit = () => {
  form.put(route('billing.update'), {
    preserveState : false,
    onSuccess : () => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true,
        icon: 'success',
        title: usePage().props.value.flash.success,
      })
    }
  })
}
</script>
<template>
  <form @submit.prevent="submit" class="space-y-8 divide-y divide-gray-200 bg-white rounded px-8 py-6">
    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">

      <div class="space-y-6 pt-8 sm:space-y-5 sm:pt-10">
        <div>
          <h3 class="text-lg font-medium leading-6 text-gray-900">Maroccan Bank Account</h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">All fields will be required if this is your default payment method.</p>
        </div>
        <div class="">
          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1">
            <label for="account_type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Account type</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <select id="account_type" name="account_type" v-model="form.account_type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                <option></option>
                <option :value="'personnal'">Personnal</option>
                <option :value="'business'">Business</option>
              </select>
              <InputError :message="form.errors.account_type" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1 0">
            <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">email</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="email" name="email" id="email" v-model="form.email" placeholder="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.email" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1">
            <label for="bank_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Bank Name</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input id="bank_name" name="bank_name" type="text" v-model="form.bank_name" placeholder="Bank Name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.bank_name" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1">
            <label for="account_owner_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Account Owner Name</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="text" name="account_owner_name" id="account_owner_name" v-model="form.account_owner_name" placeholder="Account Owner Name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.account_owner_name" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1 0">
            <label for="iban" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">IBAN</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="text" name="iban" id="iban" v-model="form.iban" placeholder="IBAN" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.iban" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1">
            <label for="rib" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">RIB</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="text" name="rib" id="rib" v-model="form.rib" placeholder="RIB" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.rib" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1 0">
            <label for="swift_code" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Swift Code</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="text" name="swift_code" id="swift_code" v-model="form.swift_code" placeholder="Swift Code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.swift_code" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1 0">
            <label for="address" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Adress</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="text" name="address" id="address" v-model="form.address" placeholder="Address" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.address" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1">
            <label for="city" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">City</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="text" name="city" id="city" v-model="form.city" placeholder="City" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.city" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1 0">
            <label for="zip_code" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Zip code</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="text" name="zip_code" id="zip_code" v-model="form.zip_code" placeholder="Zip code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.zip_code" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1 0">
            <label for="zip_code" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Set as default</label>
            <Switch v-model="form.default" :class="form.default ? 'bg-teal-900' : 'bg-red-700'"
              class="relative mt-1 inline-flex flex-shrink-0 h-[38px] w-[74px] border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75">
              <span class="sr-only">Set as default</span>
              <span aria-hidden="true" :class="form.default ? 'translate-x-9' : 'translate-x-0'"
                class="pointer-events-none inline-block h-[34px] w-[34px] rounded-full bg-white shadow-lg transform ring-0 transition ease-in-out duration-200" />
            </Switch>
          </div>
        </div>
      </div>
    </div>
    <div class="pt-5">
      <div class="flex justify-end">
        <!-- <button type="button" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">Cancel</button> -->
        <LoadingButton :loading="form.processing" class="btn-primary ml-4" type="submit" >Save</LoadingButton>
      </div>
    </div>
  </form>
</template>
