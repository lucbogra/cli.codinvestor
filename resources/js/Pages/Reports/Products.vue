<script setup>
const props = defineProps({
  products : Object,
})

</script>

<template>
 <div class="shadow-xl rounded-xl mb-8 ">
  <div class="bg-white rounded-lg border-slate-200">
    <div class="">
      <VTable :data="products.data" class="min-w-full table-fixed bg-gray-50">
        <template #head>
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Product</th>
            <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Uploaded</th>
            <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Processed</th>
            <!-- <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">duplicate</th>
            <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Wrong Number</th> -->
            <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Confirmed</th>
            <th class="px-3 py-3.5 text-sm text-left font-semibold text-gray-900">Delivered</th>
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
            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ product.uploaded }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ product.processed }}</td>
            <!-- <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ product.duplicate }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ product.wrong_number }} </td> -->
            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ product.confirmed }} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ product.delivered }} </td>
            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-500"> {{ '$'+product.commission }} </td>

          </tr>
          <tr v-if="rows.length === 0">
            <td class="border-t px-3 py-4" colspan="6">No product found.</td>
          </tr>
        </template>
      </VTable>

    </div>
  </div>
  <!-- Pagination -->
  <slot name="pagination"/>

</div>

</template>
