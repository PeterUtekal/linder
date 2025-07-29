<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 py-12 px-4">
    <div class="max-w-md mx-auto">
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
          <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Profile Created! 🎉</h1>
        <p class="text-gray-600">Now share it with everyone around you!</p>
      </div>

      <!-- AirDrop Instructions -->
      <div class="card mb-6">
        <h2 class="text-xl font-semibold mb-4">📱 How to AirDrop</h2>
        
        <div class="bg-primary-50 rounded-lg p-4 mb-4">
          <p class="text-sm font-medium text-primary-900 mb-2">1. Set your device name to:</p>
          <div class="bg-white rounded p-3 font-mono text-sm break-all select-all cursor-pointer" @click="copyAirdropName">
            {{ airdropName }}
          </div>
          <p v-if="copied" class="text-green-600 text-sm mt-2">✓ Copied!</p>
        </div>

        <div class="space-y-3 text-sm text-gray-700">
          <p>2. Open <strong>Settings → General → About → Name</strong></p>
          <p>3. Change your device name to the text above</p>
          <p>4. Share this link via AirDrop to everyone nearby!</p>
        </div>

        <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
          <p class="text-sm text-yellow-800">
            <strong>Pro tip:</strong> The funnier your device name, the more people will accept your AirDrop! 😄
          </p>
        </div>
      </div>

      <!-- Share URL -->
      <div class="card mb-6">
        <h3 class="font-semibold mb-3">Your Share Link</h3>
        <div class="flex gap-2">
          <input 
            :value="shareUrl" 
            readonly 
            class="form-input flex-1 text-sm"
            @click="selectShareUrl"
            ref="shareUrlInput"
          >
          <button @click="copyShareUrl" class="btn-secondary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- QR Code -->
      <div class="card mb-6 text-center">
        <h3 class="font-semibold mb-3">QR Code (Backup Option)</h3>
        <img 
          v-if="profile.qr_code_url" 
          :src="profile.qr_code_url" 
          alt="QR Code" 
          class="mx-auto mb-3"
          style="max-width: 200px;"
        >
        <p class="text-sm text-gray-600">Show this if AirDrop isn't working</p>
      </div>

      <!-- Action Buttons -->
      <div class="space-y-3">
        <button @click="shareNative" class="w-full btn-primary">
          Share Link 🚀
        </button>
        <a 
          :href="`/analytics/${profile.short_code}`"
          class="block w-full btn-secondary text-center"
        >
          View Analytics 📊
        </a>
        <a 
          href="/"
          class="block w-full text-center text-primary-600 hover:text-primary-700 font-medium"
        >
          Create Another Profile
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  profile: Object,
  shareUrl: String,
  airdropName: String
})

const copied = ref(false)
const shareUrlInput = ref(null)

const copyAirdropName = async () => {
  try {
    await navigator.clipboard.writeText(props.airdropName)
    copied.value = true
    setTimeout(() => copied.value = false, 2000)
  } catch (err) {
    console.error('Failed to copy:', err)
  }
}

const copyShareUrl = async () => {
  try {
    await navigator.clipboard.writeText(props.shareUrl)
    // Visual feedback
    shareUrlInput.value.select()
  } catch (err) {
    console.error('Failed to copy:', err)
  }
}

const selectShareUrl = () => {
  shareUrlInput.value.select()
}

const shareNative = async () => {
  if (navigator.share) {
    try {
      await navigator.share({
        title: props.airdropName,
        text: `Check out my profile! ${props.profile.message.substring(0, 50)}...`,
        url: props.shareUrl
      })
    } catch (err) {
      console.log('Share canceled or failed:', err)
    }
  } else {
    // Fallback to copying
    copyShareUrl()
  }
}
</script>