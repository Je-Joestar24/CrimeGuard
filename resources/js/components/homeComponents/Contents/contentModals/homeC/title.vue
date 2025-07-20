<template>
  <div
    class="relative overflow-hidden"
    style="
      height: 100vh;
      background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
    "
  >
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
      <!-- Floating Circles -->
      <div class="floating-circle circle-1"></div>
      <div class="floating-circle circle-2"></div>
      <div class="floating-circle circle-3"></div>
      <div class="floating-circle circle-4"></div>
      
      <!-- Grid Pattern -->
      <div class="grid-pattern"></div>
      
      <!-- Animated Lines -->
      <div class="animated-line line-1"></div>
      <div class="animated-line line-2"></div>
      <div class="animated-line line-3"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 h-full flex items-center">
      <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          
          <!-- Left Column - Content -->
          <div class="text-white space-y-8 animate-fade-in-left">
            <!-- Main Title -->
            <div class="space-y-4">
              <h1 class="text-4xl lg:text-6xl xl:text-7xl font-bold leading-tight">
                <span class="block animate-slide-in-up" style="animation-delay: 0.2s;">
                  REAL-TIME
                </span>
                <span class="block text-blue-200 animate-slide-in-up" style="animation-delay: 0.4s;">
                  CRIME
                </span>
                <span class="block animate-slide-in-up" style="animation-delay: 0.6s;">
                  MONITORING
                </span>
              </h1>
              
              <!-- Subtitle -->
              <p class="text-lg lg:text-xl text-blue-100 animate-fade-in-up" style="animation-delay: 0.8s;">
                Empowering Law Enforcement and Citizens for a Safer Community
              </p>
            </div>

            <!-- Description Card -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 animate-fade-in-up" style="animation-delay: 1s;">
              <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                  <div class="w-12 h-12 bg-blue-400 rounded-xl flex items-center justify-center animate-pulse">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                </div>
                <p class="text-blue-50 leading-relaxed">
                  CrimeGuard is a cutting-edge, real-time crime reporting and monitoring platform
                  designed to revolutionize communication between citizens and law enforcement.
                </p>
              </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up" style="animation-delay: 1.2s;">
              <button @click.prevent="changeActive('Sign up')" class="group relative px-8 py-4 bg-white text-blue-600 rounded-xl font-semibold text-lg transition-all duration-300 hover:bg-blue-50 hover:scale-105 hover:shadow-2xl">
                <span class="relative z-10">Get Started</span>
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <span class="absolute inset-0 bg-white rounded-xl group-hover:bg-transparent transition-colors duration-300"></span>
              </button>
              
              <button class="group px-8 py-4 border-2 border-white/30 text-white rounded-xl font-semibold text-lg transition-all duration-300 hover:bg-white/10 hover:border-white/50 hover:scale-105 backdrop-blur-sm">
                <span class="flex items-center justify-center space-x-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span>Learn More</span>
                </span>
              </button>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 1.4s;">
              <div class="text-center">
                <div class="text-2xl lg:text-3xl font-bold text-blue-200">24/7</div>
                <div class="text-sm text-blue-100">Monitoring</div>
              </div>
              <div class="text-center">
                <div class="text-2xl lg:text-3xl font-bold text-blue-200">Real-time</div>
                <div class="text-sm text-blue-100">Updates</div>
              </div>
              <div class="text-center">
                <div class="text-2xl lg:text-3xl font-bold text-blue-200">Secure</div>
                <div class="text-sm text-blue-100">Platform</div>
              </div>
            </div>
          </div>

          <!-- Right Column - Decorative Elements -->
          <div class="relative h-full flex items-center justify-center animate-fade-in-right">
            <!-- Main Decorative Element -->
            <div class="relative w-80 h-80 lg:w-96 lg:h-96">
              <!-- Central Shield -->
              <div class="absolute inset-0 flex items-center justify-center">
                <div class="shield-container">
                  <div class="shield">
                    <svg class="w-full h-full" viewBox="0 0 200 200" fill="none">
                      <path d="M100 20L180 60V120C180 160 140 180 100 180C60 180 20 160 20 120V60L100 20Z" 
                            class="shield-path" 
                            stroke="rgba(255,255,255,0.3)" 
                            stroke-width="2" 
                            fill="rgba(255,255,255,0.1)"/>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Rotating Rings -->
              <div class="absolute inset-0 flex items-center justify-center">
                <div class="ring ring-1"></div>
                <div class="ring ring-2"></div>
                <div class="ring ring-3"></div>
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

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
      <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
        <div class="w-1 h-3 bg-white/50 rounded-full mt-2 animate-pulse"></div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Floating Circles */
