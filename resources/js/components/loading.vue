<template>
  <div
    class="min-h-screen w-full flex flex-col justify-center items-center"
    :class="{'bg-white text-gray-800': !$store.getters.theme, 'bg-gray-800 text-white': $store.getters.theme}"
  >
    <div class="text-center mb-8">
      <h1 class="text-4xl font-bold mb-2">CrimeGuard</h1>
      <p class="text-xl">Empowering communities, ensuring safety</p>
    </div>
    
    <div class="relative">
      <svg
        class="animate-spin -ml-1 mr-3 h-16 w-16"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
      <span class="sr-only">Loading...</span>
    </div>
    
    <div class="mt-8 text-center max-w-md">
      <p class="text-lg mb-4">Loading your secure environment...</p>
      <p class="text-sm opacity-75">
        CrimeGuard is preparing to provide you with real-time incident reports,
        community alerts, and tools to keep your neighborhood safe.
      </p>
    </div>
    
    <div class="mt-12 flex space-x-4">
      <div class="animate-pulse flex space-x-4">
        <div class="rounded-full bg-blue-400 h-3 w-3"></div>
        <div class="rounded-full bg-blue-400 h-3 w-3"></div>
        <div class="rounded-full bg-blue-400 h-3 w-3"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
  },
  data() {
    return {
    };
  },
  methods: {},
};
</script>