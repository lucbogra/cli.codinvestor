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
      <div class="flex">
        <ScaleIcon class=" flex-shrink-0 ml-1 h-5 w-5 mr-2 text-gray-400"/>
         {{$page.props.balance}} USD
      </div>

      <Menu as="div" class="ml-3 relative">
        <div>
          <MenuButton
            class="max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 lg:p-2 lg:rounded-md lg:hover:bg-gray-50">
            <BellIcon class="h-6 w-6" aria-hidden="true" />
            <span class="-mt-3 text-xs font-medium text-white bg-danger px-1  rounded-lg group-hover:text-gray-800">{{ Object.keys($page.props.notifications).length }}</span>

          </MenuButton>
        </div>
        <transition enter-active-class="transition ease-out duration-100"
          enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
          leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
          leave-to-class="transform opacity-0 scale-95">
          <MenuItems
            class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-auto">
            <MenuItem v-for="notify in $page.props.notifications" :key="notify.id">
            <a class="block vr vs xr" :href="notify.link">
              <span :class="'block text-sm ru'">📣 <span class="gp text-slate-800">
                  <span class="italic">{{notify.text}}</span>
                </span></span>
              <span class="block go gp gq">{{ notify.created_at }}</span>
            </a>
            </MenuItem>
            <MenuItem v-if="$page.props.notifications.length == 0">
            <div class="block vr vs xr text-center">
              📣 You have no notifications at this time
            </div>
            </MenuItem>
            <!-- <MenuItem v-if="$page.props.notifications.length > 0">
            <Link href="#" class="go gh gq gv mi ms vs">View all notifications</Link>
            </MenuItem> -->
          </MenuItems>

        </transition>
      </Menu>

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
            <MenuItem v-slot="{ active }">
            <Link :href="route('user.profile')"
              :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Settings</Link>
            </MenuItem>
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


      <div id="search-modal" class="m w tx la flex aj _ ri justify-center vs jj" v-show="showSearchBox" role="dialog"
        aria-modal="true" x-show="searchOpen" x-transition:enter="wt wu wr" x-transition:enter-start="opacity-0 u_"
        x-transition:enter-end="ba uj" x-transition:leave="wt wu wr" x-transition:leave-start="ba uj"
        x-transition:leave-end="opacity-0 u_">
        <div class="bg-white lu ua ou oe rounded bd">
          <!-- Search form -->
          <form class="cs border-slate-200">
            <div class="y">
              <label for="modal-search" class="d">Search </label>
              <input id="modal-search" class="ou cn kf bo av vo mn mr border-none" type="search"
                placeholder="Search Anything… " x-ref="searchInput">
            </div>
          </form>
          <div class="vu vi">
            <!-- Recent searches -->
            <div class="ro ww">
              <div class="go gh gq gv vi ru">Recent searches</div>
              <ul class="text-sm">
                <li>
                  <a class="flex items-center dx text-slate-800 xc xn rounded kk" href="#0" @click="searchOpen = false"
                    @focus="searchOpen = true" @focusout="searchOpen = false">
                    <svg class="oo sl du gq kq _t ub ra" viewBox="0 0 16 16">
                      <path
                        d="M15.707 14.293v.001a1 1 0 01-1.414 1.414L11.185 12.6A6.935 6.935 0 017 14a7.016 7.016 0 01-5.173-2.308l-1.537 1.3L0 8l4.873 1.12-1.521 1.285a4.971 4.971 0 008.59-2.835l1.979.454a6.971 6.971 0 01-1.321 3.157l3.107 3.112zM14 6L9.127 4.88l1.521-1.28a4.971 4.971 0 00-8.59 2.83L.084 5.976a6.977 6.977 0 0112.089-3.668l1.537-1.3L14 6z">
                      </path>
                    </svg>
                    <span>Form Builder - 23 hours on-demand video</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
import { ref, computed } from 'vue'
import { Link, usePage } from '@inertiajs/inertia-vue3'
import { Menu, MenuButton, MenuItem, MenuItems, } from '@headlessui/vue'
import { BellIcon, ScaleIcon } from '@heroicons/vue/outline'
import { ChevronDownIcon, SearchIcon, } from '@heroicons/vue/solid'
import { Inertia } from '@inertiajs/inertia'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';

export default {
  components: {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    BellIcon,
    ChevronDownIcon,
    SearchIcon,
    Link,
    ScaleIcon,
    JetDropdownLink,
    Inertia
  },
  data() {
    return {
      showSearchBox: false
    }
  },
  methods: {
    showSearch() {
      this.showSearchBox = !this.showSearchBox
    },
    logout () {
    Inertia.post(route('logout'));
    }
  },
  setup() {
  },
}
</script>
