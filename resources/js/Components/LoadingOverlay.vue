
<template>
  <div class="vl-parent">
      <loading v-model:active="isLoading"
               :can-cancel="true"
               :on-cancel="onCancel"
               :is-full-page="fullPage"
               color="#1B2E51"/>

      <slot />
  </div>
</template>

<script>
  import Loading from 'vue-loading-overlay';
  import 'vue-loading-overlay/dist/css/index.css';

  export default {
    props : {
      isLoading : Boolean,
      fullPage : {
        type : Boolean,
        default : true
      }
    },
    components: {
        Loading
    },
    methods: {
        doAjax() {
            this.isLoading = true;
            // simulate AJAX
            // setTimeout(() => {
            //     this.isLoading = false
            // }, 5000)
        },

    }
  }
</script>
