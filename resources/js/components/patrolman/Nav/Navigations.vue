<template>
  <div
    class="max-w-screen-3xl flex flex-wrap items-end justify-between mx-auto md:p-4 md:px-20 lg:p-4 lg:px-20 xl:p-4 xl:px-20 2xl:p-4 2xl:px-20 p-3"
  >
    <nav-buttons icon="home" label="Home" />
    <nav-buttons icon="shield" label="Security" />
    <div class="border rounded-full border-violet-400 p-5">
      <nav-buttons class=" borde" icon="pay" label="Pay" active />
    </div>
    <nav-buttons icon="bell" label="Messages" />
    <nav-buttons icon="support" label="Support" />
  </div>

  <sidebar
    @change-active="changeA"
    v-if="isPhone && sideOpen"
    :toggle="toggle"
  ></sidebar>
  <notif v-if="notifOpen" />
</template>

<script>
import sidebar from "./navComponents/sidebar.vue";
import userProfile from "./navComponents/userProfile.vue";
import notif from "./navComponents/notif.vue";
import navButtons from "./navComponents/navButtons.vue";

export default {
  props: ["navs", "active", "changeActive", "userLogged"],
  data() {
    return {
      sideOpen: false,
      notifOpen: false,
      profileOpen: true,
    };
  },
  components: {
    userProfile,
    sidebar,
    notif,
    navButtons,
  },
  methods: {
    changeA(param) {
      this.$emit("changeActive", param);
    },
    toggle() {
      this.sideOpen = !this.sideOpen;
    },
    toggleNotif() {
      this.notifOpen = !this.notifOpen;
      this.profileOpen = true;
    },
    toggleProfile() {
      this.profileOpen = !this.profileOpen;
      this.notifOpen = false;
    },
  },
  computed: {
    logged() {
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      if (credentials) {
        return credentials.user_level == 3;
      }
    },
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
};
</script>