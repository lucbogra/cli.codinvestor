

<template>
  <div class="min-h-full">

    <!-- Mobile Sidebar -->
    <mobile-side-bar :navigation="navigation" :secondaryNavigation="secondaryNavigation" :sidebarOpen="sidebarOpen" @sidebarClose="sidebarOpen = false" />

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
      <!-- Sidebar -->
      <desktop-side-bar :navigation="navigation" :secondaryNavigation="secondaryNavigation" />
    </div>

    <div class="lg:pl-64 flex flex-col flex-1 bg-slate-100">
      <div class="z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200 lg:border-none sticky top-0">
        <button type="button" class="px-4 border-r border-gray-200 text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500 lg:hidden" @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <MenuAlt1Icon class="h-6 w-6" aria-hidden="true" />
        </button>
        <top />
      </div>
      <main class="flex-1 pb-8  bg-slate-100" scroll-region>
        <!-- Page header -->
        <slot name="page-header" />
        <div class="md:flex-1 px-4 py-8 bg-slate-100 ">
          <flash-messages />
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
  Dialog,
  DialogOverlay,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  BellIcon,
  ClockIcon,
  CogIcon,
  CreditCardIcon,
  DocumentReportIcon,
  HomeIcon,
  MenuAlt1Icon,
  QuestionMarkCircleIcon,
  ScaleIcon,
  ShieldCheckIcon,
  UserGroupIcon,
  XIcon,
  GiftIcon,
  OfficeBuildingIcon,
LocationMarkerIcon,
CollectionIcon,
CubeIcon,
} from '@heroicons/vue/outline'
import {
  CashIcon,
  ChevronDownIcon,
  ChevronRightIcon,
  SearchIcon,
UsersIcon,
ShoppingCartIcon,
ViewListIcon
} from '@heroicons/vue/solid'
import MobileSideBar from './MobileSideBar.vue'
import DesktopSideBar from './DesktopSideBar.vue'
import Top from './Top.vue'
import FlashMessages from './FlashMessages.vue'
import { usePage } from '@inertiajs/inertia-vue3';


const props = defineProps({
    title: String
})

const isUrl  = (...urls) => {
    let currentUrl = usePage().url.value;
    if (urls[0] === "") {
        return currentUrl === "";
    }
    return urls.filter((url) => currentUrl.startsWith(url)).length;
}

const navigation = [
  { name: 'Home', href: route('dashboard'), icon: HomeIcon, current:  isUrl('/dashboard') },

  { name: 'Marketplace', href: route('marketplace.index'), icon: ShoppingCartIcon, current: isUrl('/marketplace') },

  { name: 'Products', href: route('marketplace.products'), icon: ViewListIcon, current: isUrl('/products') },

  { name: 'Orders', href: route('orders.index'), icon: CollectionIcon, current: isUrl('/orders') },

  { name: 'History', href: '#', icon: ClockIcon, current: false },

  { name: 'Reports', href: '#', icon: DocumentReportIcon, current: false },
]
const secondaryNavigation = [
  { name: 'Settings', href: route('user.profile'), icon: CogIcon, current: isUrl('/user') },
  { name: 'Help', href: route('user.create.ticket'), icon: QuestionMarkCircleIcon },
//   { name: 'Privacy', href: '#', icon: ShieldCheckIcon },
]

onMounted(() => {
    document.title = props.title
})
const sidebarOpen = ref(false)

</script>
