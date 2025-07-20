<template>
  <div class="relative howitworks-section py-20 bg-white overflow-hidden">
    <!-- Decorative floating circles (blue accent, subtle) -->
    <div class="absolute floating-circle circle-1"></div>
    <div class="absolute floating-circle circle-2"></div>
    <div class="absolute floating-circle circle-3"></div>
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
      <div class="text-center mb-12">
        <h2 class="text-3xl lg:text-5xl font-bold text-blue-900 mb-4 animate-fade-in-up">How It Works</h2>
        <p class="text-lg text-blue-600 animate-fade-in-up" style="animation-delay: 0.2s;">
          See how CrimeGuard empowers both citizens and officers in a few simple steps.
        </p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Citizen Steps -->
        <div>
          <h3 class="text-2xl font-semibold text-blue-700 mb-6 animate-fade-in-up">For Citizens</h3>
          <div class="space-y-8">
            <div v-for="(step, i) in citizenSteps" :key="step.title" class="flex items-start space-x-5 animate-fade-in-up" :style="`animation-delay: ${0.1 + i * 0.1}s;`">
              <div class="step-icon-box flex-shrink-0">
                <span v-html="step.icon"></span>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-blue-800 mb-1">{{ step.title }}</h4>
                <p class="text-blue-600 text-base">{{ step.desc }}</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Officer Steps -->
        <div>
          <h3 class="text-2xl font-semibold text-blue-700 mb-6 animate-fade-in-up">For Officers</h3>
          <div class="space-y-8">
            <div v-for="(step, i) in officerSteps" :key="step.title" class="flex items-start space-x-5 animate-fade-in-up" :style="`animation-delay: ${0.1 + i * 0.1}s;`">
              <div class="step-icon-box flex-shrink-0">
                <span v-html="step.icon"></span>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-blue-800 mb-1">{{ step.title }}</h4>
                <p class="text-blue-600 text-base">{{ step.desc }}</p>
              </div>
            </div>
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
      citizenSteps: [
        {
          title: 'Sign up or log in',
          desc: 'Create your account or log in to access personalized features and reporting.',
          icon: `<svg class='w-10 h-10 text-blue-500' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' d='M16 21v-2a4 4 0 00-3-3.87M12 7a4 4 0 110-8 4 4 0 010 8z'/></svg>`
        },
        {
          title: 'Tap the report button',
          desc: 'Quickly report an incident with your current location automatically included.',
          icon: `<svg class='w-10 h-10 text-blue-400' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><circle cx='12' cy='12' r='10'/><path stroke-linecap='round' stroke-linejoin='round' d='M12 8v4l3 3'/></svg>`
        },
        {
          title: 'Police receive & respond',
          desc: 'Your report is instantly sent to the nearest police station for rapid response.',
          icon: `<svg class='w-10 h-10 text-blue-600' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path d='M3 13l2-2m0 0l7-7 7 7M5 11v8a2 2 0 002 2h10a2 2 0 002-2v-8'/></svg>`
        },
        {
          title: 'Get notified of progress',
          desc: 'Receive real-time updates as officers resolve your reported incident.',
          icon: `<svg class='w-10 h-10 text-blue-700' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path d='M13 16h-1v-4h-1m1-4h.01'/></svg>`
        },
      ],
      officerSteps: [
        {
          title: 'Receive assigned incident',
          desc: 'Get notified instantly when a new incident is assigned to you or your team.',
          icon: `<svg class='w-10 h-10 text-blue-500' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'/></svg>`
        },
        {
          title: 'View map & location',
          desc: 'Access a real-time map with incident locations and details for effective response.',
          icon: `<svg class='w-10 h-10 text-blue-400' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path d='M9 20l-5.447-2.724A2 2 0 013 15.382V5.618a2 2 0 011.553-1.894l7-2.1a2 2 0 011.894 0l7 2.1A2 2 0 0121 5.618v9.764a2 2 0 01-1.553 1.894L15 20'/></svg>`
        },
        {
          title: 'Track allied locations',
          desc: 'See the real-time positions of fellow officers for coordinated action.',
          icon: `<svg class='w-10 h-10 text-blue-600' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><circle cx='12' cy='12' r='10'/><circle cx='12' cy='12' r='4'/></svg>`
        },
        {
          title: 'Update incident status',
          desc: 'Easily update the status of incidents as you progress through resolution.',
          icon: `<svg class='w-10 h-10 text-blue-700' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path d='M5 13l4 4L19 7'/></svg>`
        },
      ]
    }
  }
}
</script>

<style scoped>
.howitworks-section {
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
.step-icon-box {
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
.step-icon-box svg {
  display: block;
}
.step-icon-box:hover {
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
  .howitworks-section {
    min-height: 60vh;
  }
}
@media (max-width: 768px) {
  .howitworks-section {
    min-height: 100vh;
    padding-top: 3em;
  }
  .floating-circle {
    display: none;
  }
}
</style>