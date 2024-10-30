<template>
  <home-c  v-if="active == 'Home'"/>
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
  background-image: url('/storage/system/newBG.png');
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