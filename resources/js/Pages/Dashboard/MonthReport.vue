<template>
  <div class="border border-gray-200 bg-white rounded-xl shadow-xl">
    <div class="mt-4 pl-2" id="chart" v-if="datas != null">
      <apexchart type="treemap" height="350" :options="chartOptions" :series="series"></apexchart>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios';
import { computed, onMounted, ref } from 'vue';

const datas = ref(null)
const series = ref(null)
const chartOptions = ref(null)
onMounted(async () => {
  const res = await axios.get(route('dashboard.month_reports'))
  datas.value = res.data
  console.log(datas.value.map((el) => el.uploaded).reduce((a, b) => a + b, 0));

  series.value = [
    {
      data: [{
        x: 'Uploaded',
        y: datas.value.map((el) => el.uploaded).reduce((a, b) => a + b, 0),
        color: '#52B12C'
      },
      {
        x: 'Processed',
        y: datas.value.map((el) => el.affected).reduce((a, b) => a + b, 0),
        color: '#52B12C'
      },
      {
        x: 'Confirmed',
        y: datas.value.map((el) => el.confirmed).reduce((a, b) => a + b, 0),
        color: '#52B12C'
      }]
    }
  ]

  chartOptions.value = {
    legend: {
      show: false
    },
    chart: {
      height: 350,
      type: 'treemap'
    },
    title: {
      text: 'This month trend'
    },

    dataLabels: {
      enabled: true
    },

  }


})

// const chartDatas = computed( () => datas.value.map(el => el.conf_rate))
// const labels = computed( () => datas.value.map(el => el.labels))


</script>
