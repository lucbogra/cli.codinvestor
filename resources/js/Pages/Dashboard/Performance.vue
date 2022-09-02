<template>
  <div class="border border-gray-200 bg-white rounded-xl shadow-xl">
    <div class="mt-4 pr-2" id="chart">
      <apexchart type="area" height="350" :options="chartOptions" :series="series"></apexchart>
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

const series = [{
  name: 'Uploaded',
  data: Object.values(props.performance).map((el) => el.uploaded),
  color: '#07B6D4'
},{
  name: 'Processed',
  data: Object.values(props.performance).map((el) => el.affected),
  color: '#F29104'
},{
  name: 'Confirmed',
  data: Object.values(props.performance).map((el) => el.confirmed),
  color: '#52B12C'
}]

const chartOptions = {
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
    type: 'date',
    categories:  Object.values(props.performance).map((el) => el.date),
  },
  title: {
    text: 'Last 30 days performance trend',
    align: 'left'
  },
}

</script>
