<template>
    <div class="fixed bg-gray-900 bg-opacity-50 top-0 left-0 flex z-50" style="height:100vh;width: 100vw;">
      <div class="bg-white rounded-lg p-8 shadow-2xl transform transition-all m-auto">
        <div class="flex flex-col items-center">
          <div class="w-24 h-24 mb-4 relative">
            <svg class="animate-spin text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-teal-500 rounded-full opacity-20 animate-pulse"></div>
          </div>
          <h2 class="text-2xl font-bold text-gray-800 mb-2">Restoring...</h2>
          <p class="text-gray-600 text-center">Please wait while we restore your archived data.</p>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            
        }
    }
}
</script>