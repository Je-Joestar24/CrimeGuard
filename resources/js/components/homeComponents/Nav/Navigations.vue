<template>
  <div
    class="max-w-screen-3xl flex flex-wrap items-center justify-between mx-auto md:p-4 md:px-20 lg:p-4 lg:px-20 xl:p-4 xl:px-20 2xl:p-4 2xl:px-20 p-3"
  >
    <div class="flex items-center space-x-4">
      <img class="h-10 w-10" :src="'/storage/system/bg.png'" alt="CrimeGuard Logo" />
      <span class="text-2xl font-semibold text-white tracking-tight">CrimeGuard</span>
    </div>
    <div class="flex items-center space-x-6">
      <ul class="flex space-x-4">
        <li v-for="(nav, i) in navs" :key="i">
          <button
            v-if="nav === 'Sign up' || nav === 'Login'"
            @click="$emit('changeActive', nav)"
            class="px-4 py-2 text-sm font-medium text-white bg-violet-600 rounded-md hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition duration-150 ease-in-out shadow-md"
          >
            {{ nav }}
          </button>
        </li>
      </ul>
      <button
        v-if="isPhone && logged"
        @click="toggle"
        class="p-2 text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-colors duration-200"
      >
        <span class="sr-only">Open main menu</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
    <div v-if="!isPhone && logged" class="flex items-center space-x-6">
      <nav class="flex items-center space-x-4">
        <button
          @click="$emit('changeActive', 'Home')"
          class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-violet-700 hover:text-white transition duration-150 ease-in-out"
          :class="{ 'bg-violet-800 text-white': 'Home' == active }"
        >
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
          </svg>
          <span>Home</span>
        </button>
        <button
          @click="$emit('changeActive', 'Recent Incidents')"
          class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-violet-700 hover:text-white transition duration-150 ease-in-out"
          :class="{ 'bg-violet-800 text-white': 'Recent Incidents' == active }"
        >
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          <span>Recent Incidents</span>
        </button>
        <button
          @click="$emit('changeActive', 'Reported Incidents')"
          class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-violet-700 hover:text-white transition duration-150 ease-in-out"
          :class="{ 'bg-violet-800 text-white': 'Reported Incidents' == active }"
        >
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
          <span>Reported Incidents</span>
        </button>
      </nav>
      <div class="flex items-center space-x-4">
        <button
          @click="toggleNotif()"
          class="p-1 rounded-full text-gray-300 hover:bg-violet-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-violet-800 focus:ring-white transition duration-150 ease-in-out"
        >
          <span class="sr-only">View notifications</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
        </button>
        <userProfile
          :hiddens="profileOpen"
          :toggle="toggleProfile"
          @change-a="changeA"
          @reload="$emit('reload')"
          v-if="logged"
        >
        </userProfile>
      </div>
    </div>
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