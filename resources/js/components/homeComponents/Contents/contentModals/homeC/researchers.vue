<template>
  <div class="relative team-section py-20 overflow-hidden">
    <!-- Decorative blue floating circles -->
    <div class="absolute floating-circle circle-1"></div>
    <div class="absolute floating-circle circle-2"></div>
    <div class="absolute floating-circle circle-3"></div>
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
      <div class="text-center mb-12">
        <h2 class="text-3xl lg:text-5xl font-bold text-blue-900 mb-4 animate-fade-in-up">Our Dedicated Team</h2>
        <p class="text-lg text-blue-600 animate-fade-in-up" style="animation-delay: 0.2s;">
          Meet the passionate individuals behind CrimeGuard.
        </p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        <div
          v-for="(person, i) in persons"
          :key="person.name"
          class="team-card bg-white rounded-2xl shadow-xl border border-blue-100 flex flex-col items-center p-8 animate-fade-in-up"
          :style="`animation-delay: ${0.1 + i * 0.1}s;`"
        >
          <div class="relative mb-6">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-200 shadow-lg flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
              <img
                :src="person.profile"
                :alt="person.name"
                class="w-full h-full object-cover object-center transition-transform duration-300 transform hover:scale-105"
              />
            </div>
            <!-- Floating blue accent -->
            <div class="absolute -top-4 -right-4 w-8 h-8 rounded-full bg-blue-400 opacity-30 animate-float"></div>
          </div>
          <h3 class="text-xl font-semibold text-blue-800 mb-1">{{ person.name }}</h3>
          <p class="text-blue-400 font-medium mb-2">{{ person.role }}</p>
          <p class="text-gray-500 text-center text-base mb-4">{{ person.desc }}</p>
          <div class="flex justify-center space-x-4 mt-auto">
            <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
              </svg>
            </a>
            <a target="newtab" :href="person.github ? person.github : '#'" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
              </svg>
            </a>
            <a target="newtab" :href="person.facebook ? person.facebook : '#'" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      persons: [
        {
          profile: "/images/Jejomar.png",
          name: "Jejomar Parrilla",
          role: "Lead Developer & Fullstack Engineer",
          desc: `Specializing in Laravel, Vue.js, and Tailwind CSS. Responsible for designing and maintaining the backend infrastructure and ensuring smooth user-server communication.`,
          github: "https://github.com/Je-Joestar24",
          facebook: "https://www.facebook.com/jejomar.parrilla"
        },
        {
          profile: "/images/Dante.png",
          name: "Dante Villalon",
          role: "Data Analyst & Project Manager",
          desc: `Handles data collection and analysis while overseeing the project’s progress and ensuring everything aligns with the timeline.`,
        },
        {
          profile: "/images/Sammer.png",
          name: "Sammer Sanchez",
          role: "UI/UX Designer",
          desc: `Focused on creating a seamless user interface and optimizing the overall experience for users.`,
        },
      ],
    };
  },
};
</script>

<style scoped>
.team-section {
  min-height: 80vh;
  background: #f8fafc;
}
.floating-circle {
  border-radius: 50%;
  position: absolute;
  opacity: 0.13;
  z-index: 0;
  background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
  animation: float 7s ease-in-out infinite;
}
.circle-1 {
  width: 120px;
  height: 120px;
  top: 8%;
  left: 6%;
  animation-delay: 0s;
}
.circle-2 {
  width: 90px;
  height: 90px;
  bottom: 12%;
  right: 8%;
  animation-delay: 2s;
}
.circle-3 {
  width: 60px;
  height: 60px;
  top: 60%;
  left: 45%;
  animation-delay: 4s;
}
@keyframes float {
  0%, 100% { transform: translateY(0px) scale(1); }
  50% { transform: translateY(-18px) scale(1.08); }
}
.team-card {
  transition: transform 0.3s, box-shadow 0.3s;
  box-shadow: 0 4px 24px 0 rgba(59,130,246,0.08);
  border: 2px solid transparent;
}
.team-card:hover {
  transform: translateY(-8px) scale(1.03);
  box-shadow: 0 8px 32px 0 rgba(59,130,246,0.16);
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
@media (max-width: 1024px) {
  .team-section {
    min-height: 60vh;
  }
}
@media (max-width: 768px) {
  .team-section {
    min-height: 100vh;
    padding-top: 3em;
  }
  .floating-circle {
    display: none;
  }
}
</style>