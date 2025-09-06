<template>  
    <ApexChart
      type="area"
      height="300"
      :options="chartOptions"
      :series="series"
    />

</template>
<script setup>
import ApexChart from 'vue3-apexcharts'

const series = [
  {
    name: "Visitors",
    data: [300, 500, 400, 600, 550, 700, 800, 750, 670, 720, 690, 640] // Example monthly data
  }
]

const chartOptions = {
  chart: {
    type: 'area',
    height: 300,
    toolbar: { show: false },
    zoom: { enabled: false }
  },
  dataLabels: { enabled: false },
  stroke: {
    curve: 'straight',
    width: 2
  },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 1,
      opacityFrom: 0.1,
      opacityTo: 0.8,
      stops: [0, 90, 100]
    }
  },
  grid: {
    strokeDashArray: 2,
    borderColor: "#e5e7eb"
  },
  xaxis: {
    categories: [
      "January ", "February ", "March ", "April ",
      "May ", "June ", "July ", "August ",
      "September ", "October ", "November ", "December "
    ],
    labels: {
      style: {
      colors: '#9ca3af',
        fontSize: '13px',
        fontWeight: 400
      },
      formatter: function (value) {
        if (!value || typeof value !== 'string') return value
        const parts = value.split(" ")
        return `${parts[0].slice(0, 3)} ${parts[1]}`
      }
    }
  },
  yaxis: {
    labels: {
      style: {
      colors: '#9ca3af',
        fontSize: '13px',
        fontWeight: 400
      },
      formatter: (value) =>
        value >= 1000 ? `${value / 1000}k` : value
    }
  },
  tooltip: {
    y: {
      formatter: (value) =>
        value >= 1000 ? `${value / 1000}k` : value
    }
  }
}
</script>

