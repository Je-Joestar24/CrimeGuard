<template>
  <div class="flex flex-col items-center justify-center w-full py-10 px-2">
    <h1
      v-motion-slide-visible-left
      class="text-2xl font-thin text-gray-800 tracking-wide uppercase py-4 border-b border-gray-500"
    >
      Our Dedicated Team
    </h1>
    <div class="grid grid-cols-1 gap-3  w-full max-w-7xl m-6">
      <!-- Team Member 1 -->
      <div
        v-motion-slide-visible-left
        v-for="person in persons"
        class="flex bg-white shadow-lg rounded-lg overflow-hidden card hover:shadow-xl transition-shadow duration-300 ease-in-out"
      >
        <div class="w-1/4 flex   p-4">
          <img
            :src="person.profile"
            :alt="person.name"
            class=" w-20 h-20 mx-auto object-cover rounded-md object-center my-auto"
          />
        </div>
        <div class="w-3/4 p-6">
          <h3 class="text-lg font-bold mb-2">{{ person.name }}</h3>
          <p class="text-gray-600 text-xs">{{ person.desc }}</p>
        </div>
      </div>
    </div>
  </div>
  
  <div
    class="w-full bg-gray-50 text-center text-gray-600"
    style="height: 20px; line-height: 20px"
  >
    &copy; 2024 Crime Guard. All rights reserved.
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
            while overseeing the project’s progress and ensuring everything
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
  transition: transform 0.2s ease-in-out;
}
.card:hover {
  transform: translateY(-5px);
}
</style>