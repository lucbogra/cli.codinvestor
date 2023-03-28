<script setup>
import { ref, computed } from 'vue'
import { Link, usePage } from '@inertiajs/inertia-vue3'
import { Menu, MenuButton, MenuItem, MenuItems, } from '@headlessui/vue'
import { BellIcon, CashIcon, ScaleIcon } from '@heroicons/vue/outline'
import { ChevronDownIcon, SearchIcon, } from '@heroicons/vue/solid'
import { Inertia } from '@inertiajs/inertia'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import { auth } from '../Pages/Permissions'
import Notifications from './Notifications.vue'


const logout = () => {
  Inertia.post(route('logout'));
}

const showNotifications = ref(false)

</script>
<template>
  <div class="flex-1 px-4 flex justify-between sm:px-6 lg:max-w-8xl lg:mx-auto lg:px-8 ">
    <div class="flex-1 flex">
      <form class="w-full flex md:ml-0" action="#" method="GET">
        <label for="search-field" class="sr-only">Search</label>
        <div class="relative w-full text-gray-400 focus-within:text-gray-600">
          <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none" aria-hidden="true">
            <!-- <SearchIcon class="h-5 w-5" aria-hidden="true" /> -->
          </div>
          <!-- <input id="search-field" v-on:focusin="showSearch()" v-on:focusout="showSearchBox = false" name="search-field"
            class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 focus:border-transparent sm:text-sm"
            placeholder="Search transactions" type="search" /> -->
        </div>
      </form>
    </div>
    <div class="ml-4 flex items-center md:ml-6">
      <div class="mr-4">
        <a href="https://www.youtube.com/watch?v=eouNMhlsf4w&list=PLlduhmnwwUbappqazBkpguFdXCfwZ2u-5" target="_blank">
          <i class="fa-brands fa-youtube fa-lg" style="color: #FF0000;"></i>
        </a>
      </div>
      <div class="flex text-success" v-if="auth.hasRole('Investor')">
        <ScaleIcon class="flex-shrink-0 ml-1 h-5 w-5 mr-2"/>
         +{{$page.props.auth.user.balance}} USD
      </div>
      <div class="ml-4 flex text-secondary" v-if="auth.hasPermission('have funding')">
        <CashIcon class=" flex-shrink-0 ml-1 h-5 w-5 mr-2"/>
         -{{$page.props.auth.user.funding}} USD
      </div>

      <button @click="showNotifications = true" class="ml-2 max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-700 lg:p-2 lg:rounded-md lg:hover:bg-gray-50">
        <BellIcon class="h-6 w-6" aria-hidden="true" />
        <span class="-mt-3 text-xs font-medium text-white bg-danger px-1  rounded-lg group-hover:text-gray-800">{{ Object.keys($page.props.notifications).length }}</span>
      </button>

      <Notifications :open="showNotifications" @close="showNotifications = false"  />

      <!-- Profile dropdown -->
      <Menu as="div" class="ml-3 relative">
        <div>
          <MenuButton
            class="max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 lg:p-2 lg:rounded-md lg:hover:bg-gray-50">
            <img class="h-8 w-8 rounded-full" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
            <span class="hidden ml-3 text-gray-700 text-sm font-medium lg:block"><span class="sr-only">Open
                user menu for </span>{{ $page.props.user.name }}</span>
            <ChevronDownIcon class="hidden flex-shrink-0 ml-1 h-5 w-5 text-gray-400 lg:block" aria-hidden="true" />
          </MenuButton>
        </div>
        <transition enter-active-class="transition ease-out duration-100"
          enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
          leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
          leave-to-class="transform opacity-0 scale-95">
          <MenuItems
            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
            <MenuItem v-slot="{ active }">
            <Link :href="route('user.profile')"
              :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Your Profile
            </Link>
            </MenuItem>
            <!-- <MenuItem v-slot="{ active }">
            <Link :href="route('user.profile')"
              :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Settings</Link>
            </MenuItem> -->
            <MenuItem v-slot="{ active }">
              <form @submit.prevent="logout">
                <JetDropdownLink as="button">
                  Logout
                </JetDropdownLink>
              </form>
            </MenuItem>
          </MenuItems>
        </transition>
      </Menu>

    </div>

  </div>
</template>
