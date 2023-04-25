<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, } from 'vue';
import { Link, useForm } from '@inertiajs/inertia-vue3'
import { InformationCircleIcon, PencilAltIcon, DocumentDuplicateIcon } from '@heroicons/vue/solid';
import useClipboard from 'vue-clipboard3'
import Pagination from '@/Components/Pagination.vue';
import { auth } from '../Permissions';

const props = defineProps({
  products: Object,
});

const filters = ref({
  all: { value: '', keys: ['name', 'sku'] }
})

const showLinkModal = ref(false)

const linkForm = useForm({
  product: '',
  link : '',
  product_id : '',
})

const getLinkModal = (product) => {
  showLinkModal.value = true
  linkForm.product = product.name
  linkForm.link = product.link
  linkForm.product_id = product.id
}

const updateLink = () => {
  linkForm.put(route('products.update_link'), {
    preserveScroll: true,
    onSuccess : () => {
      showLinkModal.value= false,
      Swal.fire({
        toast: true,
        position: 'top-end',
        timer: 5000,
        showConfirmButton: false,
        timerProgressBar: true,
        icon: 'success',
        title: 'Link updated.',
      }),
      linkForm.reset()
    }
  })
}
 const { toClipboard } = useClipboard()

const copyToClipboard = async (value) =>{
  try {
    await toClipboard(value)
    console.log('Copied to clipboard')
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
                  <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ product.recommanded_price+' SAR' }}</td>
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
                    <button class="btn-primary" v-if="!product.link" @click="getLinkModal(product)">set Link</button>
                    <button class="btn-primary" v-else @click="getLinkModal(product)"><PencilAltIcon class="w-5"/></button>
                  </td>

                  <td class="whitespace-nowrap py-4 pl-6 pr-4 text-sm font-medium text-gray-500">
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

      <div id="info-modal" v-show="showLinkModal" class="m w tx la flex items-center np justify-center vs jj"
        role="dialog" aria-modal="true">
        <div class="bg-white rounded bd lu up ou oe">
          <div class="dz flex fy">
            <div class="od sy rounded-full flex items-center justify-center ub hl">
              <InformationCircleIcon class="text-primary-500 w-5"/>
            </div>
            <div>
              <div class="ru">
                <div class="ga gh text-primary-800">Update Link for<span class="font-weight">{{linkForm.product}}</span></div>
              </div>
              <div class="text-sm nx">
                <div class="fb">
                  <textarea class="w-full border-slate-200 rounded focus:border-primary-400" v-model="linkForm.link"></textarea>
                  <div class="text-danger" v-if="linkForm.errors.link">{{ linkForm.errors.link }}</div>
                </div>
              </div>
              <div class="flex flex-wrap justify-end fc">
                <button class="r border-slate-200 hover--border-slate-300 g_" v-on:click="showLinkModal = false">Cancel</button>
                <a :href="linkForm.link" target="_blank" class="bg-gray-300 r ye hover:bg-gray-200" v-if="linkForm.link != null">Open Link</a>
                <button class="r ho xi ye bg-primary-700 hover:bg-primary-600" v-on:click="updateLink()">Update Link</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </AppLayout>
</template>
