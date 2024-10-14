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
    <div class="relative w-full max-w-7xl mx-auto my-16">
      <div class="flex flex-wrap justify-center items-stretch gap-8">
        <div
          v-for="person in persons"
          :key="person.name"
          v-motion-slide-visible-bottom
          class="flex flex-col bg-white shadow-sm rounded-lg overflow-hidden card hover:shadow-md transition-all duration-300 ease-in-out transform hover:-translate-y-1 max-w-xs w-full sm:w-1/2 lg:w-1/3"
        >
          <div class="relative h-56 bg-gradient-to-br from-blue-100 to-blue-200 overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center">
              <img
                :src="person.profile"
                :alt="person.name"
                class="w-40 h-40 rounded-full object-cover object-center transition-transform duration-300 transform hover:scale-105"
              />
            </div>
          </div>
          <div class="p-6 text-center flex-grow">
            <h3 class="text-xl font-medium mb-2 text-gray-700">
              {{ person.name }}
            </h3>
            <p class="text-blue-400 font-medium mb-3">{{ person.role }}</p>
            <p class="text-gray-500 text-sm leading-relaxed">{{ person.desc }}</p>
          </div>
          <div class="p-4 bg-gray-50 border-t border-gray-100">
            <div class="flex justify-center space-x-4">
              <a href="#" class="text-gray-400 hover:text-blue-300 transition-colors duration-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                </svg>
              </a>
              <a href="#" class="text-gray-400 hover:text-blue-300 transition-colors duration-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                </svg>
              </a>
              <a href="#" class="text-gray-400 hover:text-blue-300 transition-colors duration-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clip-rule="evenodd"></path>
                </svg>
              </a>
            </div>
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
/*         {
          profile: "/storage/system/ADVISER.jpg",
          name: "Joscoro Cantero",
          desc: `Instructor at CICTE, Western Leyte College: Provides academic
            guidance and ensures the project adheres to best practices and
            institutional standards.`,
        }, */
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