<template>
  <div
    class="mb-5 relative"
    style="
      height: 95vh;
      background-image: url('https://i.pinimg.com/originals/43/ec/76/43ec7607b63c03eef9cb065df5b5fc15.gif');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    "
  >
    <div
      class="absolute inset-0 bg-gradient-to-b from-blue-700/95 to-blue-400/80 py-10 px-4 md:px-32 text-wrap text-white flex flex-col items-center justify-between"
    >
      <div class="text-center mt-16">
        <h1 class="text-white text-4xl md:text-8xl font-bold titleCG mb-4 animate-fade-in-down">
          <span class="pb-2 block">REAL-TIME CRIME </span> <span>MONITORING</span>
        </h1>
        <h3 class="text-white subCG text-md md:text-lg mb-6 animate-fade-in-up">
          Empowering Law Enforcement and Citizens for a Safer Community
        </h3>
      </div>

      <div
        class="border border-white p-4 md:p-6 rounded-lg text-white text-base md:text-lg my-2 w-full md:w-3/4 text-center backdrop-blur-sm bg-white/10 animate-fade-in"
      >
        <div class="text-wrap flex flex-col md:flex-row items-center md:items-start">
          <svg
            class="text-blue-100 w-16 h-16 md:w-20 md:h-20 mb-4 md:mb-0 md:me-5 animate-pulse"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <rect x="4" y="4" width="16" height="16" rx="2" ry="2" />
            <rect x="9" y="9" width="6" height="6" />
            <line x1="9" y1="1" x2="9" y2="4" />
            <line x1="15" y1="1" x2="15" y2="4" />
            <line x1="9" y1="20" x2="9" y2="23" />
            <line x1="15" y1="20" x2="15" y2="23" />
            <line x1="20" y1="9" x2="23" y2="9" />
            <line x1="20" y1="14" x2="23" y2="14" />
            <line x1="1" y1="9" x2="4" y2="9" />
            <line x1="1" y1="14" x2="4" y2="14" />
          </svg>
          <p class="md:border-s text-start md:px-4">
            CrimeGuard is a cutting-edge, real-time crime reporting and monitoring platform
            designed to revolutionize communication between citizens and law
            enforcement. It empowers communities by providing an intuitive interface for
            reporting crime incidents with precise location data, while equipping law
            enforcement agencies with advanced tools such as dynamic heatmaps, 
            predictive analytics, and real-time crime statistics dashboards.
          </p>
        </div>
      </div>

      <div class="text-center mt-4">
        <h4 class="text-lg md:text-xl flex items-center justify-center animate-bounce">
          <svg
            class="h-6 w-6 text-blue-50 mr-2"
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
          CrimeGuard: Modernizing crime reporting, tracking, and analysis for safer cities.
        </h4>
      </div>
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
</style>
