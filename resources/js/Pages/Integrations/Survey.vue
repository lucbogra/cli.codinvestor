<template>
  <Modal :show="show" @close="$emit('closemodal')">
    <div
      class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400"
    >
      <div class="w-full flex justify-start text-gray-600 mb-3">
        <!-- <svg
          xmlns="http://www.w3.org/2000/svg"
          class="icon icon-tabler icon-tabler-wallet"
          width="52"
          height="52"
          viewBox="0 0 24 24"
          stroke-width="1"
          stroke="currentColor"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path stroke="none" d="M0 0h24v24H0z" />
          <path
            d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"
          />
          <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
        </svg> -->
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="icon icon-tabler icon-tabler-wallet"
          width="52"
          height="52"
          viewBox="0 0 24 24"
          stroke-width="1"
          stroke="currentColor"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"
          />
        </svg>
        <h1 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4 mt-4">Survey</h1>
      </div>
      
      <div>
        <jetLabel
          >what type of platforms do you use the most for your advertising
          campaigns ?</jetLabel
        >
        <select
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
          v-model="form.platforms"
        >
          <option value="" selected disabled>Select A Platform</option>
          <option value="Facebook">Facebook</option>
          <option value="Tiktok">Tiktok</option>
          <option value="Google">Google</option>
          <option value="Instagram">Instagram</option>
        </select>
      </div>

      <div class="mt-4">
        <jetLabel>what is your average number of leads/day?</jetLabel>
        <jetInput type="text" class="block w-full p-2" v-model="form.leads"></jetInput>
      </div>

      <div class="mt-4">
        <jetLabel>what is your CPL?</jetLabel>
        <jetInput type="text" class="block w-full p-2" v-model="form.cpl"></jetInput>
      </div>

      <div class="mt-4">
        <jetLabel>have you ever used a similar service?</jetLabel>
        <div class="inline-flex space-x-3">
            <span class="block font-medium text-sm text-gray-700"><input type="radio" name="similaire" value="Yes" v-model="form.similar_service"/> Yes </span>
            <span class="block font-medium text-sm text-gray-700"><input type="radio" name="similaire" value="No" v-model="form.similar_service"/> No </span>
        </div>
        
      </div>
      <div class="mt-4" v-if="form.similar_service==='No'">
        <jetLabel>tell us more about this service</jetLabel>
        <textarea v-model="form.service_observation" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"></textarea>
      </div>

      <div class="mt-4">
        <jetLabel>why you subscribe to this service?</jetLabel>
        <ul class="list-disc ml-7">
          <li>
            <input type="checkbox" @click="check" value="Gain Time" v-model="form.subscribe"> Gain Time
          </li>
          <li>
            <input type="checkbox" value="I have no experience in creating videos." v-model="form.subscribe">
            
            have no experience in creating videos.
          </li>
          <li>
            <input type="checkbox" value="to have the best videos and a better conversion rate" v-model="form.subscribe">
           
            To have the best videos and a better conversion rate
          </li>
          <li><input type="checkbox" value="others" v-model="form.subscribe"> Others <jetInput v-if="form.subscribe.includes('others')" type="text"></jetInput></li>
        </ul>
      </div>

      <div class="flex items-center justify-center mt-6 w-full">
        <button
          class="btn-primary bg-gray-100 text-primary-800 mr-2 hover:bg-primary-600 hover:text-white"
        >
          Cancel
        </button>
        <button class="btn-primary">Create Account</button>
      </div>
    </div>

  </Modal>
</template>

<script setup>
import Modal from "@/Jetstream/Modal.vue";
import jetInput from "@/Jetstream/Input.vue";
import jetLabel from "@/Jetstream/Label.vue";
import jetCheckbox from "@/Jetstream/Checkbox.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
const props = defineProps({
  show: Boolean,
});

const form = useForm({
  subscribe: ref([]),
  platforms: "",
  leads: "",
  cpl: "",
  similar_service:"Yes",
  service_observation:""
});

const subscribe=ref([])

const check =  ()=>{
// console.log(form.subscribe);
}
</script>
