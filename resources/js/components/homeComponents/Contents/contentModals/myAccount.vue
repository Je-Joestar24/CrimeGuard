<template>
  <div v-if="!isPhone" class="w-full flex justify-center mt-2">
    <div
      class="flex p-4 justify-center bg-gray-100 rounded-xl backdrop-filter backdrop-blur-lg grid-flow-col"
      style="
        width: 1200px;
        background-color: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
      "
    >
      <div class="w-1/2 align-middle">
        <div class="rounded-md m-4 mt-10">
          <span
            class="text-xl font-bold text-gray-800 py-3 px-10 rounded-md shadow-md border-gray-300 border bg-gray-100"
            >MY ACCOUNT</span
          >
          <!-- my account display -->
          <display-acc></display-acc>
        </div>
      </div>
      <div class="w-1/2 grid p-4 gap-5">
        <personal-info></personal-info>
        <account-info></account-info>
      </div>
    </div>
  </div>

  <div
    class="px-5 flex flex-col fixed top-0 z-50 bg-white overflow-auto slide-enter-active"
    :class="{'slide-leave-active': disapear}"
    style="width: 100vw; height: 100vh"
    v-if="isPhone"
  >
    <span class="font-semibold mx-auto text-center my-4 text-lg text-gray-700"
      >My Profile</span
    >
    <display-acc></display-acc>
    <personal-info></personal-info>
    <account-info></account-info>
    <div class="w-full bg-green-900" style="height: 25vh"></div>
    <span class="absolute top-4 left-5"
      ><svg
        class="h-7 w-7 text-gray-700 active:bg-gray-400 rounded-md"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        @click="reloadSelf"
      >
        <polyline points="15 18 9 12 15 6" /></svg
    ></span>
  </div>
</template>

<script>
import displayAcc from "./myAccount/display.vue";
import personalInfo from "./myAccount/personal.vue";
import AccountInfo from "./myAccount/account.vue";

export default {
  data() {
    return {
      disapear: false
    }
  },
  components: {
    displayAcc,
    personalInfo,
    AccountInfo,
  },
  methods:{
    reloadSelf(){
      //window.location.reload();
      this.disapear = true;
      setTimeout(()=>{
        this.changeActive('Home');
      }, 300)
    }
  },
  computed: {
    isPhone() {
      return window.innerWidth <= 768;
    },
  },props:['changeActive']
};
</script>

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