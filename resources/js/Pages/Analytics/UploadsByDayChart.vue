<template>
  <div class=" bg-white rounded-xl ">
    <div class="mt-4 px-4 pb-4" id="chart" >
      <LineChart ref="lineChartRef" :chartData="chartData" :options="options" />
    </div>
  </div>
</template>

<script setup>
import { shuffle } from 'lodash';
import { computed, onMounted, ref } from 'vue';
import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";

Chart.register(...registerables)

const props = defineProps({
  data: Array,
})

const lineChartRef = ref();

const options = ref({
  responsive: true,
  interaction: {
    mode: 'index',
    intersect: false,
  },
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Uploads',
    },
  },
  scales: {
    y: {
      type: 'linear',
      display: true,
      position: 'left',
      ticks: {
        color: '#9487C6',
        font: {
          size: 12,
          family: 'rubik'
        }
      }
    },
    x: {
      grid: {
        drawOnChartArea: false,
      },
      ticks: {
        autoskip: true,
        maxTicksLimit: 6,
        font: {
          size: 10,
          family: 'rubik'
        }
      }
    }
  }
});

const chartData = computed(() => ({
  labels: props.data.map((el) => el.day),
  datasets : [
    {
      data : props.data.map((el) => el.uploaded),
      type : 'line',
      label: 'uploaded',
      backgroundColor: '#07B6D4',
      borderColor: '#07B6D4',
      yAxisID: 'y',
      tension: 0.4,
    },
    {
      data : props.data.map((el) => el.duplicate),
      type : 'line',
      label: 'duplicate',
      backgroundColor: '#1B2E51',
      borderColor: '#1B2E51',
      yAxisID: 'y',
      tension: 0.4,
    },
    {
      data : props.data.map((el) => el.wrong_number),
      type : 'line',
      label: 'wrong number',
      backgroundColor: '#F2135D',
      borderColor: '#F2135D',
      yAxisID: 'y',
      tension: 0.4,
    }
  ],
}))
</script>
