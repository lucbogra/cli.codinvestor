
<template>
  <div class="vld-parent">
      <loading v-model:active="isLoading"
               :can-cancel="true"
               :on-cancel="onCancel"
               :is-full-page="fullPage"
               color="#1B2E51"/>
  </div>
</template>

<script>
  import Loading from 'vue-loading-overlay';
  import 'vue-loading-overlay/dist/vue-loading.css';

  export default {
    props : {
      isLoading : Boolean
    },
    data() {
        return {
            fullPage: true
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
