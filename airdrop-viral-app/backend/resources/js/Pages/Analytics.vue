<template>
  <div class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-4xl mx-auto">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Analytics Dashboard 📊</h1>
        <p class="text-gray-600">Track your profile's performance</p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center py-12">
        <svg class="animate-spin h-10 w-10 text-primary-600" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </div>

      <div v-else>
        <!-- Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <div class="card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-600">Total Views</p>
                <p class="text-2xl font-bold">{{ stats.totals.views }}</p>
              </div>
              <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-600">Total Swipes</p>
                <p class="text-2xl font-bold">{{ stats.totals.swipes }}</p>
              </div>
              <div class="bg-purple-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-600">Right Swipes</p>
                <p class="text-2xl font-bold">{{ stats.totals.right_swipes }}</p>
              </div>
              <div class="bg-green-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-600">Match Rate</p>
                <p class="text-2xl font-bold">{{ matchRate }}%</p>
              </div>
              <div class="bg-pink-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Viral Conversions -->
        <div class="card mb-8">
          <h2 class="text-xl font-semibold mb-4">🚀 Viral Impact</h2>
          <div class="bg-primary-50 rounded-lg p-4">
            <p class="text-3xl font-bold text-primary-900">{{ stats.totals.viral_conversions }}</p>
            <p class="text-sm text-primary-700">People created profiles after swiping on yours!</p>
          </div>
        </div>

        <!-- Daily Stats Chart -->
        <div class="card mb-8">
          <h2 class="text-xl font-semibold mb-4">Daily Activity</h2>
          <div class="space-y-3">
            <div v-for="day in stats.daily_stats" :key="day.date" class="flex items-center gap-4">
              <div class="w-24 text-sm text-gray-600">
                {{ formatDate(day.date) }}
              </div>
              <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                  <div class="h-4 bg-blue-200 rounded" :style="{width: `${(day.total_swipes / maxSwipes) * 100}%`}"></div>
                  <span class="text-sm text-gray-600">{{ day.total_swipes }} swipes</span>
                </div>
                <div class="flex items-center gap-2">
                  <div class="h-4 bg-green-400 rounded" :style="{width: `${(day.right_swipes / maxSwipes) * 100}%`}"></div>
                  <span class="text-sm text-gray-600">{{ day.right_swipes }} matches</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
          <a :href="`/success/${profileCode}`" class="btn-primary text-center">
            View Share Instructions 📱
          </a>
          <a href="/" class="btn-secondary text-center">
            Create New Profile
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
  profileCode: String
})

const loading = ref(true)
const stats = ref({
  profile: {},
  daily_stats: [],
  totals: {
    views: 0,
    swipes: 0,
    right_swipes: 0,
    viral_conversions: 0
  }
})

const matchRate = computed(() => {
  if (stats.value.totals.swipes === 0) return 0
  return Math.round((stats.value.totals.right_swipes / stats.value.totals.swipes) * 100)
})

const maxSwipes = computed(() => {
  return Math.max(...stats.value.daily_stats.map(d => d.total_swipes), 1)
})

const formatDate = (dateStr) => {
  const date = new Date(dateStr)
  return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })
}

const fetchAnalytics = async () => {
  try {
    const response = await axios.get(`/api/swipes/analytics/${props.profileCode}`)
    stats.value = response.data
  } catch (error) {
    console.error('Error fetching analytics:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchAnalytics()
  
  // Refresh every 30 seconds
  const interval = setInterval(fetchAnalytics, 30000)
  
  // Clean up on unmount
  return () => clearInterval(interval)
})
</script>