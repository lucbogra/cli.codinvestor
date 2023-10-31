import { ref } from "vue";

export const google = ref({
  track(){
    const script = document.createElement("script");
      script.innerHTML = ` window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'AW-11391713151');`

    document.body.appendChild(script);
  }
})
