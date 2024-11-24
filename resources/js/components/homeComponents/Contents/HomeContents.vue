<template>
  <homeC v-if="active == 'Home'"></homeC>
  <div
    v-if="active == 1"
    class="max-w-screen-xl flex flex-wrap items-center bg-white justify-between mx-auto p-4"
  >
    <about></about>
  </div>

  <ModalElems
    :change-active="changeActive"
    v-if="active == 'Sign up' || active == 'Login' || active == 'Report'"
    :active="active"
  ></ModalElems>
  <lists
    v-if="active == 'Recent Incidents' || active == 'Reported Incidents'"
    :active="active"
  ></lists>
  <myAccount
    v-if="active == 'myAccount'"
    :change-active="changeActive"
    :active="active"
  ></myAccount>

  <div
    class="w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow fixed top-2 left-1/2 transform -translate-x-1/2 z-50 animate-slide-in"
    v-if="notif"
    role="alert"
  >
    <div class="flex">
      <img
        class="w-8 h-8"
        :src="logo"
        alt="Jese Leos image"
      />
      <div class="ms-3 text-sm font-normal">
        <span class="mb-1 text-sm font-semibold text-gray-900"
          >CRIME GUARD</span
        >
        <div class="mb-2 text-sm font-normal">
          Your report has been received and reviewed. Police officers are on
          their way to your location.
        </div>
      </div>
      <button
        type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-white justify-center items-center flex-shrink-0 text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8"
        @click="seenIt"
      >
        <span class="sr-only">Close</span>
        <svg
          class="w-3 h-3"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 14 14"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
          />
        </svg>
      </button>
    </div>
  </div>
</template>

<script>
import ModalElems from "./contentModals/FormElems.vue";
import about from "./contentModals/about.vue";
import homeC from "./contentModals/homeC.vue";
import lists from "./contentModals/lists.vue";
import myAccount from "./contentModals/myAccount.vue";

export default {
  data() {
    return {
      notif: false,
      intervalId: null,
      user: -1,
      logid: -1,
      logo: "/images/system/bg.png"
    };
  },
  props: ["active", "changeActive"],
  components: {
    ModalElems,
    about,
    homeC,
    lists,
    myAccount,
  },
  methods: {
    checkIfLogged() {
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      if (credentials) {
        return credentials.user_level == 3;
      }
    },
    async notified() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/notifications/notifed/request",
        data: { id: this.user },
      });
      if(dt['response'] == 'success')this.notif = false;
    },
    async getData() {
      const dt = await this.$store.dispatch("sendData", {
        url: "api/notifications/notify/incidentReported/Display",
        data: { id: this.user },
      });

      if (dt["response"] == "Success" && dt['list']["data"].length > 0) {
        dt['']
        this.notif = true;
      } else {
        this.notif = false;
      }
    },
    seenIt() {
      this.notified();
      this.stopLogging();
    },
    startLogging() {
      this.intervalId = setInterval(() => {
        this.getData();
      }, 10000);
    },
    stopLogging() {
      if (this.intervalId) {
        clearInterval(this.intervalId);
        this.intervalId = null;
      }
    },
  },
  mounted() { 
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    if (credentials && credentials.user_level == 3) {
      this.user = credentials["id"];
      this.startLogging();
    }
  },
  computed: {
    loggedIn() {
      const logged = this.checkIfLogged();

      return logged;
    },
  },
  beforeDestroy() {
    this.stopLogging();
  },
  beforeUnmount() {
    this.stopLogging();
  },
};
</script>

<style scoped>
body {
  background-image: url('/images/system/newBG.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  min-height: 100vh;
}
@keyframes slide-in-right {
  0% {
    transform: translateX(100%) translateY(0);
    opacity: 0;
  }
  100% {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
  }
}

.animate-slide-in {
  animation: slide-in-right 0.5s ease-out forwards;
}
</style>