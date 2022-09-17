<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'
import { Disclosure, DisclosureButton, DisclosurePanel, RadioGroup, RadioGroupLabel, RadioGroupOption, Tab,TabGroup, TabList, TabPanel, TabPanels,} from '@headlessui/vue'
import { ChevronRightIcon, InformationCircleIcon } from '@heroicons/vue/solid'
import { LinkIcon, MinusIcon, PlusIcon } from '@heroicons/vue/outline'
import { Link, useForm } from '@inertiajs/inertia-vue3'
import DialogModal from '../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/DialogModal.vue'
const props = defineProps({
  product: Object,
});

const requestModal = ref(false)
const submitRequest = (id) => {
  const form = useForm({
    product_id : id
  })
  form.post(route('marketplace.request'), {
    preserveScroll : true,
    onSuccess : () => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        timer: 5000,
        showConfirmButton: false,
        timerProgressBar: true,
        icon: 'success',
        title: 'Product requested successfully. ',
      })
    },
    onError : () => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        timer: 5000,
        showConfirmButton: false,
        timerProgressBar: true,
        icon: 'error',
        title: 'We encountered an error',
      })
    }
  })
}

const selectedColor = ref(props.product.colors[0])

const filterDuplicateData = (arr) => {
  return arr.filter(function (value, index, array) {
    return array.indexOf(value) === index;
  });
}

</script>

