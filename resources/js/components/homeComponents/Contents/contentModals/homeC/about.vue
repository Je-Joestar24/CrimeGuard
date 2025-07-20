<template>
  <div class="relative overflow-hidden about-section" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="floating-circle circle-1"></div>
      <div class="floating-circle circle-2"></div>
      <div class="floating-circle circle-3"></div>
      <div class="grid-pattern"></div>
      <div class="animated-line line-1"></div>
      <div class="animated-line line-2"></div>
    </div>
    <div class="relative z-10 h-full flex items-center py-20">
      <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <!-- Left Column: Mission & Vision -->
          <div class="text-white space-y-8 animate-fade-in-left">
            <div class="space-y-4 app__main-title">
              <h2 class="text-3xl lg:text-5xl font-bold leading-tight animate-slide-in-up" style="animation-delay: 0.2s;">
                About <span class="text-blue-200">CrimeGuard</span>
              </h2>
              <p class="text-lg lg:text-xl text-blue-100 animate-fade-in-up" style="animation-delay: 0.4s;">
                CrimeGuard is dedicated to building safer, smarter communities through real-time crime reporting, monitoring, and analytics.
              </p>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 animate-fade-in-up" style="animation-delay: 0.6s;">
              <h3 class="text-xl font-semibold text-blue-200 mb-2">Our Mission</h3>
              <ul class="list-disc list-inside text-blue-50 space-y-1">
                <li>Empower citizens, police, and local government with transparent, real-time crime data.</li>
                <li>Facilitate rapid, accurate reporting and response to incidents.</li>
                <li>Foster trust and collaboration between the community and law enforcement.</li>
              </ul>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 animate-fade-in-up" style="animation-delay: 0.8s;">
              <h3 class="text-xl font-semibold text-blue-200 mb-2">Our Vision</h3>
              <ul class="list-disc list-inside text-blue-50 space-y-1">
                <li>To create a future where every community is empowered to prevent and respond to crime.</li>
                <li>To be the leading platform for real-time, data-driven public safety.</li>
              </ul>
            </div>
            <div class="animate-fade-in-up" style="animation-delay: 1s;">
              <h4 class="text-lg font-semibold text-blue-100 mb-1">Who is CrimeGuard for?</h4>
              <div class="flex flex-wrap gap-3">
                <span class="px-4 py-2 rounded-full bg-blue-600/80 text-white font-medium shadow-md animate-slide-in-up" style="animation-delay: 1.1s;">Citizens</span>
                <span class="px-4 py-2 rounded-full bg-blue-500/80 text-white font-medium shadow-md animate-slide-in-up" style="animation-delay: 1.2s;">Police</span>
                <span class="px-4 py-2 rounded-full bg-blue-400/80 text-white font-medium shadow-md animate-slide-in-up" style="animation-delay: 1.3s;">Local Government</span>
              </div>
            </div>
          </div>
          <!-- Right Column: Decorative Elements -->
          <div class="relative h-full flex items-center justify-center animate-fade-in-right">
            <div class="relative w-80 h-80 lg:w-96 lg:h-96">
              <!-- Central Globe/Network -->
              <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-full h-full" viewBox="0 0 200 200" fill="none">
                  <circle cx="100" cy="100" r="80" stroke="rgba(255,255,255,0.2)" stroke-width="2" fill="rgba(59,130,246,0.08)"/>
                  <circle cx="100" cy="100" r="60" stroke="rgba(59,130,246,0.2)" stroke-width="2" fill="none"/>
                  <circle cx="100" cy="100" r="40" stroke="rgba(59,130,246,0.3)" stroke-width="2" fill="none"/>
                  <g>
                    <circle cx="60" cy="80" r="7" fill="#3b82f6" class="animate-pulse"/>
                    <circle cx="140" cy="60" r="6" fill="#60a5fa" class="animate-pulse"/>
                    <circle cx="120" cy="140" r="8" fill="#1e3a8a" class="animate-pulse"/>
                    <circle cx="80" cy="120" r="5" fill="#2563eb" class="animate-pulse"/>
                  </g>
                  <polyline points="60,80 100,100 140,60" stroke="#3b82f6" stroke-width="2" fill="none"/>
                  <polyline points="80,120 100,100 120,140" stroke="#60a5fa" stroke-width="2" fill="none"/>
                </svg>
              </div>
              <!-- Floating Icons -->
              <div class="absolute inset-0">
                <div class="floating-icon icon-1">
                  <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                </div>
                <div class="floating-icon icon-2">
                  <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                  </svg>
                </div>
                <div class="floating-icon icon-3">
                  <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                  </svg>
                </div>
              </div>
              <!-- Pulse Effect -->
              <div class="absolute inset-0 flex items-center justify-center">
                <div class="pulse-circle"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.about-section {
  min-height: 80vh;
}
.floating-circle {
  position: absolute;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.1);
  animation: float 6s ease-in-out infinite;
}
.circle-1 {
  width: 80px;
  height: 80px;
  top: 15%;
  left: 15%;
  animation-delay: 0s;
}
.circle-2 {
  width: 120px;
  height: 120px;
  top: 60%;
  right: 10%;
  animation-delay: 2s;
}
.circle-3 {
  width: 60px;
  height: 60px;
  bottom: 20%;
  left: 25%;
  animation-delay: 4s;
}
@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(180deg); }
}
.grid-pattern {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: 
    linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px);
  background-size: 50px 50px;
  animation: grid-move 20s linear infinite;
}
@keyframes grid-move {
  0% { transform: translate(0, 0); }
  100% { transform: translate(50px, 50px); }
}
.animated-line {
  position: absolute;
  height: 2px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  animation: line-flow 3s linear infinite;
}
.line-1 {
  width: 160px;
  top: 25%;
  left: -160px;
  animation-delay: 0s;
}
.line-2 {
  width: 120px;
  top: 55%;
  right: -120px;
  animation-delay: 1s;
}
@keyframes line-flow {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(calc(100vw + 100%)); }
}
.pulse-circle {
  width: 180px;
  height: 180px;
  border: 2px solid rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse {
  0% { transform: scale(0.8); opacity: 1; }
  100% { transform: scale(1.2); opacity: 0; }
}
.floating-icon {
  position: absolute;
  animation: icon-float 4s ease-in-out infinite;
}
.icon-1 {
  top: 18%;
  right: 12%;
  animation-delay: 0s;
}
.icon-2 {
  bottom: 28%;
  left: 12%;
  animation-delay: 2s;
}
.icon-3 {
  top: 65%;
  right: 28%;
  animation-delay: 4s;
}
@keyframes icon-float {
  0%, 100% { transform: translateY(0px) scale(1); }
  50% { transform: translateY(-12px) scale(1.08); }
}
.animate-fade-in-left {
  animation: fadeInLeft 1s ease-out;
}
.animate-fade-in-right {
  animation: fadeInRight 1s ease-out;
}
.animate-slide-in-up {
  animation: slideInUp 0.8s ease-out;
}
.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out;
}
@keyframes fadeInLeft {
  from {
    opacity: 0;
    transform: translateX(-50px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
@keyframes fadeInRight {
  from {
    opacity: 0;
    transform: translateX(50px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
@keyframes slideInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
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
  .about-section {
    min-height: 60vh;
  }
}
@media (max-width: 768px) {
  .about-section {
    min-height: 100vh;
    padding-top: 4em;
  }
  .app__main-title{
    margin-top: 4em;
  }
  .floating-circle {
    display: none;
  }
  .grid-pattern {
    opacity: 0.3;
  }
}
</style>