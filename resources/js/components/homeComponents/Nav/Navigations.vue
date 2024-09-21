<template>
  <div
    class="max-w-screen-3xl flex flex-wrap items-center justify-between mx-auto md:p-4 md:px-20 lg:p-4 border-b border-blue-950 lg:px-20 xl:p-4 xl:px-20 2xl:p-4 2xl:px-20 p-3"
  >
    <button class="flex space-x-3 rtl:space-x-reverse">
      <!-- <img src="img/CrimeGuard.png" class="h-8" alt="Flowbite Logo" /> -->
      <img class="h-8 w-8" :src="'/storage/system/bg.png'" alt="logo" />
      <span
        class="self-center sm:text-lg md:text-xl 2xl:text-2xl xl:text-2xl font-semibold whitespace-nowrap text-white"
        >CrimeGuard</span
      >
    </button>
    <div class="xl:w-auto 2xl:w-auto">
      <ul class="font-medium flex lg:gap-2 xl:gap-2 md:gap-2 2xl:gap-2 gap-0.5">
        <li v-for="(nav, i) in navs">
          <button
            class="text-gray-100 border border-violet-700 text-xs sm:text-xs md:text-lg 2xl:text-lg xl:text-lg lg:text-lg py-3 px-4 md:py-2 md:px-8 lg:py-2 lg:px-8 xl:py-2 xl:px-8 2xl:py-2 2xl:px-8 md:rounded-xl lg:rounded-xl xl:rounded-xl 2xl:rounded-xl rounded-md bg-violet-500 hover:text-white hover:bg-violet-600 hover:border-violet-100 active:text-gray-50 active:bg-violet-700 active:border-white"
            v-if="nav == 'Sign up' || nav == 'Login'"
            @click="$emit('changeActive', nav)"
          >
            {{ nav }}
          </button>
        </li>
        <li
          @click="toggle"
          v-if="isPhone && logged"
          class="hover:bg-blue-400 hover:bg-opacity-50 active:rotate-180 rounded"
        >
          <svg
            class="h-8 w-8 text-gray-900 my-1"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 10h16M4 14h16M4 18h16"
            />
          </svg>
        </li>
      </ul>
    </div>
    <div v-if="!isPhone && logged" class="xl:w-auto 2xl:w-auto">
      <ul class="font-medium flex lg:gap-2 xl:gap-2 md:gap-2 2xl:gap-2 gap-0.5">
        <li>
          <button
            class="flex gap-1 text-xs sm:text-xs md:text-lg 2xl:text-lg xl:text-lg lg:text-lg py-3 px-4 md:py-2 md:px-5 lg:py-2 lg:px-5 xl:py-2 xl:px-5 2xl:py-2 2xl:px-5 text-gray-100 hover:bg-violet-900 hover:bg-opacity-60 hover:rounded-t-md active:border-gray-300 active:border-b active:text-white active:bg-violet-400 active:bg-opacity-50"
            :class="{
              'border-gray-300 border-b text-white bg-violet-400 bg-opacity-50 rounded-t-lg':
                'Home' == active,
            }"
            @click="$emit('changeActive', 'Home')"
          >
            <svg
              class="h-6 w-6 text-sky-100"
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
              <polyline points="5 12 3 12 12 3 21 12 19 12" />
              <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
              <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
            </svg>
            Home
          </button>
        </li>
        <li>
          <button
            class="flex gap-1 text-xs sm:text-xs md:text-lg 2xl:text-lg xl:text-lg lg:text-lg py-3 px-4 md:py-2 md:px-5 lg:py-2 lg:px-5 xl:py-2 xl:px-5 2xl:py-2 2xl:px-5 text-gray-100 hover:bg-violet-900 hover:bg-opacity-60 hover:rounded-t-md active:border-gray-300 active:border-b active:text-white active:bg-violet-400 active:bg-opacity-50"
            :class="{
              'border-gray-300 border-b text-white bg-violet-400 bg-opacity-50 rounded-t-lg':
                'Recent Incidents' == active,
            }"
            @click="$emit('changeActive', 'Recent Incidents')"
          >
            <svg
              class="h-6 w-6 text-sky-100"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path
                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
              />
              <polyline points="14 2 14 8 20 8" />
              <line x1="16" y1="13" x2="8" y2="13" />
              <line x1="16" y1="17" x2="8" y2="17" />
              <polyline points="10 9 9 9 8 9" /></svg
            >Recent Incidents
          </button>
        </li>
        <li>
          <button
            class="flex gap-1 text-xs sm:text-xs md:text-lg 2xl:text-lg xl:text-lg lg:text-lg py-3 px-4 md:py-2 md:px-5 lg:py-2 lg:px-5 xl:py-2 xl:px-5 2xl:py-2 2xl:px-5 text-gray-100 hover:bg-violet-900 hover:bg-opacity-60 hover:rounded-t-md active:border-gray-300 active:border-b active:text-white active:bg-violet-400 active:bg-opacity-50"
            :class="{
              'border-gray-300 border-b text-white bg-violet-400 bg-opacity-50 rounded-t-lg':
                'Reported Incidents' == active,
            }"
            @click="$emit('changeActive', 'Reported Incidents')"
          >
            <svg
              class="h-6 w-6 text-sky-100"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
              />
            </svg>
            Reported Incidents
          </button>
        </li>
        <li>
          <button
            class="flex gap-1 text-xs sm:text-xs md:text-lg 2xl:text-lg xl:text-lg lg:text-lg py-3 px-4 md:py-2 md:px-5 lg:py-2 lg:px-5 xl:py-2 xl:px-5 2xl:py-2 2xl:px-5 text-gray-100"
            @click="toggleNotif()"
          >
            <svg
              class="h-6 w-6 text-sky-100"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
              />
            </svg>
          </button>
        </li>
        <li>
          <userProfile
            :hiddens="profileOpen"
            :toggle="toggleProfile"
            @change-a="changeA"
            @reload="$emit('reload')"
            v-if="logged"
          >
          </userProfile>
        </li>
      </ul>
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