<template>
  <AppLayout :title="product.name">
    <template #page-header>
      <nav aria-label="Breadcrumb" class="mt-8">
        <ol role="list" class="max-w-2xl mx-auto flex items-center space-x-2 sm:px-6 lg:max-w-7xl lg:px-8">
          <li>
            <div class="flex items-center">
              <Link :href="route('marketplace.index')" class="mr-2 text-sm font-medium text-gray-900">
                Marketplace
              </Link>
              <ChevronRightIcon class="w-5 h-5 text-gray-400"/>
            </div>
          </li>
          <li class="text-sm">
            <Link :href="product.href" aria-current="page"
              class="font-medium text-gray-500 hover:text-gray-600">
              {{ product.name }}
            </Link>
          </li>
        </ol>
      </nav>
    </template>

    <template #content>
      <div class="bg-slate-100">
        <div class="max-w-2xl mx-auto sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
          <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
            <!-- Image gallery -->
            <TabGroup as="div" class="flex flex-col-reverse">
              <!-- Image selector -->
              <div class="hidden mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
                <TabList class="grid grid-cols-4 gap-6">
                  <Tab v-for="(image, index) in product.gallery" :key="index"
                    class="relative h-24 bg-white rounded-md flex items-center justify-center text-sm font-medium uppercase text-gray-900 cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring focus:ring-offset-4 focus:ring-opacity-50"
                    v-slot="{ selected }">
                    <span class="sr-only">
                      <!-- {{ image.name }} -->
                    </span>
                    <span class="absolute inset-0 rounded-md overflow-hidden">
                      <img :src="image.url" alt="" class="w-full h-full object-center object-cover" />
                    </span>
                    <span
                      :class="[selected ? 'ring-primary-500' : 'ring-transparent', 'absolute inset-0 rounded-md ring-2 ring-offset-2 pointer-events-none']"
                      aria-hidden="true" />
                  </Tab>
                </TabList>
              </div>

              <TabPanels class="w-full aspect-w-1 aspect-h-1">
                <TabPanel v-for="(image, index) in product.gallery" :key="index">
                  <img :src="image.url" class="w-full h-full object-center object-cover sm:rounded-lg" />
                </TabPanel>
              </TabPanels>
            </TabGroup>

            <!-- Product info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
              <h1 class="text-3xl font-extrabold tracking-tight text-primary-800">{{ product.name }}
              </h1>
              <div class="mt-3 border-t border-gray-200">
                <h2 class="sr-only">Product information</h2>
                <div class="text-xl border-b border-gray-200 mt-4">Price :
                  <span class=" text-primary-700 font-bold"> {{ product.recommanded_price + ' SAR'}}</span>
                </div>
                <div class="text-xl border-b border-gray-200 mt-4"> Commission :
                  <span class=" text-primary-700 font-bold"> {{'$'+product.commission }}</span>
                </div>
              </div>

              <div class="mt-4">
                <h3 class="sr-only">Description</h3>
                <div class="text-base text-gray-700 space-y-6" v-html="product.description" />
              </div>

              <div class="mt-6">
                <!-- Colors -->
                <!-- <div>
                  <h3 class="text-md text-gray-600">Colors</h3>

                  <RadioGroup v-model="selectedColor" class="mt-2">
                    <RadioGroupLabel class="sr-only"> Choose a color </RadioGroupLabel>
                    <span class="flex items-center space-x-3">
                      <RadioGroupOption as="template" v-for="(color, index) in product.colors" :key="index" :value="color.color"
                        v-slot="{ active, checked }">
                        <div
                          :class="[color.selectedColor, active && checked ? 'ring ring-offset-1' : '', !active && checked ? 'ring-2' : '', '-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none']">
                          <RadioGroupLabel as="span" class="sr-only">
                            {{ color.color }}
                          </RadioGroupLabel>
                          <span aria-hidden="true" :style="'background-color:' + color.color"
                            :class="['h-8 w-8 border border-black border-opacity-10 rounded-full']" />
                        </div>
                      </RadioGroupOption>
                    </span>
                  </RadioGroup>

                  <div class="mt-10">
                    <RadioGroup class="mt-4">
                      <RadioGroupLabel class="sr-only"> size </RadioGroupLabel>
                      <div class="grid grid-cols-4 gap-4 sm:grid-cols-8 lg:grid-cols-4">
                        <RadioGroupOption as="template" v-for="(size, index) in product.sizes" :key="index" :value="size.size"
                          :disabled="!size.inStock" v-slot="{ active, checked }">
                          <div
                            :class="[size ? 'bg-white shadow-sm text-gray-900 cursor-pointer' : 'bg-gray-50 text-gray-200 cursor-not-allowed', active ? 'ring-2 ring-primary-500' : '', 'group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6']">
                            <RadioGroupLabel as="span">
                              {{ size.size }}
                            </RadioGroupLabel>
                            <span v-if="size"
                              :class="[active ? 'border' : 'border-2', checked ? 'border-primary-500' : 'border-transparent', 'absolute -inset-px rounded-md pointer-events-none']"
                              aria-hidden="true" />
                            <span v-else aria-hidden="true"
                              class="absolute -inset-px rounded-md border-2 border-gray-200 pointer-events-none">
                              <svg class="absolute inset-0 w-full h-full text-gray-200 stroke-2" viewBox="0 0 100 100"
                                preserveAspectRatio="none" stroke="currentColor">
                                <line x1="0" y1="100" x2="100" y2="0" vector-effect="non-scaling-stroke" />
                              </svg>
                            </span>
                          </div>
                        </RadioGroupOption>
                      </div>
                    </RadioGroup>
                  </div>
                </div> -->

                <div class="mt-10 flex sm:flex-col1 justify-between">
                  <button type="button" v-on:click="requestModal = true" v-if="product.exist_request == null"
                    class="max-w-xs flex-1 bg-primary-700 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-primary-500 sm:w-full">
                    Request
                  </button>
                  <div v-else>
                    <span class="text-success" v-if="product.exist_request.status == 'access'"> You have access to this product </span>
                    <span class="text-danger" v-if="product.exist_request.status == 'denied'"> You don't have access to this product</span>
                    <span class="bg-primary-600 border border-transparent rounded-md py-3 px-8 text-white" v-if="product.exist_request.status == 'request'"> You requested this product...</span>
                  </div>
                  <div class="flex items-center">
                    <LinkIcon class="w-5 h-5 text-gray-400"/>
                    <a target="_blank" class="text-md gp lm text-primary-500 xh nq" :href="product.link">See Product</a>
                  </div>
                </div>

                <div class="divide-y divide-gray-200 border-t mt-4">
                  <Disclosure as="div" v-slot="{ open }" :defaultOpen="true">
                    <h3>
                      <DisclosureButton class="group relative flex w-full items-center justify-between py-6 text-left">
                        <span :class="[open ? 'text-primary-600' : 'text-gray-900', 'text-sm font-medium']">Available countries</span>
                        <span class="ml-6 flex items-center">
                          <PlusIcon v-if="!open" class="block h-6 w-6 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                          <MinusIcon v-else class="block h-6 w-6 text-primary-400 group-hover:text-primary-500" aria-hidden="true" />
                        </span>
                      </DisclosureButton>
                    </h3>
                    <DisclosurePanel as="div" class="prose prose-sm pb-6">
                      <ul role="list">
                        <li v-for="(country, index) in product.countries" :key="index">{{ country.country+ ' : '+ country.qty + ' pieces' }}</li>
                      </ul>
                    </DisclosurePanel>
                  </Disclosure>
                </div>

                <DialogModal :show="requestModal" >
                  <template #content>
                    <div class="dz flex fy">
                      <!-- Icon -->
                      <div class="od sy rounded-full flex items-center justify-center ub hl">
                        <InformationCircleIcon class="text-primary-500 w-5"/>
                      </div>
                      <!-- Content -->
                      <div>
                        <!-- Modal header -->
                        <div class="ru">
                          <div class="ga gh text-primary-800">Send Request for <span class="font-weight">{{
                            product.name
                          }}</span></div>
                        </div>
                        <!-- Modal content -->
                        <div class="text-sm nx">
                          <div class="fb">
                            <p>You are about to launch for this product. Your request will be processed before being
                              validated or declined.
                               <!-- You will receive an email after the response from our technicalteam. -->
                              </p>
                          </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex flex-wrap justify-end fc">
                          <button class="r border-slate-200 hover--border-slate-300 g_"
                            v-on:click="requestModal = false">Cancel</button>
                          <button class="r ho xi ye bg-primary-700 hover:bg-primary-600"
                            v-on:click="submitRequest(product.id), requestModal = false">Yes, Create it</button>
                        </div>
                      </div>
                    </div>
                  </template>
                </DialogModal>
              </div>

            </div>
          </div>
        </div>

      </div>
    </template>
  </AppLayout>
</template>
