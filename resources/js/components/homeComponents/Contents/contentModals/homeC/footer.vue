<template>
  <footer class="footer-section relative py-8 px-4 lg:px-12 flex flex-col md:flex-row items-center justify-between overflow-hidden">
    <!-- Decorative floating circles -->
    <div class="absolute floating-circle circle-1"></div>
    <div class="absolute floating-circle circle-2"></div>
    <div class="absolute floating-circle circle-3"></div>
    <!-- Left: Logo and App Name -->
    <div class="flex items-center space-x-4 z-10 mb-6 md:mb-0 animate-fade-in-left">
      <img src="/images/system/bg.png" alt="CrimeGuard Logo" class="w-14 h-14 rounded-lg shadow-lg object-cover" />
      <span class="text-2xl font-bold text-white tracking-wide">CrimeGuard</span>
    </div>
    <!-- Copyright -->
    <div class="w-full text-center text-blue-100 text-sm mt-8 opacity-80 animate-fade-in-up" style="animation-delay: 0.8s;">
      &copy; 2024 CrimeGuard. All rights reserved.
    </div>
    <!-- Right: Socials, Buttons, Portfolio -->
    <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-8 z-10 animate-fade-in-right">
      <div class="flex space-x-4">
        <a href="https://github.com/Je-Joestar24/CG-Lmix" target="_blank" class="footer-icon group">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
        </a>
        <a href="https://www.facebook.com/jejomar.parrilla" target="_blank" class="footer-icon group">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </a>
        <a href="https://instagram.com/jejomar.parrilla" target="_blank" class="footer-icon group">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5zm4.25 2.25a5.25 5.25 0 1 1-5.25 5.25A5.25 5.25 0 0 1 12 5.75zm0 1.5a3.75 3.75 0 1 0 3.75 3.75A3.75 3.75 0 0 0 12 7.25zm5.25.75a1 1 0 1 1-1 1 1 1 0 0 1 1-1z"/></svg>
        </a>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer-section {
  background-color: rgb(29 78 216);
  min-height: 20vh;
  position: relative;
  z-index: 1;
}
.floating-circle {
  border-radius: 50%;
  position: absolute;
  opacity: 0.10;
  z-index: 0;
  background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
  animation: float 7s ease-in-out infinite;
}
.circle-1 {
  width: 100px;
  height: 100px;
  top: 10%;
  left: 5%;
  animation-delay: 0s;
}
.circle-2 {
  width: 80px;
  height: 80px;
  bottom: 10%;
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
  50% { transform: translateY(-14px) scale(1.06); }
}
.footer-icon {
  color: #93c5fd;
  transition: color 0.3s, transform 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
}
.footer-icon:hover {
  color: #fff;
  transform: scale(1.15) rotate(-6deg);
}
.footer-btn {
  font-size: 1rem;
  box-shadow: 0 2px 12px 0 rgba(59,130,246,0.08);
  transition: transform 0.3s, box-shadow 0.3s;
}
.footer-btn:hover {
  transform: scale(1.08) rotate(-2deg);
  box-shadow: 0 6px 24px 0 rgba(59,130,246,0.16);
}
.animate-fade-in-left {
  animation: fadeInLeft 0.8s ease-out;
}
.animate-fade-in-right {
  animation: fadeInRight 0.8s ease-out;
}
.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out;
}
@keyframes fadeInLeft {
  from {
    opacity: 0;
    transform: translateX(-30px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
@keyframes fadeInRight {
  from {
    opacity: 0;
    transform: translateX(30px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
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
  .footer-section {
    flex-direction: column;
    text-align: center;
    padding: 2em 1em;
  }
}
@media (max-width: 768px) {
  .footer-section {
    flex-direction: column;
    min-height: 18vh;
    padding: 2em 0.5em;
  }
  .floating-circle {
    display: none;
  }
  .footer-btn {
    width: 100%;
  }
}
</style>