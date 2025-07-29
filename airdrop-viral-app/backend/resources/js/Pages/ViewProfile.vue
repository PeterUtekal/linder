<template>
  <div class="min-h-screen bg-gradient-to-br from-pink-50 to-purple-100 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
      <!-- Swipe Card -->
      <div class="relative h-[600px] mb-8">
        <div 
          ref="swipeCard"
          class="swipe-card transform transition-transform duration-300"
          :style="cardStyle"
          @touchstart="handleTouchStart"
          @touchmove="handleTouchMove"
          @touchend="handleTouchEnd"
          @mousedown="handleMouseDown"
          @mousemove="handleMouseMove"
          @mouseup="handleMouseUp"
          @mouseleave="handleMouseUp"
        >
          <!-- Photo -->
          <div class="h-2/3 relative overflow-hidden">
            <img 
              v-if="profile.photo_url"
              :src="profile.photo_url" 
              :alt="profile.name"
              class="w-full h-full object-cover"
            >
            <div v-else class="w-full h-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
              <div class="text-white text-6xl font-bold">
                {{ profile.name.charAt(0).toUpperCase() }}
              </div>
            </div>

            <!-- Swipe Indicators -->
            <div 
              v-if="swipeDirection === 'right'"
              class="absolute inset-0 bg-green-500 bg-opacity-20 flex items-center justify-center"
            >
              <div class="bg-green-500 text-white px-6 py-3 rounded-full font-bold text-xl transform -rotate-12">
                LIKE
              </div>
            </div>
            <div 
              v-if="swipeDirection === 'left'"
              class="absolute inset-0 bg-red-500 bg-opacity-20 flex items-center justify-center"
            >
              <div class="bg-red-500 text-white px-6 py-3 rounded-full font-bold text-xl transform rotate-12">
                NOPE
              </div>
            </div>
          </div>

          <!-- Info -->
          <div class="p-6">
            <h2 class="text-2xl font-bold mb-2">{{ profile.name }}</h2>
            <p class="text-gray-600 mb-3 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              {{ profile.location }}
            </p>
            <p class="text-gray-800 italic">"{{ profile.message }}"</p>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-center gap-8">
        <button 
          @click="swipeLeft"
          class="w-16 h-16 rounded-full bg-white shadow-lg flex items-center justify-center hover:scale-110 transition-transform"
        >
          <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
        
        <button 
          @click="swipeRight"
          class="w-16 h-16 rounded-full bg-white shadow-lg flex items-center justify-center hover:scale-110 transition-transform"
        >
          <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Result Modal -->
    <transition name="modal">
      <div v-if="showResult" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 transform transition-all">
          <!-- Match Result -->
          <div v-if="matched">
            <div class="text-center mb-6">
              <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-bold mb-2">It's a Match! 💕</h3>
              <p class="text-gray-600">{{ profile.name }} will be thrilled!</p>
            </div>

            <div class="space-y-3">
              <a 
                :href="contactInfo.url" 
                target="_blank"
                class="block w-full btn-primary text-center"
              >
                Contact via {{ contactInfo.method }} 💬
              </a>
              <button @click="closeResult" class="w-full btn-secondary">
                Close
              </button>
            </div>
          </div>

          <!-- No Match Result -->
          <div v-else>
            <div class="text-center mb-6">
              <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-bold mb-2">Maybe Next Time 😊</h3>
              <p class="text-gray-600 mb-4">Thanks for being honest!</p>
            </div>

            <div class="bg-primary-50 rounded-lg p-4 mb-4">
              <p class="text-primary-900 font-medium mb-2">Want to try this yourself?</p>
              <p class="text-sm text-primary-700">Create your own profile and start getting matches!</p>
            </div>

            <div class="space-y-3">
              <a href="/" class="block w-full btn-primary text-center">
                Create My Profile 🚀
              </a>
              <button @click="closeResult" class="w-full btn-secondary">
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
  profile: Object
})

// Swipe state
const isDragging = ref(false)
const startX = ref(0)
const currentX = ref(0)
const cardX = ref(0)
const swipeDirection = ref(null)
const showResult = ref(false)
const matched = ref(false)
const contactInfo = ref({})

// Computed styles
const cardStyle = computed(() => ({
  transform: `translateX(${cardX.value}px) rotate(${cardX.value * 0.1}deg)`,
  opacity: 1 - Math.abs(cardX.value) / 300
}))

// Touch/Mouse handlers
const handleStart = (clientX) => {
  isDragging.value = true
  startX.value = clientX
}

const handleMove = (clientX) => {
  if (!isDragging.value) return
  
  currentX.value = clientX
  const deltaX = currentX.value - startX.value
  cardX.value = deltaX
  
  // Update swipe direction indicator
  if (deltaX > 50) {
    swipeDirection.value = 'right'
  } else if (deltaX < -50) {
    swipeDirection.value = 'left'
  } else {
    swipeDirection.value = null
  }
}

const handleEnd = () => {
  if (!isDragging.value) return
  
  isDragging.value = false
  
  // Determine if swipe was strong enough
  if (cardX.value > 100) {
    completeSwipe('right')
  } else if (cardX.value < -100) {
    completeSwipe('left')
  } else {
    // Snap back
    cardX.value = 0
    swipeDirection.value = null
  }
}

// Touch events
const handleTouchStart = (e) => handleStart(e.touches[0].clientX)
const handleTouchMove = (e) => handleMove(e.touches[0].clientX)
const handleTouchEnd = () => handleEnd()

// Mouse events
const handleMouseDown = (e) => handleStart(e.clientX)
const handleMouseMove = (e) => handleMove(e.clientX)
const handleMouseUp = () => handleEnd()

// Button actions
const swipeLeft = () => completeSwipe('left')
const swipeRight = () => completeSwipe('right')

// Complete swipe action
const completeSwipe = async (direction) => {
  // Animate card off screen
  cardX.value = direction === 'right' ? 500 : -500
  
  // Record swipe
  try {
    const deviceId = localStorage.getItem('device_id') || generateDeviceId()
    const response = await axios.post('/api/swipes', {
      profile_code: props.profile.short_code,
      is_right_swipe: direction === 'right'
    }, {
      headers: {
        'X-Device-ID': deviceId
      }
    })
    
    localStorage.setItem('device_id', deviceId)
    
    if (direction === 'right') {
      matched.value = true
      contactInfo.value = response.data.contact
    } else {
      matched.value = false
      
      // Track if user creates profile after left swipe
      sessionStorage.setItem('swipe_id', response.data.swipe_id)
    }
    
    showResult.value = true
  } catch (error) {
    console.error('Error recording swipe:', error)
  }
  
  // Reset card position
  setTimeout(() => {
    cardX.value = 0
    swipeDirection.value = null
  }, 300)
}

const closeResult = () => {
  showResult.value = false
}

const generateDeviceId = () => {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    const r = Math.random() * 16 | 0
    const v = c === 'x' ? r : (r & 0x3 | 0x8)
    return v.toString(16)
  })
}

// Track profile view
onMounted(() => {
  // Profile view is tracked server-side in the controller
})
</script>

<style scoped>
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from, .modal-leave-to {
  opacity: 0;
}

.modal-enter-active .transform,
.modal-leave-active .transform {
  transition: transform 0.3s ease;
}

.modal-enter-from .transform {
  transform: scale(0.9);
}

.modal-leave-to .transform {
  transform: scale(0.9);
}
</style>