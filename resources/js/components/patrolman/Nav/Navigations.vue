<template>
  <div
    v-if="profile"
    class="fixed right-10 bottom-16 bg-white border border-gray-300 px-6 py-4 rounded-2xl shadow-lg flex flex-col gap-4 z-40 text-gray-700 font-semibold text-sm"
  >
    <div
      class="hover:bg-gray-100 rounded-lg px-3 py-2 transition-all"
      @click="logoutToggle"
    >
      Logout
    </div>
    <div
      class="hover:bg-gray-100 rounded-lg px-3 py-2 transition-all"
      @click="
        toggle();
        changeActive('account');
      "
    >
      Profile
    </div>
  </div>
  <div
    class="max-w-screen-3xl flex flex-wrap items-end shadow-lg justify-evenly mx-auto md:p-4 md:px-20 lg:p-4 lg:px-20 xl:p-4 xl:px-20 2xl:p-4 2xl:px-20 p-3 bg-white relative"
  >
    <!-- 
    <nav-buttons  @click="changeActive('Home')" icon="home" label="Home" /> -->
    <nav-buttons
      @click="changeActive('recents')"
      icon="shield"
      label="Recent"
    />
    <div class="border rounded-full border-violet-400 p-5">
      <nav-buttons
        @click="changeActive('Track')"
        class=""
        icon="track"
        label="Track"
        active
      />
    </div>
    <!-- 
    <nav-buttons  @click="changeActive('Home')" icon="bell" label="Notifications" /> -->
    <nav-buttons @click="toggle" icon="account" label="Account" />
  </div>
  <sidebar
    @change-active="changeA"
    v-if="isPhone && sideOpen"
    :toggle="toggle"
  ></sidebar>
  <logout-vue v-if="logout" :toggle="logoutToggle" />
  <notif v-if="notifOpen" />
</template>

<script>
import sidebar from "./navComponents/sidebar.vue";
import userProfile from "./navComponents/userProfile.vue";
import notif from "./navComponents/notif.vue";
import navButtons from "./navComponents/navButtons.vue";
import logoutVue from "../Contents/contentModals/ModalForms/logout.vue";

export default {
  props: ["navs", "active", "changeActive", "userLogged"],
  data() {
    return {
      sideOpen: false,
      notifOpen: false,
      profileOpen: true,
      profile: false,
      logout: false,
    };
  },
  components: {
    userProfile,
    sidebar,
    notif,
    navButtons,
    logoutVue,
  },
  methods: {
    changeA(param) {
      this.$emit("changeActive", param);
    },
    toggle() {
      this.profile = !this.profile;
    },
    logoutToggle() {
      this.logout = !this.logout;
      this.profile = false;
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