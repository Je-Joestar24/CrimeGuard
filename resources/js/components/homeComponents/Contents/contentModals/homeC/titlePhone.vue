<template>
  <div
    class="bg-gradient-to-b from-blue-600/95 to-blue-400/80 py-10 text-white flex flex-col items-center"
    style="height: 90vh;"
  >
    <h1
      class="text-white text-5xl md:text-6xl mt-12 font-bold titleCG text-center mb-4"
    >
      <span class="pb-2 block">REAL-TIME CRIME</span>
      <span>MONITORING</span>
    </h1>
    <h3 class="text-white subCG text-sm md:text-xs text-center mb-6">
      Empowering Law Enforcement and Citizens for a Safer Community
    </h3>

    <div class="relative h-36 w-36 my-10">
      <div class="h-36 w-36 absolute rounded-full bg-gradient-to-tr from-blue-900 to-blue-100 spinning-circle"></div>
      <svg
        class="h-32 w-32 text-blue-200 absolute right-2 top-2 p-2 rounded-full bg-blue-500"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
      </svg>
    </div>

    <h4 class="text-center text-lg mt-auto flex items-center justify-between p-5">
      <svg
        class="h-10 w-10 text-blue-50 inline mr-2"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path
          d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"
        />
        <polyline points="7.5 4.21 12 6.81 16.5 4.21" />
        <polyline points="7.5 19.79 7.5 14.6 3 12" />
        <polyline points="21 12 16.5 14.6 16.5 19.79" />
        <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
        <line x1="12" y1="22.08" x2="12" y2="12" />
      </svg>
      <span class="w-10/12 border-s text-sm ps-4 text-start">
        CrimeGuard aims to modernize how crime incidents are reported, tracked,
        and analyzed, making cities safer and more secure for all.
      </span>
    </h4>
  </div>
</template>

<style scoped>
.titleCG {
  font-family: "Roboto", sans-serif; /* Changed to a modern sans-serif font */
}

.subCG {
  font-family: "Arial", sans-serif; /* Changed to a clean sans-serif font */
}

.border {
  background-color: rgba(
    255,
    255,
    255,
    0.1
  ); /* Slightly transparent background */
}

.text-lg {
  line-height: 1.5; /* Improve readability */
}

/* Additional styles for icon alignment */
img {
  vertical-align: middle; /* Ensure icons align well with text */
}
.spinning-circle {
  animation: spin 4s linear infinite; /* Animation for spinning */
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
