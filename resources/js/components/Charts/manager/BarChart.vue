<template>
  <ApexChart
    type="bar"
    :options="chartOptions"
    :series="series"
  />
</template>

<script setup>
import { ref } from 'vue'
import ApexChart from 'vue3-apexcharts'

const series = ref([
  {
    name: "Chosen Period",
    data: [
      23000, 44000, 55000, 57000, 56000, 61000, 58000, 63000,
      60000, 66000, 34000, 78000
    ],
  },
  {
    name: "Last Period",
    data: [
      17000, 76000, 85000, 101000, 98000, 87000, 105000, 91000,
      114000, 94000, 67000, 66000
    ],
  }
])

const chartOptions = ref({
  chart: {
    type: 'bar',
    height: 300,
    toolbar: {
      show: false
    },
    zoom: {
      enabled: false
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '16px',
      borderRadius: 0
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    show: true,
    width: 8,
    colors: ['transparent']
  },
  xaxis: {
    categories: [
      'January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December'
    ],
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    },
    crosshairs: {
      show: false
    },
    labels: {
      style: {
        colors: '#9ca3af',
        fontSize: '13px',
        fontWeight: 400
      },
      offsetX: -2,
      formatter: (title) => title.slice(0, 3)
    }
  },
  yaxis: {
    labels: {
      align: 'left',
      minWidth: 0,
      maxWidth: 140,
      style: {
        colors: '#9ca3af',
        fontSize: '13px',
        fontWeight: 400
      },
      formatter: (value) => (value >= 1000 ? `${value / 1000}k` : value)
    }
  },
  tooltip: {
    y: {
      formatter: (value) =>
        `$${value >= 1000 ? `${value / 1000}k` : value}`
    }
  },
  states: {
    hover: {
      filter: {
        type: 'darken',
        value: 0.9
      }
    }
  },
  responsive: [
    {
      breakpoint: 568,
      options: {
        chart: {
          height: 300
        },
        plotOptions: {
          bar: {
            columnWidth: '14px'
          }
        },
        stroke: {
          width: 8
        },
        xaxis: {
          labels: {
            style: {
              colors: '#9ca3af',
              fontSize: '11px',
              fontFamily: 'Inter, ui-sans-serif',
              fontWeight: 400
            },
            offsetX: -2,
            formatter: (title) => title.slice(0, 3)
          }
        },
        yaxis: {
          labels: {
            align: 'left',
            minWidth: 0,
            maxWidth: 140,
            style: {
              colors: '#9ca3af',
              fontSize: '11px',
              fontFamily: 'Inter, ui-sans-serif',
              fontWeight: 400
            },
            formatter: (value) => (value >= 1000 ? `${value / 1000}k` : value)
          }
        }
      }
    }
  ],
  colors: ['#2563eb', '#d1d5db'],
  grid: {
    borderColor: '#e5e7eb'
  }
})
</script>
