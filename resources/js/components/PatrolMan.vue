<template>
  <loading class="z-50 fixed top-0" v-if="load"></loading>
  <div v-if="!load" class="HomePage w-full">
      <HomeContents :change-active="changeActive" :active="active"/>
      <div class="bottom-0 fixed  w-full right-0">
        <navigations class=" "/>
      </div>
  </div>

  <report-form v-if="reportIsOpen" :toggle="toggleReport"></report-form>
</template>

<script>
import Navigations from "./patrolman/Nav/Navigations.vue";
import HomeContents from "./patrolman/Contents/HomeContents.vue";
import loading from "./loading.vue";
import reportForm from "./patrolman/Contents/contentModals/ModalForms/reportForm.vue";

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
    HomeContents,
    loading,
    reportForm,
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

