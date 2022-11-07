<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import currencies from '@/Components/Currencies'
import countries from '@/Components/Countries'
import LoadingButton from '../../Components/LoadingButton.vue';
import InputError from '@/Jetstream/InputError.vue';
import { Switch } from '@headlessui/vue'

const props = defineProps({
  datas : Object,
  defaultMethod: String
})
const form = useForm({
  type : 'Payoneer',
  account_type : props.datas.account_type,
  account_number : props.datas.account_number,
  email : props.datas.email,
  account_holder : props.datas.account_holder,
  routing_number : props.datas.routing_number,
  address : props.datas.address,
  account_currency : props.datas.account_currency,
  country : props.datas.country,
  default : props.defaultMethod == 'Payoneer' ? true : false,
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
          <h3 class="text-lg font-medium leading-6 text-gray-900">Payoneer</h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">All fields will be required if this is your default payment method.</p>
        </div>
        <div class="">
          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1">
            <label for="account_type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Account type</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="text" name="account_type" id="account_type" v-model="form.account_type" placeholder="Account type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
              <InputError :message="form.errors.account_type" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1">
            <label for="account_number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Account Number</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="text" name="account_number" id="account_number" v-model="form.account_number" placeholder="Account number" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
              <InputError :message="form.errors.account_number" class="mt-2" />
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
            <label for="account_holder" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Account Holder</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input id="account_holder" name="account_holder" type="text" v-model="form.account_holder" placeholder="Account Holder" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.account_holder" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1">
            <label for="routing_number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Routing Number</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input id="routing_number" name="routing_number" type="text" v-model="form.routing_number" placeholder="Routing Number" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.routing_number" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1 0">
            <label for="account_currency" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> Account Currency</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <select id="account_currency" name="account_currency" v-model="form.account_currency" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                <option></option>
                <option v-for="currency in currencies" :key="code" :value="currency.name">{{ currency.name }}</option>
              </select>
               <InputError :message="form.errors.account_currency" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1">
            <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Country</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <select id="country" name="country" v-model="form.country" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                <option></option>
                <option v-for="country in countries" :key="code" :value="country.name">{{ country.name }}</option>
              </select>
               <InputError :message="form.errors.country" class="mt-2" />
            </div>
          </div>

          <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4  sm:py-5 px-1 0">
            <label for="address" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Adress</label>
            <div class="mt-1 sm:col-span-2 sm:mt-0">
              <input type="text" name="address" id="address" v-model="form.address" placeholder="Address" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" />
               <InputError :message="form.errors.address" class="mt-2" />
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