.floating-circle {
  position: absolute;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.1);
  animation: float 6s ease-in-out infinite;
}

.circle-1 {
  width: 100px;
  height: 100px;
  top: 10%;
  left: 10%;
  animation-delay: 0s;
}

.circle-2 {
  width: 150px;
  height: 150px;
  top: 60%;
  right: 15%;
  animation-delay: 2s;
}

.circle-3 {
  width: 80px;
  height: 80px;
  bottom: 20%;
  left: 20%;
  animation-delay: 4s;
}

.circle-4 {
  width: 120px;
  height: 120px;
  top: 30%;
  right: 30%;
  animation-delay: 1s;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(180deg); }
}

/* Grid Pattern */
.grid-pattern {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: 
    linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);
  background-size: 50px 50px;
  animation: grid-move 20s linear infinite;
}

@keyframes grid-move {
  0% { transform: translate(0, 0); }
  100% { transform: translate(50px, 50px); }
}

/* Animated Lines */
.animated-line {
  position: absolute;
  height: 2px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  animation: line-flow 3s linear infinite;
}

.line-1 {
  width: 200px;
  top: 20%;
  left: -200px;
  animation-delay: 0s;
}

.line-2 {
  width: 150px;
  top: 50%;
  right: -150px;
  animation-delay: 1s;
}

.line-3 {
  width: 180px;
  bottom: 30%;
  left: -180px;
  animation-delay: 2s;
}

@keyframes line-flow {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(calc(100vw + 100%)); }
}

/* Shield Animation */
.shield-container {
  animation: shield-float 4s ease-in-out infinite;
}

.shield {
  width: 200px;
  height: 200px;
}

.shield-path {
  animation: shield-glow 2s ease-in-out infinite alternate;
}

@keyframes shield-float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-10px) rotate(5deg); }
}

@keyframes shield-glow {
  0% { filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.5)); }
  100% { filter: drop-shadow(0 0 20px rgba(59, 130, 246, 0.8)); }
}

/* Rotating Rings */
.ring {
  position: absolute;
  border: 2px solid rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  animation: ring-rotate 10s linear infinite;
}

.ring-1 {
  width: 300px;
  height: 300px;
  animation-direction: normal;
}

.ring-2 {
  width: 250px;
  height: 250px;
  animation-direction: reverse;
  animation-duration: 8s;
}

.ring-3 {
  width: 200px;
  height: 200px;
  animation-direction: normal;
  animation-duration: 12s;
}

@keyframes ring-rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Floating Icons */
.floating-icon {
  position: absolute;
  animation: icon-float 4s ease-in-out infinite;
}

.icon-1 {
  top: 20%;
  right: 10%;
  animation-delay: 0s;
}

.icon-2 {
  bottom: 30%;
  left: 10%;
  animation-delay: 2s;
}

.icon-3 {
  top: 60%;
  right: 30%;
  animation-delay: 4s;
}

@keyframes icon-float {
  0%, 100% { transform: translateY(0px) scale(1); }
  50% { transform: translateY(-15px) scale(1.1); }
}

/* Pulse Effect */
.pulse-circle {
  width: 200px;
  height: 200px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
  0% { transform: scale(0.8); opacity: 1; }
  100% { transform: scale(1.2); opacity: 0; }
}

/* Content Animations */
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

/* Responsive adjustments */
@media (max-width: 1024px) {
  .shield {
    width: 150px;
    height: 150px;
  }
  
  .ring-1 { width: 250px; height: 250px; }
  .ring-2 { width: 200px; height: 200px; }
  .ring-3 { width: 150px; height: 150px; }
}

@media (max-width: 768px) {
  .floating-circle {
    display: none;
  }
  
  .grid-pattern {
    opacity: 0.3;
  }
}
</style>

<script>
export default{
  props: ["active", "changeActive"],
}
</script>