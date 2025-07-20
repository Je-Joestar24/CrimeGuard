<template>
  <div class="relative usedtech-section py-16 bg-white overflow-hidden">
    <!-- Decorative floating circles (blue accent, subtle) -->
    <div class="absolute floating-circle circle-1"></div>
    <div class="absolute floating-circle circle-2"></div>
    <div class="absolute floating-circle circle-3"></div>
    <!-- Decorative blue gradient at the bottom -->
    <div class="absolute bottom-0 left-0 w-full h-1/4 bg-gradient-to-t from-blue-200 to-transparent opacity-80 -z-10"></div>
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
      <div class="text-center mb-10">
        <h2 class="text-3xl lg:text-5xl font-bold text-blue-900 mb-3 animate-fade-in-up">Technologies Used</h2>
        <p class="text-lg text-blue-600 animate-fade-in-up" style="animation-delay: 0.2s;">
          Powering CrimeGuard with modern, scalable, and robust technologies.
        </p>
      </div>
      <!-- Card Container -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <a
          v-for="(dt, i) in data"
          :key="dt.name"
          v-motion-slide-visible-right
          target="newtab"
          :href="dt.link"
          class="tech-card flex flex-col items-center p-4 bg-white rounded-xl shadow-md border border-blue-50 hover:shadow-xl hover:border-blue-400 transition-all duration-300 animate-fade-in-up"
          :style="`animation-delay: ${0.1 + i * 0.1}s;`"
        >
          <img
            :src="dt.icon"
            :alt="dt.name + ' Logo'"
            class="w-16 h-16 mb-3 object-contain animate-float"
          />
          <h3 class="text-base font-semibold text-blue-800">{{ dt.name }}</h3>
          <p class="text-blue-600 text-center text-xs mt-1">{{ dt.disc }}</p>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      data: [
        {
          link: "https://vuejs.org/",
          icon: "/images/system/Vuelog.png",
          name: "Vue.js",
          disc: `Vue.js is used as the frontend framework for building interactive user interfaces.`,
        },
        {
          link: "https://laravel.com/",
          icon: "/images/system/laravellog.png",
          name: "Laravel",
          disc: `Laravel serves as the backend framework, handling routing, authentication, and API development.`,
        },
        {
          link: "https://tailwindcss.com/",
          icon: "/images/system/tailwindlog.png",
          name: "Tailwind CSS",
          disc: `Tailwind CSS is used to style the application with a utility-first approach to design.`,
        },
        {
          link: "https://developers.google.com/maps/documentation/javascript",
          icon: "/images/system/googlelog.png",
          name: "Google Maps API",
          disc: `Google Maps API is integrated for real-time location tracking and map-based crime monitoring.`,
        },
      ],
    };
  },
};
</script>
<style scoped>
.usedtech-section {
  min-height: 40vh;
}
.floating-circle {
  border-radius: 50%;
  position: absolute;
  opacity: 0.12;
  z-index: 0;
  background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
  animation: float 7s ease-in-out infinite;
}
.circle-1 {
  width: 100px;
  height: 100px;
  top: 10%;
  left: 5%;
  animation-delay: 0s;
}
.circle-2 {
  width: 70px;
  height: 70px;
  bottom: 15%;
  right: 10%;
  animation-delay: 2s;
}
.circle-3 {
  width: 50px;
  height: 50px;
  top: 60%;
  left: 40%;
  animation-delay: 4s;
}
@keyframes float {
  0%, 100% { transform: translateY(0px) scale(1); }
  50% { transform: translateY(-12px) scale(1.06); }
}
.tech-card {
  min-width: 0;
  max-width: 220px;
  margin-left: auto;
  margin-right: auto;
  background: #fff;
  border-radius: 1rem;
  box-shadow: 0 2px 12px 0 rgba(59,130,246,0.06);
  border: 2px solid transparent;
  transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
}
.tech-card:hover {
  transform: translateY(-8px) scale(1.05) rotate(-2deg);
  box-shadow: 0 8px 32px 0 rgba(59,130,246,0.14);
  border-color: #3b82f6;
}
.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out;
}
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
@keyframes float {
  0%, 100% { transform: translateY(0px) scale(1); }
  50% { transform: translateY(-12px) scale(1.06); }
}
@media (max-width: 1024px) {
  .usedtech-section {
    min-height: 30vh;
  }
}
@media (max-width: 768px) {
  .usedtech-section {
    min-height: 20vh;
    padding-top: 2em;
    padding-bottom: 2em;
  }
  .floating-circle {
    display: none;
  }
  .tech-card {
    max-width: 100%;
  }
}
</style>
  