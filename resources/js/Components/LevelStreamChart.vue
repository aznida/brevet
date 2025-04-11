<template>
  <div>
    <Bar v-if="chartData && hasData" :data="chartData" :options="chartOptions" />
    <div v-else class="text-center py-5">
      <h5 class="text-muted">Data belum tersedia</h5>
    </div>
  </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend } from 'chart.js'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

export default {
  name: 'LevelStreamChart',
  components: { Bar },
  props: {
    areaLevelStats: {
      type: Array,
      required: true
    }
  },
  computed: {
    hasData() {
      return this.areaLevelStats && this.areaLevelStats.length > 0 && this.getTotalParticipants() > 0
    },
    chartData() {
      const levels = ['starter', 'basic', 'intermediate', 'advanced', 'expert']
      const totals = levels.map(level => 
        this.areaLevelStats.reduce((total, stat) => total + (stat[`${level}_participants`] ? stat[`${level}_participants`].length : 0), 0)
      )

      return {
        labels: ['Starter 🌱', 'Basic 🥉', 'Intermediate 🥈', 'Advanced 🥇', 'Expert 💎'],
        datasets: [{
          label: 'Jumlah Peserta',
          data: totals,
          backgroundColor: [
            'rgba(75, 192, 192, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 99, 132, 0.6)'
          ]
        }]
      }
    },
    chartOptions() {
      return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: 'bottom'
          },
          tooltip: {
            enabled: true
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            }
          }
        }
      }
    }
  },
  methods: {
    getTotalParticipants() {
      const levels = ['starter', 'basic', 'intermediate', 'advanced', 'expert']
      return levels.reduce((total, level) => 
        total + this.areaLevelStats.reduce((sum, stat) => sum + (stat[`${level}_participants`] ? stat[`${level}_participants`].length : 0), 0), 0
      )
    }
  }
}
</script>