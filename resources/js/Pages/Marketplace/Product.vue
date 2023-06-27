<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, } from 'vue';
import { Link, useForm } from '@inertiajs/inertia-vue3'
import { InformationCircleIcon, PencilAltIcon, DocumentDuplicateIcon, LinkIcon } from '@heroicons/vue/solid';
import useClipboard from 'vue-clipboard3'
import Pagination from '@/Components/Pagination.vue';
import { auth } from '../Permissions';
import DialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';

const props = defineProps({
  products: Object,
});

const filters = ref({
  all: { value: '', keys: ['name', 'sku'] }
})

const showModal = ref(false)

const form = useForm({
  product: '',
  link : '',
  product_id : '',
  pricings : [],
  commission : '',
})

const getLinkModal = (product) => {
  showModal.value = true
  form.product = product.name
  form.link = product.link
  form.product_id = product.id
  form.commission = product.commission
  form.pricings = product.pricings
}

const update = () => {
  form.put(route('products.update'), {
    preserveScroll: true,
    onSuccess : () => {
      showModal.value= false,
      Swal.fire({
        toast: true,
        position: 'top-end',
        timer: 5000,
        showConfirmButton: false,
        timerProgressBar: true,
        icon: 'success',
        title: 'Link updated.',
      }),
      form.reset()
    }
  })
}
 const { toClipboard } = useClipboard()

const copyToClipboard = async (value) =>{
  try {
    await toClipboard(value)
    // console.log('Copied to clipboard')
  } catch (e) {
    console.error(e)
  }
}

</script>
<template>
  <AppLayout title="Products">
    <template #page-header>
      <div class="mt-2 p-5 mx-10">
        <div class=" flex justify-between mb-5">
          <h1 class="gu teu text-primary-800 font-bold">Products( {{ products.total }})</h1>
          <input name="" class="a ou rounded-full w-52 hidden sm:block" placeholder="search..." v-model="filters.all.value"/>
        </div>
      </div>
    </template>
    <template #content>
      <div class="vs jj ttm vl ou uf na -mt-12">
        <div class="bg-white overflow-x-auto rounded-lg border-slate-200">
          <div class="overflow-hidden">
            <VTable :data="products.data" :filters="filters" class="min-w-full bg-gray-50">
              <template #head>
                <tr>
                  <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Product</th>
                  <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Price</th>
                  <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900" v-if="auth.hasRole('Investor')" >Commission</th>
                  <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Categories</th>
                  <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Link</th>
                  <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Actions</th>
                </tr>
              </template>
              <template #body="{ rows }">
                <tr v-for="(product, index) in rows" :key="product.slug" class="border-t border-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                    <div class="flex items-center">
                      <div class="h-10 w-10 flex-shrink-0">
                        <img class="h-10 w-10" :src="product.photo" alt="" />
                      </div>
                      <div class="ml-4">
                        <div class="font-medium text-gray-900">{{ product.name }}</div>
                        <div class="text-gray-500">{{ product.sku }}</div>
                      </div>
                      <div class="ml-4">
                        <button @click="copyToClipboard(product.sku)"><DocumentDuplicateIcon class="text-gray-400 w-5" /></button>
                      </div>
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ product.price+' SAR' }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500" v-if="auth.hasRole('Investor')"> {{ '$'+product.commission}}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500">
                    <div class="flex flex-wrap items-left">
                      <span v-for="category in product.categories"
                        class="items-center inline-flex ml-2 bg-primary-500 p-1 rounded-full mb-1 text-sm text-white" tabindex="-1">
                        {{ category }}
                      </span>
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm font-medium">
                    <a v-if="product.link" :href="product.link" target="_blank" ><LinkIcon class="w-5 h-5 text-primary-600 hover:text-primary-400"/></a>
                  </td>

                  <td class="whitespace-nowrap py-4 pl-6 pr-4 text-sm font-medium text-gray-500">
                    <button class="btn-primary" @click="getLinkModal(product)">Edit</button>
                  </td>

                </tr>
                <tr v-if="rows.length === 0">
                 <td class="border-t px-3 py-4" colspan="6">No product found.</td>
                </tr>
              </template>
            </VTable>

          </div>
        </div>
        <Pagination class="mt-6" :links="products.links" />
      </div>

      <DialogModal :show="showModal" >
        <template #title>
            Edit Product
        </template>
        <template #content>
          Set Link for {{ form.product }} and choice your commission (your commission depends on the selling price of the product. So please choose the commission corresponding to the price you use)

          <div class="mt-4">
            <textarea class="w-full border-slate-200 rounded focus:border-primary-400" v-model="form.link"></textarea>
            <JetInputError :message="form.errors.link" class="mt-2" />
          </div>
          <div class="mt-4">
            <select class="w-full border-slate-200 rounded focus:border-primary-400" v-model="form.commission">
              <option v-for="(item, index) in form.pricings" :value="item">{{ 'price: '+item.price+'SAR'+ ', commission: $'+item.commission }}</option>
            </select>
            <JetInputError :message="form.errors.commission" class="mt-2" />
          </div>
        </template>
        <template #footer>
          <div class="flex flex-wrap justify-end fc">
              <button class="r border-slate-200 hover--border-slate-300 g_" v-on:click="showModal = false">Cancel</button>
              <button class="r ho xi ye bg-primary-700 hover:bg-primary-600" v-on:click="update()">Update</button>
          </div>
        </template>
      </DialogModal>
    </template>
  </AppLayout>
</template>
