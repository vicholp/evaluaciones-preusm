<template>
  <Bar
    id="my-chart-id"
    :options="chartOptions"
    :data="chartData"
  />
</template>

<script>
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

export default {
  name: 'BarChart',
  components: { Bar },

  props: {
    scores: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      chartData: {
        labels: [...Array(this.scores.length).keys()],
        datasets: [{
          label: 'Puntajes',
          backgroundColor: '#3730A3',
          type: 'bar',
          data: this.scores,
        }],
      },
      chartOptions: {
        responsive: true,
      },
    };
  },
};
</script>
