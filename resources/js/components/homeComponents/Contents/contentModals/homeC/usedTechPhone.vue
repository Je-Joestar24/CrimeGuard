<template>
  <div style="height: 15vh; width: 100vw">
    <div class="flex flex-row gap-1 px-1">
      <a
        v-for="dt in data"
        v-motion-pop-visible
        :href="dt.link"
        class="flex mx-auto flex-col items-center bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 w-24 h-24"
      >
        <img
          :src="dt.icon"
          alt="Laravel Logo"
          class="w-12 h-12 m-auto object-contain"
        />
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

  