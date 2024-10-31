<template>
  <loading class="z-50 fixed top-0" v-if="load"></loading>
  <div v-if="!load" class="HomePage w-full">
      <track-me v-if="active == 'Track'"/>
      <my-account  :changeActive="changeActive"  v-if="active == 'account'"/>
      <div class="bottom-0 fixed  w-full right-0">
        <navigations :changeActive="changeActive" class=" "/>
      </div>
  </div>

  <report-form v-if="reportIsOpen" :toggle="toggleReport"></report-form>
</template>

<script>
import Navigations from "./patrolman/Nav/Navigations.vue";
import trackMe from "./patrolman/Contents/contentModals/trackMe.vue";
import loading from "./loading.vue";
import myAccount from "./patrolman/Contents/contentModals/myAccount.vue";

export default {
  data() {
    return {
      navs: ["Home"],
      active: "Home",
      Logged: false,
      load: true,
      lastScrollTop: 0,
      showScrollUpDiv: false,
      reportIsOpen: false,
    };
  },
  components: {
    Navigations,
    trackMe,
    loading,
    myAccount
  },
  methods: {
    changeActive(param) {
      this.active = param;
    },
    checkIfLogged() {
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      if (credentials) {
        return credentials.user_level == 3;
      }
    },
    reload() {
      this.load = true;
      console.log(this.load);
      setTimeout(() => {
        this.load = false;
      }, 1000);
    },
    handleScroll() {
      const scrollTop =
        window.pageYOffset || document.documentElement.scrollTop;

      if (scrollTop < this.lastScrollTop) {
        this.showScrollUpDiv = true;
      } else {
        this.showScrollUpDiv = false;
      }
      this.lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
      console.log(this.showScrollUpDiv);
    },
    toggleReport() {
      this.reportIsOpen = !this.reportIsOpen;
    },
  setBackground(imagePath) {
    document.body.style.backgroundImage = `url("${imagePath}")`;
    document.body.style.backgroundSize = 'cover';
    document.body.style.backgroundPosition = 'center';
    document.body.style.backgroundRepeat = 'no-repeat';
    document.body.style.backgroundAttachment = 'fixed';
    document.body.style.minHeight = '100vh';
  },
  },
  computed: {
    loggedIn() {
      const logged = this.checkIfLogged();

      return logged;
    },
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
  mounted() {
    setTimeout(() => {
      this.load = false;
    }, 1000);

    const credentials = JSON.parse(localStorage.getItem("credentials"));
    if (credentials && credentials.user_level == 3) {
      this.navs.push("Recent Incidents");
      this.navs.push("Reported Incidents");
    } else {
      this.navs.push("Sign up");
      this.navs.push("Login");
    }

    this.setBackground('/storage/system/newBG.png');
    window.removeEventListener("scroll", this.handleScroll);
    //document.body.style.backgroundImage = 'url("background/background.jpg")';
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.handleScroll);
  },
};
</script>

