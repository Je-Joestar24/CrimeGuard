<template>
  <loading class="z-50 fixed top-0" v-if="load"></loading>
  <div v-if="!load" class="HomePage w-full">
    <nav
      class="bg-gradient-to-b from-blue-500 to-blue-400 border-gray-400 w-full fixed top-0 z-50"
    >
      <Navigations
        :navs="navs"
        :active="active"
        @change-active="changeActive"
        @reload="reload"
        :user-logged="loggedIn"
      ></Navigations>
    </nav>
    <div class="mt-16 xl:mt-16 2xl:mt-16 lg:mt-16">
      <HomeContents :change-active="changeActive" :active="active">
      </HomeContents>
    </div>
  </div>

  <div
    v-if="active != 'myAccount' && loggedIn"
    class="flex flex-col fixed left-5 z-40 bottom-5 p-2 bg-red-500 rounded-md rounded-b-full"
    @click="reportIsOpen = !reportIsOpen"
  >
    <span class="text-sm mx-auto font-bold  text-white">REPORT</span>
    <svg
      v-if="!reportIsOpen"
      class="h-16 w-16 text-white p-1 rounded-full active:bg-red-300 active:mt-2 active:p-2 active:text-blue-600 active:border-blue-500 border-2 border-gray-300 shadow-sm"
      width="24"
      height="24"
      viewBox="0 0 24 24"
      stroke-width="2"
      stroke="currentColor"
      fill="none"
      stroke-linecap="round"
      stroke-linejoin="round"
    >
      <path stroke="none" d="M0 0h24v24H0z" />
      <circle cx="12" cy="12" r=".5" fill="currentColor" />
      <circle cx="12" cy="12" r="7" />
      <line x1="12" y1="3" x2="12" y2="5" />
      <line x1="3" y1="12" x2="5" y2="12" />
      <line x1="12" y1="19" x2="12" y2="21" />
      <line x1="19" y1="12" x2="21" y2="12" />
    </svg>
  </div>

  <report-form v-if="reportIsOpen" :toggle="toggleReport"></report-form>
</template>

<script>
import Navigations from "./homeComponents/Nav/Navigations.vue";
import HomeContents from "./homeComponents/Contents/HomeContents.vue";
import loading from "./loading.vue";
import reportForm from "./homeComponents/Contents/contentModals/ModalForms/reportForm.vue";

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

    window.removeEventListener("scroll", this.handleScroll);
    //document.body.style.backgroundImage = 'url("background/background.jpg")';
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.handleScroll);
  },
};
</script>

