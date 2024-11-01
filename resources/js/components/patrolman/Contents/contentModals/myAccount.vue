<template>
  <div
    class="px-5 flex flex-col fixed top-0 z-50 bg-white overflow-auto slide-enter-active"
    :class="{ 'slide-leave-active': disapear }"
    style="width: 100vw; height: 100vh"
    v-if="isPhone"
  >
    <span class="font-semibold mx-auto text-center my-4 text-lg text-gray-700"
      >My Profile</span
    >
    <span @click="reloadSelf" class="absolute top-5 right-5">
      <svg 
      class="h-7 w-7 text-gray-600 active:bg-gray-400 rounded-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
      </svg>
      
    </span>
    <display-acc></display-acc>
    <personal-info></personal-info>
    <account-info></account-info>
    <div class="w-full bg-green-900" style="height: 25vh"></div>
  </div>
</template>

<script>
import displayAcc from "./myAccount/display.vue";
import personalInfo from "./myAccount/personal.vue";
import AccountInfo from "./myAccount/account.vue";

export default {
  data() {
    return {
      disapear: false,
    };
  },
  components: {
    displayAcc,
    personalInfo,
    AccountInfo,
  },
  methods: {
    reloadSelf() {
      //window.location.reload();
      this.disapear = true;
      setTimeout(() => {
        this.changeActive("recents");
      }, 300);
    },
  },
  computed: {
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
  props: ["changeActive"],
};
</script>

<style scoped>
@keyframes slideIn {
  from {
    transform: translateY(100%);
  }
  to {
    transform: translateY(0);
  }
}

@keyframes slideOut {
  from {
    transform: translateY(0);
  }
  to {
    transform: translateY(100%);
  }
}

.slide-enter-active {
  animation: slideIn 0.3s forwards;
}

.slide-leave-active {
  animation: slideOut 0.3s forwards;
}
</style>