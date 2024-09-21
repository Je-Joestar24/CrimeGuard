<template>
  <div
    class=" mb-5"
    style="
      height: 95vh;
      background-image: url('https://i.pinimg.com/originals/43/ec/76/43ec7607b63c03eef9cb065df5b5fc15.gif');
      background-repeat: no-repeat;
      background-size: 100vw;
      background-position: center;
    "
  >
    <div
      class="bg-gradient-to-b from-blue-600/95 to-blue-400/80 py-10 px-32 text-wrap text-white flex flex-col items-center"
      style="height: 95vh"
    >
      <h1 class="text-white text-8xl mt-16 font-bold titleCG text-center mb-4">
        <span class="pb-2 block">REAL-TIME CRIME </span> <span>MONITORING</span>
      </h1>
      <h3 class="text-white subCG text-md text-center mb-6">
        Empowering Law Enforcement and Citizens for a Safer Community
      </h3>

      <div
        class="border border-white p-6 rounded-lg text-white text-lg my-2 mt-auto w-3/4 text-center"
      >
        <div class="text-wrap flex">
          <svg
            class="text-blue-100 inline w-20 h-20 me-5"
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
          <p class="border-s text-start px-2">
            CrimeGuard is a real-time crime reporting and monitoring platform
            designed to improve communication between citizens and law
            enforcement. It empowers the community by providing citizens with
            the ability to report crime incidents with precise location data,
            while giving law enforcement agencies access to advanced tools like
            heatmaps, predictive analytics, and real-time crime statistics.
          </p>
        </div>
      </div>

      <h4 class="text-center text-lg mt-2">
        <svg
          class="h-6 w-6 text-blue-50 inline mr-2"
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
        CrimeGuard aims to modernize how crime incidents are reported, tracked,
        and analyzed, making cities safer and more secure for all.
      </h4>
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
