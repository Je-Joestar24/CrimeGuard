<template>
  <div
    class="bg-gradient-to-b from-blue-600/95 to-blue-400/80 py-10 text-white flex flex-col items-center justify-between"
    style="height: 100vh;"
  >
    <div class="text-center mt-8 animate-fade-in-down">
      <h1 class="text-white text-5xl md:text-6xl font-bold titleCG mb-4">
        <span class="block">REAL-TIME</span>
        <span class="block">CRIME</span>
        <span class="block">MONITORING</span>
      </h1>
      <h3 class="text-white subCG text-xs md:text-base mb-6">
        Empowering Law Enforcement and Citizens for a Safer Community
      </h3>
    </div>

    <div class="relative h-48 w-48 my-8 animate-float">
      <div class="h-48 w-48 absolute rounded-full bg-gradient-to-tr from-blue-900 to-blue-100 spinning-circle"></div>
      <svg
        class="h-40 w-40 text-blue-200 absolute right-4 top-4 p-2 rounded-full bg-blue-500"
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

    <div class="text-center px-6 mb-8 animate-fade-in-up">
      <h4 class="flex items-center justify-center text-lg mb-4">
        <svg
          class="h-10 w-10 text-blue-50 mr-3 animate-bounce"
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
        <span class="font-semibold">CrimeGuard</span>
      </h4>
      <p class="text-sm leading-relaxed">
        Modernizing crime reporting, tracking, and analysis for safer cities.
        Our innovative platform empowers communities and law enforcement to work together.
      </p>
    </div>
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
