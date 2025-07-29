<template>
  <div class="min-h-screen bg-gradient-to-br from-primary-50 to-primary-100 py-12 px-4">
    <div class="max-w-md mx-auto">
      <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">AirDrop Your Vibe 💫</h1>
        <p class="text-gray-600">Create your profile and share it instantly!</p>
      </div>

      <form @submit.prevent="submitProfile" class="card">
        <div class="space-y-6">
          <!-- Photo Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Your Photo</label>
            <div class="relative">
              <div v-if="previewUrl" class="relative">
                <img :src="previewUrl" alt="Preview" class="w-full h-64 object-cover rounded-lg">
                <button 
                  type="button"
                  @click="removePhoto"
                  class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>
              <div v-else 
                   @click="$refs.photoInput.click()"
                   @dragover.prevent
                   @drop.prevent="handleDrop"
                   class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-primary-500 transition-colors">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-600">Click or drag photo to upload</p>
              </div>
              <input 
                ref="photoInput"
                type="file" 
                @change="handlePhotoChange"
                accept="image/*"
                class="hidden"
              >
            </div>
            <span v-if="errors.photo" class="text-red-500 text-sm mt-1">{{ errors.photo }}</span>
          </div>

          <!-- Name -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
            <input 
              v-model="form.name"
              type="text" 
              id="name"
              placeholder="John Doe"
              class="form-input"
              :class="{ 'border-red-500': errors.name }"
            >
            <span v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</span>
          </div>

          <!-- Message -->
          <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Pickup Line / Message</label>
            <textarea 
              v-model="form.message"
              id="message"
              rows="3"
              placeholder="Hey! I think you're amazing... 😊"
              class="form-input resize-none"
              :class="{ 'border-red-500': errors.message }"
            ></textarea>
            <div class="text-sm text-gray-500 mt-1">{{ form.message.length }}/500</div>
            <span v-if="errors.message" class="text-red-500 text-sm mt-1">{{ errors.message }}</span>
          </div>

          <!-- Location -->
          <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
            <div class="flex gap-2">
              <input 
                v-model="form.location"
                type="text" 
                id="location"
                placeholder="Mlynské Nivy, Bratislava"
                class="form-input flex-1"
                :class="{ 'border-red-500': errors.location }"
              >
              <button 
                type="button"
                @click="getCurrentLocation"
                :disabled="gettingLocation"
                class="btn-secondary px-4"
              >
                <svg v-if="!gettingLocation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <svg v-else class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              </button>
            </div>
            <span v-if="errors.location" class="text-red-500 text-sm mt-1">{{ errors.location }}</span>
          </div>

          <!-- Contact Method -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">How can they reach you?</label>
            <div class="grid grid-cols-3 gap-2 mb-3">
              <button
                v-for="method in contactMethods"
                :key="method.value"
                type="button"
                @click="form.contact_method = method.value"
                :class="[
                  'py-2 px-4 rounded-lg border-2 transition-colors',
                  form.contact_method === method.value 
                    ? 'border-primary-600 bg-primary-50 text-primary-700' 
                    : 'border-gray-300 hover:border-gray-400'
                ]"
              >
                {{ method.label }}
              </button>
            </div>
            <input 
              v-model="form.contact_value"
              :type="contactInputType"
              :placeholder="contactPlaceholder"
              class="form-input"
              :class="{ 'border-red-500': errors.contact_value }"
            >
            <span v-if="errors.contact_value" class="text-red-500 text-sm mt-1">{{ errors.contact_value }}</span>
          </div>

          <!-- Submit Button -->
          <button 
            type="submit"
            :disabled="processing"
            class="w-full btn-primary"
          >
            <span v-if="!processing">Create My Profile 🚀</span>
            <span v-else class="flex items-center justify-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Creating...
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'

const form = ref({
  name: '',
  photo: null,
  message: '',
  location: '',
  latitude: null,
  longitude: null,
  contact_method: 'whatsapp',
  contact_value: ''
})

const errors = ref({})
const processing = ref(false)
const previewUrl = ref(null)
const gettingLocation = ref(false)

const contactMethods = [
  { value: 'whatsapp', label: 'WhatsApp' },
  { value: 'instagram', label: 'Instagram' },
  { value: 'phone', label: 'Phone' }
]

const contactInputType = computed(() => {
  return form.value.contact_method === 'phone' ? 'tel' : 'text'
})

const contactPlaceholder = computed(() => {
  switch (form.value.contact_method) {
    case 'whatsapp':
      return '+421 123 456 789'
    case 'instagram':
      return '@yourusername'
    case 'phone':
      return '+421 123 456 789'
    default:
      return ''
  }
})

const handlePhotoChange = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.value.photo = file
    previewUrl.value = URL.createObjectURL(file)
  }
}

const handleDrop = (event) => {
  const file = event.dataTransfer.files[0]
  if (file && file.type.startsWith('image/')) {
    form.value.photo = file
    previewUrl.value = URL.createObjectURL(file)
  }
}

const removePhoto = () => {
  form.value.photo = null
  previewUrl.value = null
}

const getCurrentLocation = () => {
  if (!navigator.geolocation) {
    alert('Geolocation is not supported by your browser')
    return
  }

  gettingLocation.value = true
  navigator.geolocation.getCurrentPosition(
    async (position) => {
      form.value.latitude = position.coords.latitude
      form.value.longitude = position.coords.longitude
      
      // Reverse geocode to get location name
      try {
        const response = await fetch(
          `https://nominatim.openstreetmap.org/reverse?lat=${position.coords.latitude}&lon=${position.coords.longitude}&format=json`
        )
        const data = await response.json()
        if (data.address) {
          const parts = []
          if (data.address.road) parts.push(data.address.road)
          if (data.address.suburb) parts.push(data.address.suburb)
          if (data.address.city || data.address.town) parts.push(data.address.city || data.address.town)
          form.value.location = parts.join(', ')
        }
      } catch (error) {
        console.error('Error getting location name:', error)
      }
      
      gettingLocation.value = false
    },
    (error) => {
      console.error('Error getting location:', error)
      gettingLocation.value = false
    }
  )
}

const submitProfile = async () => {
  processing.value = true
  errors.value = {}

  const formData = new FormData()
  formData.append('name', form.value.name)
  if (form.value.photo) {
    formData.append('photo', form.value.photo)
  }
  formData.append('message', form.value.message)
  formData.append('location', form.value.location)
  if (form.value.latitude) formData.append('latitude', form.value.latitude)
  if (form.value.longitude) formData.append('longitude', form.value.longitude)
  formData.append('contact_method', form.value.contact_method)
  formData.append('contact_value', form.value.contact_value)

  try {
    const deviceId = localStorage.getItem('device_id') || generateDeviceId()
    const response = await axios.post('/api/profiles', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'X-Device-ID': deviceId
      }
    })

    localStorage.setItem('device_id', deviceId)
    router.visit(`/success/${response.data.profile.short_code}`)
  } catch (error) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
    } else {
      alert('An error occurred. Please try again.')
    }
  } finally {
    processing.value = false
  }
}

const generateDeviceId = () => {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    const r = Math.random() * 16 | 0
    const v = c === 'x' ? r : (r & 0x3 | 0x8)
    return v.toString(16)
  })
}
</script>