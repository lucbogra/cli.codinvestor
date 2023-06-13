<script setup>
  import AppLayout from '@/Layouts/AppLayout.vue'
  import { PaperClipIcon } from '@heroicons/vue/outline';
import { computed } from 'vue';
  const props = defineProps({
    invoice: Object,
  });

  const products_amount = computed(() => props.invoice.products.map((el) => el.amount).reduce((a,b) => a + b, 0))
  const fundings_amount = computed(() => props.invoice.fundings.map((el) => el.pivot.amount_paid).reduce((a,b) => a + b, 0))
  const integration_amount = computed(() => props.invoice.integrationPayment.map((el) => el.pivot.amount_paid).reduce((a,b) => a + b, 0))

  </script>
  <template>
    <AppLayout title="Invoice">
      <template #page-header>
        <div class="mt-2 p-5 mx-10">
          <div class=" flex justify-between mb-5">
            <h1 class="gu teu text-primary-800 font-bold">Invoice #{{invoice.slug}}</h1>
            <!-- <input name="" class="a ou rounded-full w-52 hidden sm:block" placeholder="search..." v-model="filters.all.value"/> -->
          </div>
        </div>
      </template>
      <template #content>
        <div class="vs jj ttm vl ou uf na -mt-12">
          <div class="bg-white overflow-x-auto rounded-lg border-slate-200">
            <div class="overflow-hidden">
              <VTable :data="invoice.products" class="min-w-full bg-gray-50">
                <template #head>
                  <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Product</th>
                    <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Commission</th>
                  </tr>
                </template>
                <template #body="{ rows }">
                  <tr v-for="(product, index) in rows" :key="index" class="border-t border-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                      <div class="flex items-center">
                        <div class="h-10 w-10 flex-shrink-0">
                          <img class="h-10 w-10" :src="product.photo" alt="" />
                        </div>
                        <div class="ml-4">
                          <div class="font-medium text-gray-900">{{ product.name }}</div>
                          <div class="text-gray-500">{{ product.sku }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ product.amount+' USD' }}</td>
                  </tr>
                  <tr>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-bold text-gray-900"> Total</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-bold text-gray-900">{{ products_amount+' USD' }}</td>
                  </tr>
                  <tr v-if="rows.length === 0">
                   <td class="border-t px-3 py-4" colspan="6">No product found.</td>
                  </tr>
                </template>
              </VTable>
            </div>
          </div>

          <div class="bg-white overflow-x-auto rounded-lg border-slate-200 mt-4" v-if="invoice.fundings.length !== 0">
            <div class="overflow-hidden">
              <VTable :data="invoice.fundings" class="min-w-full bg-gray-50">
                <template #head>
                  <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Funding</th>
                    <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Paid amount</th>
                  </tr>
                </template>
                <template #body="{ rows }">
                  <tr v-for="(funding, index) in rows" :key="funding.slug" class="border-t border-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                      {{ funding.slug }}
                   </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> - {{ funding.pivot.amount_paid+' USD' }}</td>
                  </tr>
                  <tr>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-bold text-gray-900"> Total</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-bold text-gray-900">- {{ fundings_amount+' USD' }}</td>
                  </tr>
                  <tr v-if="rows.length === 0">
                   <td class="border-t px-3 py-4" colspan="6">No funding found.</td>
                  </tr>
                </template>
              </VTable>
            </div>
          </div>
         
          
          <div class="bg-white overflow-x-auto rounded-lg border-slate-200 mt-4" v-if="invoice.integrationPayment.length !== 0">
            <div class="overflow-hidden">
              <VTable :data="invoice.integrationPayment" class="min-w-full bg-gray-50">
                <template #head>
                  <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Integration Name</th>
                    <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Paid amount</th>
                  </tr>
                </template>
                <template #body="{ rows }">
                  <tr v-for="(payment, index) in rows" :key="payment.id" class="border-t border-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                      {{ payment.payment_info }}
                   </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> - {{ payment.pivot.amount_paid+' USD' }}</td>
                  </tr>
                  <tr>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-bold text-gray-900"> Total</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-bold text-gray-900">- {{ integration_amount+' USD' }}</td>
                  </tr>
                  <tr v-if="rows.length === 0">
                   <td class="border-t px-3 py-4" colspan="6">No Integration found.</td>
                  </tr>
                </template>
              </VTable>
            </div>
          </div>
          <div class="bg-white overflow-x-auto rounded-lg border-slate-200 mt-4" v-if="invoice.status === 'pending'">
            <div class="overflow-hidden">
              <table class="min-w-full bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Payments</th>
                    <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Paid amount</th>
                  </tr>
               
                  <tr class="border-t border-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                      Your Commission
                   </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> + {{ products_amount+' USD' }}</td>
                  </tr>

                  <tr v-if="invoice.integrationPayment.length !== 0" v-for="payment in invoice.integrationPayment" :key="payment.id" class="border-t border-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                      {{ payment.payment_info }}
                   </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> - {{ payment.pivot.amount_paid+' USD' }}</td>
                  </tr>

                  <tr v-if="invoice.fundings.length !== 0" v-for="funding in invoice.fundings" :key="funding.slug" class="border-t border-gray-200 bg-white hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                      {{ funding.slug }}
                   </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> - {{ funding.pivot.amount_paid+' USD' }}</td>
                  </tr>
                  
                  <tr>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-bold text-gray-900"> Total</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-bold text-gray-900"> {{ (products_amount - integration_amount-fundings_amount)+' USD' }}</td>
                  </tr>
              </table>
            </div>
          </div>


        <div class="mt-6 bg-white px-2 py-4 rounded-lg" v-if="invoice.paid_date != null">
          <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">#{{ invoice.slug }}</h3>
            <p class="mt-1 max-w-2xl text-sm text-green-500">Invoice paid.</p>
          </div>
          <div class="mt-5 border-t border-gray-200">
            <dl class="sm:divide-y sm:divide-gray-200">
              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Created at</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ invoice.created_at }}</dd>
              </div>
              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Email address</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ invoice.email }}</dd>
              </div>
              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Amount</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ invoice.amount }}</dd>
              </div>
              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">payment recorded on</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ invoice.paid_date }}</dd>
              </div>
              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ invoice.payment_method }}</dd>
              </div>
              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Attachments</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                  <ul role="list" class="divide-y divide-gray-200 rounded-md border border-gray-200">
                    <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                      <div class="flex w-0 flex-1 items-center">
                        <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                        <span class="ml-2 w-0 flex-1 truncate">file</span>
                      </div>
                      <div class="ml-4 flex-shrink-0">
                        <a :href="invoice.file_url" target="_blank" class="font-medium text-primary-600 hover:text-primary-500">Download</a>
                      </div>
                    </li>
                  </ul>
                </dd>
              </div>
            </dl>
          </div>
        </div>

        
        </div>

      </template>
    </AppLayout>
  </template>
