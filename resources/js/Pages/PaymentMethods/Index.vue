
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, computed, defineAsyncComponent, onMounted } from 'vue';
import { OfficeBuildingIcon, CreditCardIcon, LibraryIcon, CurrencyDollarIcon, CashIcon } from '@heroicons/vue/solid'
import MaroccanBankAccount from './MaroccanBankAccount.vue'
import Payoneer from './Payoneer.vue';
import Paypal from './Paypal.vue';
import TransferWise from './TransferWise.vue';

const props = defineProps({
  datas : Object,
})

const defaultMethod = JSON.parse(props.datas.datas).default.type
const tabs = [
  { name: 'Bank Account', href: '#', icon: LibraryIcon },
  { name: 'Maroccan Bank Account', href: '#', icon: OfficeBuildingIcon },
  { name: 'Payoneer', href: '#', icon: CurrencyDollarIcon },
  { name: 'Paypal', href: '#', icon: CreditCardIcon },
  { name: 'TransferWise', href: '#', icon: CashIcon },
]
onMounted(() => {
  console.log(JSON.parse(props.datas.datas).bank_account);
})
const selected = ref('Bank Account')
const colorx = ref('#0F7490')

const switchTab = (name) => {
  selected.value = name
}

const BankAccount = defineAsyncComponent(() =>
  import('./BankAccount.vue')
)

</script>
<template>
  <AppLayout title="Orders">
    <template #page-header>
      <div class="je jd jc ii mt-2 p-5 mx-10">
        <div class="ri _y">
          <h1 class="gu teu text-primary-800 font-bold">Billing Settings ✨</h1>
        </div>
      </div>
    </template>
    <template #content>

      <div class="px-8 py-16 sm:px-0 mx-10 -mt-12">
        <div class="mb-4">
          <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
            <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500">
              <option v-for="tab in tabs" :key="tab.name" :selected="tab.name== selected">{{ tab.name }}</option>
            </select>
          </div>
          <div class="hidden sm:block">
            <div class="border-b border-gray-200">
              <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a v-for="tab in tabs" :key="tab.name" :href="tab.href" @click="switchTab(tab.name)" :class="[tab.name == selected ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm']" :aria-current="tab.name == selected ? 'page' : undefined">
                  <component :is="tab.icon" :class="[tab.name == selected ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500', '-ml-0.5 mr-2 h-5 w-5']" aria-hidden="true" />
                  <span>{{ tab.name }}</span>
                </a>
              </nav>
            </div>
          </div>
        </div>
        <BankAccount v-if="selected == 'Bank Account'" :datas="JSON.parse(props.datas.datas).bank_account" :defaultMethod="defaultMethod" />
        <MaroccanBankAccount v-if="selected == 'Maroccan Bank Account'" :datas="JSON.parse(props.datas.datas).maroccan_bank_account" :default-method="defaultMethod" />
        <Payoneer v-if="selected == 'Payoneer'" :datas="JSON.parse(props.datas.datas).payoneer" :default-method="defaultMethod" />
        <Paypal v-if="selected == 'Paypal'" :datas="JSON.parse(props.datas.datas).paypal" :default-method="defaultMethod" />
        <TransferWise v-if="selected == 'TransferWise'" :datas="JSON.parse(props.datas.datas).transferwise" :default-method="defaultMethod" />
      </div>
    </template>
  </AppLayout>
</template>
