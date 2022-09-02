<template>
  <div class="border border-gray-200 bg-white rounded-xl shadow-xl">
    <div class="mt-4 pr-2" id="chart">
      <apexchart type="line" height="350" :options="lineChartOptions" :series="lineSeries"></apexchart>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
  performance : Array
})

// const lineSeries = ref(null)
// const lineChartOptions = ref(null)

const lineSeries = [{
  name: 'confirmation rate',
  type: 'line',
  data: Object.values(props.performance).map((el) => el.confirmation_rate),
  color: '#52B12C'
}]

const lineChartOptions = {
  chart: {
    height: 350,
    type: 'line',
    dropShadow: {
      enabled: true,
      color: '#000',
      top: 18,
      left: 7,
      blur: 10,
      opacity: 0.2
    },
    toolbar: {
      show: true
    }
  },
  dataLabels: {
    enabled: true
  },
  stroke: {
    curve: 'smooth'
  },
  xaxis: {
    type: 'date',
    categories:  Object.values(props.performance).map((el) => el.date),
  },
  title: {
    text: 'Last 30 Days Confirmation rate',
    align: 'left'
  },
}

// const chartDatas = computed( () => datas.value.map(el => el.conf_rate))
// const labels = computed( () => datas.value.map(el => el.labels))


</script>
