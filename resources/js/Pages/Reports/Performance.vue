<template>
  <div class="border border-gray-200 bg-white rounded-xl shadow-xl">
    <div class="mt-4 pr-2" id="chart">
      <apexchart type="area" height="350" :options="chartOptions" :series="series"></apexchart>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';

const props = defineProps({
  performance: Array
})

const series = computed(() => [{
  name: 'Uploaded',
  data: Object.values(props.performance).map((el) => el.uploaded),
  color: '#07B6D4'
}, {
  name: 'Rejected',
  data: Object.values(props.performance).map((el) => el.rejected),
  color: '#F29104'
}, {
  name: 'Duplicate',
  data: Object.values(props.performance).map((el) => el.duplicate),
  color: '#1B2E51'
}, {
  name: 'Wrong number',
  data: Object.values(props.performance).map((el) => el.wrong_number),
  color: '#F2135D'
}])

const chartOptions = ref( {
  chart: {
    height: 350,
    type: 'area',
    toolbar: {
      show: true
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'smooth'
  },
  xaxis: {
    enabled: false,
    type: 'date',
    categories: Object.values(props.performance).map((el) => el.date),
  },
  title: {
    text: 'Last 30 days performance trend (uploaded)',
    align: 'left'
  },
})

// watch(props.performance,(newValue) => {
//   if(newValue){
//     this.updateOptions( {
//       xaxis: {
//     enabled: false,
//     type: 'date',
//     categories: Object.values(newValue).map((el) => el.date),
//   },
//     })
//   }
// })

</script>
