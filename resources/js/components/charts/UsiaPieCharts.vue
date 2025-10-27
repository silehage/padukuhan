<template>
  <div class="flex column items-center q-py-md">
    <h2 class="text-md text-weight-semibold q-mb-md">Diagram Jenis Kelamin</h2>
    <canvas ref="chartCanvas" width="300" height="300"></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Chart, ArcElement, Tooltip, Legend, PieController, DoughnutController } from 'chart.js'
import {  getJenisKelaminChart } from '@/routes/api'

// ✅ Registrasi semua komponen Chart.js yang dibutuhkan
Chart.register(ArcElement, Tooltip, Legend, PieController, DoughnutController)

const chartCanvas = ref(null)
let chartInstance = null

onMounted(async () => {
  try {
    const response = await fetch(getJenisKelaminChart().url)
    const result = await response.json()

    if (chartInstance) chartInstance.destroy()

    chartInstance = new Chart(chartCanvas.value, {
      // type: 'pie',
      type: 'doughnut',
      data: {
        labels: result.labels,
        datasets: [
          {
            label: 'Jumlah Penduduk Berdasarkan Jenis Kelamin',
            data: result.data,
            backgroundColor: [
              '#60A5FA', // Anak-anak
              '#FBBF24', // Remaja
              '#34D399', // Dewasa
              '#F87171', // Orang Tua
            ],
            borderColor: '#fff',
            borderWidth: 2,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: false,
          // legend: {
          //   position: 'bottom',
          //   labels: { font: { size: 14 } },
          // },
          tooltip: {
            callbacks: {
              label: (ctx) => `${ctx.label}: ${ctx.formattedValue} orang`
            }
          },
        },
      },
    })
  } catch (error) {
    console.error('Gagal memuat data chart:', error)
  }
})
</script>

<style scoped>
canvas {
  max-width: 100%;
}
@media (min-width: 1024px) {
  canvas {
    max-width: 300px;
  }
  
}
</style>
