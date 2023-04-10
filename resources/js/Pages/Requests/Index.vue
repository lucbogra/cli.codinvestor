<template>
    <AppLayout title="Requests">
        <template #page-header>
          <div class="mt-2 p-5 mx-10">
            <div class=" flex justify-between mb-5">
              <h1 class="gu teu text-primary-800 font-bold">Request Creatives</h1>
              <input @click="show_add=!show_add" type="button" class="btn-primary" value="Request Creative" placeholder="search..."/>
            </div>
          </div>
        </template>
        <template #content>
            <Add_request :products="products" :show="show_add" @close_modal="show_add = !show_add"></Add_request>
          <div class="vs jj ttm vl ou uf na -mt-12">
            <div class="bg-white overflow-x-auto rounded-lg border-slate-200">
              <div class="overflow-hidden">
                
              </div>
            </div>
          </div>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import Add_request from './Add.vue'
export default {
  props: {
    products:Object
  },
    components: {
        AppLayout,
        Add_request
    },
    data(){
        return {
            show_add: false
        }
    }
}
</script>
<style lang="">
    
</style>