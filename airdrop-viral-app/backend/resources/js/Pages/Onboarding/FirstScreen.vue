<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100 px-4 py-12">
    <h1 class="text-4xl font-bold text-center mb-12">Unlock your perfect job</h1>

    <div class="w-full max-w-md space-y-6">
      <!-- Yes Option -->
      <div
        @click="selectOption('yes')"
        class="card cursor-pointer transition-transform hover:-translate-y-1 active:translate-y-0.5"
      >
        <p class="text-lg font-semibold text-center">Yes, I live in the United States</p>
      </div>

      <!-- No Option -->
      <div
        @click="selectOption('no')"
        class="card cursor-pointer transition-transform hover:-translate-y-1 active:translate-y-0.5"
      >
        <p class="text-lg font-semibold text-center">No, I live outside the United States</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

/**
 * Handle option selection.
 * For now we simply redirect to a placeholder next step which will be implemented later.
 * The chosen value is passed along as a query parameter so that the next step can make use of it.
 */
function selectOption(choice) {
  router.visit(`/onboarding/step2`, {
    data: { usResident: choice },
    method: 'get',
  })
}
</script>