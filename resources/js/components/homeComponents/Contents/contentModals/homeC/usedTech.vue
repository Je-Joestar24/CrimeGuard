<template>
  <div class="container mx-auto py-16">
    <!-- Card Container -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <a
        v-for="dt in data"
        v-motion-slide-visible-right
        target="newtab"
        :href="dt.link"
        class="card flex flex-col items-center p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
      >
        <img
          :src="dt.icon"
          alt="Laravel Logo"
          class="w-24 h-24 mb-4 object-contain"
        />
        <h3 class="text-lg font-semibold text-gray-700">{{ dt.name }}</h3>
        <p class="text-gray-600 text-center mt-2">
          {{ dt.disc }}
        </p>
      </a>
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
          disc: ` Vue.js is used as the frontend framework for building interactive user interfaces.`,
        },
        {
          link: "https://laravel.com/",
          icon: "/images/system/laravellog.png",
          name: "Laravel",
          disc: `Laravel serves as the backend framework, handling routing,
        authentication, and API development.`,
        },
        {
          link: "https://tailwindcss.com/",
          icon: "/images/system/tailwindlog.png",
          name: "Tailwind CSS",
          disc: `Tailwind CSS is used to style the application with a utility-first
        approach to design.`,
        },
        {
          link: "https://developers.google.com/maps/documentation/javascript",
          icon: "/images/system/googlelog.png",
          name: "Google Maps API",
          disc: `Google Maps API is integrated for real-time location tracking and
        map-based crime monitoring.`,
        },
      ],
    };
  },
};
</script>
  <style scoped>
.container {
  max-width: 1200px;
}
.card {
  background-color: #ffffff;
  border-radius: 10px;
  transition: transform 0.2s ease-in-out;
}
.card:hover {
  transform: translateY(-5px);
}
</style>
  