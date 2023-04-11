<template>
  <div class="min-h-full">

    <!-- Mobile Sidebar -->
    <mobile-side-bar :navigation="navigation" :secondaryNavigation="secondaryNavigation" :sidebarOpen="sidebarOpen"
      @sidebarClose="sidebarOpen = false" />

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
      <!-- Sidebar -->
      <desktop-side-bar :navigation="navigation" :secondaryNavigation="secondaryNavigation" />
    </div>

    <div class="lg:pl-64 flex flex-col flex-1 bg-slate-100">
      <div class="z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200 lg:border-none sticky top-0">
        <button type="button"
          class="px-4 border-r border-gray-200 text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500 lg:hidden"
          @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <MenuAlt1Icon class="h-6 w-6" aria-hidden="true" />
        </button>
        <top />
      </div>
      <main class="flex-1 pb-8  bg-slate-100" scroll-region>
        <Alerts />
        <!-- Page header -->
        <slot name="page-header" />
        <div class="md:flex-1 px-4 py-8 bg-slate-100 ">
          <FlashMessages />
          <slot name="content" />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import 'animate.css';

import {
  ClockIcon,
  CogIcon,
  DocumentReportIcon,
  HomeIcon,
  MenuAlt1Icon,
  QuestionMarkCircleIcon,
  CollectionIcon,
  CreditCardIcon,
  PresentationChartLineIcon,
  ClipboardListIcon,
  CashIcon,
  InboxIcon,
} from '@heroicons/vue/outline'
import {
  ShoppingCartIcon,
  ViewListIcon
} from '@heroicons/vue/solid'
import MobileSideBar from './MobileSideBar.vue'
import DesktopSideBar from './DesktopSideBar.vue'
import Top from './Top.vue'
import FlashMessages from './FlashMessages.vue'
import { usePage } from '@inertiajs/inertia-vue3';
import route from '../../../vendor/tightenco/ziggy/src/js';
import { auth } from '../Pages/Permissions'
import Alerts from './Alerts.vue';


const props = defineProps({
  title: String
})

const isUrl = (...urls) => {
  let currentUrl = usePage().url.value;
  if (urls[0] === "") {
    return currentUrl === "";
  }
  return urls.filter((url) => currentUrl.startsWith(url)).length;
}

const navigation = [
  { name: 'Home', href: route('dashboard'), icon: HomeIcon, current: isUrl(''), show: auth.value.hasRole('Investor') },

  { name: 'Marketplace', href: route('marketplace.index'), icon: ShoppingCartIcon, current: isUrl('/marketplace'), show: true },

  { name: 'Products', href: route('marketplace.products'), icon: ViewListIcon, current: isUrl('/products'), show: true },

  { name: 'Orders', href: route('orders.index'), icon: CollectionIcon, current: isUrl('/orders'), show: true },

  // { name: 'History', href: '#', icon: ClockIcon, current: false },

  { name: 'Reports', href: route('reports'), icon: DocumentReportIcon, current: isUrl('/reports'), show: auth.value.hasPermission('affiliate show reports') },

  { name: 'Analytics', href: route('analytics'), icon: PresentationChartLineIcon, current: isUrl('/analytics'), show: auth.value.hasPermission('affiliate show analytics') },

  { name: 'Invoices', href: route('invoices.index'), icon: ClipboardListIcon, current: isUrl('/invoices'), show: auth.value.hasPermission('affiliate show invoices') },

  { name: 'Fundings', href: route('fundings.index'), icon: CashIcon, current: isUrl('/fundings'), show: auth.value.hasPermission('have funding') },


]
const secondaryNavigation = [
  { name: 'Settings', href: route('user.profile'), icon: CogIcon, current: isUrl('/user'), show: true },
  { name: 'Billing Settings', href: route('billing.index'), icon: CreditCardIcon, current: isUrl('/billing'), show: auth.value.hasRole('Investor') },
  { name: 'Messages', href: route('messages.index'), icon: InboxIcon, current: isUrl('/messages'), show: auth.value.hasRole('Investor'), indicator: usePage().props.value.message_notifications },

  { name: 'Help', href: route('help'), icon: QuestionMarkCircleIcon, show: true },
  { name: 'Integrations', href: route('integrations.index'), icon: CashIcon, current: isUrl('/integrations'), show: true },
  // { name: 'Services', href: route('services.index'), icon: CollectionIcon, show : true},
  //   { name: 'Privacy', href: '#', icon: ShieldCheckIcon },
]

onMounted(() => {
  document.title = props.title
})
const sidebarOpen = ref(false)

</script>
