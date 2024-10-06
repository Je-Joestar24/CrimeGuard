<template>
  <div class="flex flex-col items-center justify-center w-full pt-10 relative">
    <h1
      v-motion-slide-visible-left
      class="text-4xl font-thin text-gray-800 tracking-wide uppercase py-4 border-b border-gray-500"
    >
      Our Dedicated Team
    </h1>
    <div
      class="absolute bottom-0 h-1/2 bg-gradient-to-t from-blue-500 to-blue-300 -z-10 opacity-90"
      style="width: 99.7vw"
    ></div>

    <div class="relative w-full max-w-7xl m-6">
      <div
        class="grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6"
      >
        <div
          v-motion-slide-visible-left
          v-for="person in persons"
          class="flex bg-white shadow-lg rounded-lg overflow-hidden card hover:shadow-xl transition-all duration-300 ease-in-out transform hover:-translate-y-2"
        >
          <div class="w-1/3 flex p-4 bg-sky-50">
            <img
              :src="person.profile"
              :alt="person.name"
              class="rounded-full w-32 h-32 mx-auto object-cover object-center my-auto border-4 border-sky-300"
            />
          </div>
          <div class="w-2/3 p-6">
            <h3 class="text-2xl font-bold mb-2 text-sky-800">
              {{ person.name }}
            </h3>
            <p class="text-gray-600 text-sm">{{ person.desc }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="to-blue-500 text-center text-white" style="width: 99.7vw">
      &copy; 2024 Crime Guard. All rights reserved.
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      persons: [
        {
          profile: "/storage/system/me.jpeg",
          name: "Jejomar Parrilla",
          desc: `
            Lead Developer & Fullstack Engineer: Specializing in Laravel,
            Vue.js, and Tailwind CSS. Responsible for designing and maintaining
            the backend infrastructure and ensuring smooth user-server
            communication.`,
        },

        {
          profile: "/storage/system/dante.jpg",
          name: "Dante Villalon",
          desc: `
            Data Analyst & Project Manager: Handles data collection and analysis
            while overseeing the project's progress and ensuring everything
            aligns with the timeline.`,
        },

        {
          profile: "/storage/system/sammer.jpeg",
          name: "Sammer Sanchez",
          desc: `
            UI/UX Designer: Focused on creating a seamless user interface and
            optimizing the overall experience for users.`,
        },
        {
          profile: "/storage/system/ADVISER.jpg",
          name: "Joscoro Cantero",
          desc: `Instructor at CICTE, Western Leyte College: Provides academic
            guidance and ensures the project adheres to best practices and
            institutional standards.`,
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
  transition: all 0.3s ease-in-out;
}
.card:hover {
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}
</style>