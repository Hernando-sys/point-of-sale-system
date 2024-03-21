<template>
  <BarChart  class="mb-0.5" style="height: 80px" :chartData="chartData" :options="options" />
</template>

<script>
import { defineComponent, watch, ref } from "vue";
import { BarChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

export default defineComponent({
  name: "Home",
  components: { BarChart },
  props: {
    mappedPrices: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    const chartData = ref({
      labels: [],
      datasets: [
        {
          data: [],
          backgroundColor: "#fcd34d",
        },
      ],
    });

    const options = ref({
      scales: {
        x: {
          display: false, // Hide x-axis labels
        },
        y: {
          display: false, // Hide y-axis labels
          beginAtZero: true,
        },
      },
      maintainAspectRatio: false, // Disable aspect ratio to adjust height freely
      responsive: true, // Make the chart responsive
      plugins: {
        legend: {
          display: false, // Hide legend at the top
        },
        tooltip: {
          enabled: false, // Disable the tooltip
        },
      },
    });

    watch(
      () => props.mappedPrices,
      (newValue) => {
        // Check if the object has at least one element
        const hasElements = Object.keys(newValue).length > 0;
        if (hasElements) {
          chartData.value.labels = newValue.map(
            (interval) =>
              `${interval.lowerBound.toFixed(2)} - ${interval.upperBound.toFixed(2)}`,
          );
          chartData.value.datasets[0].data = newValue.map(
            (interval) => interval.count,
          );
        }
      },
    );

    return { chartData: chartData, options: options };
  },
});
</script>
