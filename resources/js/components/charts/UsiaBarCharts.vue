<template>
  <div class="flex column items-center q-py-md">
    <h2 class="text-md text-weight-semibold q-mb-md">Grafik Usia Penduduk (Bar)</h2>
    <canvas ref="chartCanvas" ></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Chart, BarElement, CategoryScale, LinearScale, Tooltip, Legend, BarController } from 'chart.js'
import { getChartUsia } from '@/routes/api'

// ✅ Registrasi komponen yang dibutuhkan untuk bar chart
Chart.register(BarElement, CategoryScale, LinearScale, Tooltip, Legend, BarController)

const chartCanvas = ref(null)
let chartInstance = null

onMounted(async () => {
  try {
    const response = await fetch(getChartUsia().url)
    const result = await response.json()

    if (chartInstance) chartInstance.destroy()

    chartInstance = new Chart(chartCanvas.value, {
      type: 'bar', 
      data: {
        labels: result.labels,
        datasets: [
          {
            label: 'Jumlah Penduduk',
            data: result.data,
            backgroundColor: [
              '#60A5FA', // Anak-anak
              '#FBBF24', // Remaja
              '#34D399', // Dewasa
              '#F87171'  // Orang Tua
            ],
            borderWidth: 1,
          },
        ],
      },
      options: {
        responsive: true,
      //   indexAxis: 'y',
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1,
              precision: 0
            }
          }
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: (ctx) => `${ctx.label}: ${ctx.formattedValue} orang`
            }
          }
        }
      },
    })
  } catch (error) {
    console.error('Gagal memuat data chart:', error)
  }
})
</script>

<style scoped>
canvas {
  max-width: 500px;
}
</style>
