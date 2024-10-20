
<style scoped>
@keyframes slideIn {
  from {
    transform: translateX(100%);
  }
  to {
    transform: translateX(0);
  }
}

@keyframes slideOut {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(100%);
  }
}

.slide-enter-active {
  animation: slideIn 0.3s forwards;
}

.slide-leave-active {
  animation: slideOut 0.3s forwards;
}
</style>


<template>
  <div class="fixed inset-0 z-50 overflow-hidden bg-gray-900 bg-opacity-50 flex justify-end" @click.self="toggle()">
    <div class="bg-white w-full max-w-2xl h-full overflow-y-auto slide-enter-active" 
    :class="{ 'slide-leave-active': isVisible }">
      <div class="flex items-center justify-between p-6 border-b">
        <h1 class="text-2xl font-bold text-gray-900">My Account</h1>
        <button @click="toggle()" class="text-gray-400 hover:text-gray-500 active:animate-spin hover:bg-gray-300 rounded-md p-2">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="p-6 space-y-6">
        <display></display>
        <div class="bg-gray-50 rounded-lg shadow p-6 space-y-6">
          <h2 class="text-xl font-semibold text-gray-900 border-b pb-2">Privacy Settings</h2>
          <account-info></account-info>
          <personal-info></personal-info>
          <reset-pass></reset-pass>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import display from "./display.vue";
import accountInfo from "./accountInfo.vue";
import personalInfo from './personalInfo.vue';
import resetPass from './resetPass.vue';

export default {
  components: { display, accountInfo, personalInfo, resetPass },
  props: ["toggleProfile", "closeProfile"],
  data() {
    return {
      id: -1,
      isVisible: false,
    };
  },
  methods: {
    toggle(){
      this.isVisible = !this.isVisible;
      setTimeout(() => {
        this.toggleProfile();
      }, 300);
    }
  },
  mounted() {
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.id = credentials.id;
  },
};
</script>