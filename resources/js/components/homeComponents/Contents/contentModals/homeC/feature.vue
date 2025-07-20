<template>
  <div class="relative features-section py-20 bg-white overflow-hidden">
    <!-- Decorative floating circles (blue accent, subtle) -->
    <div class="absolute floating-circle circle-1"></div>
    <div class="absolute floating-circle circle-2"></div>
    <div class="absolute floating-circle circle-3"></div>
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
      <div class="text-center mb-12">
        <h2 class="text-3xl lg:text-5xl font-bold text-blue-900 mb-4 animate-fade-in-up">Key Features</h2>
        <p class="text-lg text-blue-600 animate-fade-in-up" style="animation-delay: 0.2s;">
          Discover how CrimeGuard empowers communities and law enforcement with modern tools.
        </p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Feature Card -->
        <div v-for="(feature, i) in features" :key="feature.title" class="flex items-start space-x-5 bg-white rounded-2xl shadow-lg p-6 border border-blue-50 animate-fade-in-up" :style="`animation-delay: ${0.1 + i * 0.1}s;`">
          <div class="icon-box flex-shrink-0">
            <span v-html="feature.icon"></span>
          </div>
          <div>
            <h3 class="text-xl font-semibold text-blue-800 mb-1">{{ feature.title }}</h3>
            <p class="text-blue-600 text-base">{{ feature.desc }}</p>
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
      features: [
        {
          title: 'Real-Time Crime Monitoring',
          desc: 'Stay updated with live crime reports and incident status as they happen across your community.',
          icon: `<svg class='w-10 h-10 text-blue-500' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'/></svg>`
        },
        {
          title: 'Heatmap Visualization',
          desc: 'Visualize crime hotspots and trends with interactive, color-coded heatmaps for better situational awareness.',
          icon: `<svg class='w-10 h-10 text-blue-400' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><circle cx='12' cy='12' r='10' stroke='currentColor' stroke-width='2'/><circle cx='12' cy='12' r='6' stroke='currentColor' stroke-width='2' opacity='0.5'/><circle cx='12' cy='12' r='2' fill='currentColor'/></svg>`
        },
        {
          title: 'Centralized Crime Reporting',
          desc: 'Easily report incidents from any device, ensuring all data is collected in a single, secure platform.',
          icon: `<svg class='w-10 h-10 text-blue-600' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' d='M12 20h9'/><path stroke-linecap='round' stroke-linejoin='round' d='M16.5 3.5a2.121 2.121 0 113 3L7 19.5 3 21l1.5-4L16.5 3.5z'/></svg>`
        },
        {
          title: 'Analytics Dashboard',
          desc: 'Access actionable insights and predictive analytics to support data-driven decision making.',
          icon: `<svg class='w-10 h-10 text-blue-700' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' d='M11 19V6a1 1 0 112 0v13a1 1 0 11-2 0zM5 13v6a1 1 0 102 0v-6a1 1 0 10-2 0zm12-8v14a1 1 0 102 0V5a1 1 0 10-2 0z'/></svg>`
        },
        {
          title: 'Closest Station Assignment',
          desc: 'Automatically assign incidents to the nearest police station for faster response times.',
          icon: `<svg class='w-10 h-10 text-blue-500' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' d='M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z'/><circle cx='12' cy='9' r='2.5' fill='currentColor'/></svg>`
        },
        {
          title: 'Role-Based Access',
          desc: 'Custom experiences and permissions for citizens, officers, and admins to ensure data privacy and security.',
          icon: `<svg class='w-10 h-10 text-blue-400' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><circle cx='12' cy='7' r='4'/><path stroke-linecap='round' stroke-linejoin='round' d='M6 21v-2a4 4 0 014-4h0a4 4 0 014 4v2'/></svg>`
        },
        {
          title: 'Incident and User Tracking',
          desc: 'Track the status of incidents and user activity for transparency and accountability.',
          icon: `<svg class='w-10 h-10 text-blue-600' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'/></svg>`
        },
      ]
    }
  }
}
</script>

<style scoped>
.features-section {
  min-height: 80vh;
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
  width: 120px;
  height: 120px;
  top: 10%;
  left: 5%;
  animation-delay: 0s;
}
.circle-2 {
  width: 90px;
  height: 90px;
  bottom: 15%;
  right: 10%;
  animation-delay: 2s;
}
.circle-3 {
  width: 60px;
  height: 60px;
  top: 60%;
  left: 40%;
  animation-delay: 4s;
}
@keyframes float {
  0%, 100% { transform: translateY(0px) scale(1); }
  50% { transform: translateY(-18px) scale(1.08); }
}
.icon-box {
  width: 56px;
  height: 56px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #e0e7ff 0%, #f0f9ff 100%);
  border-radius: 1.5rem;
  box-shadow: 0 4px 24px 0 rgba(59,130,246,0.08);
  margin-right: 0.5rem;
  margin-top: 0.25rem;
  margin-bottom: 0.25rem;
  transition: transform 0.3s;
}
.icon-box svg {
  display: block;
}
.icon-box:hover {
  transform: scale(1.08) rotate(-3deg);
  box-shadow: 0 8px 32px 0 rgba(59,130,246,0.12);
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
  .features-section {
    min-height: 60vh;
  }
}
@media (max-width: 768px) {
  .features-section {
    min-height: 100vh;
    padding-top: 3em;
  }
  .floating-circle {
    display: none;
  }
}
</style>