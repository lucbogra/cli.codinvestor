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

const series = computed(() =>
  [{
    name: 'Processed',
    data: Object.values(props.performance).map((el) => el.affected),
    color: '#07B6D4'
  }, {
    name: 'Confirmed',
    data: Object.values(props.performance).map((el) => el.confirmed),
    color: '#17C964'
  }, {
    name: 'cancelled',
    data: Object.values(props.performance).map((el) => el.cancelled),
    color: '#F2135D'
  }]
)

const chartOptions = ref({
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

watch(series, (newValue) => {
  if(newValue){
    console.log(chart.series);
    chartOptions.value = {
      xaxis : {
        categories: Object.values(props.performance).map((el) => el.date)
      }
    }
  }
})

</script>
