<template>
  <div>
    <button
      type="button"
      class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300"
      @click="toggle"
    >
      <!-- dark:focus:ring-gray-600 -->
      <span class="sr-only">Open user menu</span>
      <svg
        v-if="info.profile == ''"
        class="h-8 w-8 text-gray-600 bg-transparent"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
        /></svg
      ><img
        class="h-10 w-10  rounded-full border-blue-700 border-2 shadow-md shadow-green-600"
        v-if="info.profile != ''"
        :src="info.profile"
        alt="profile"
      />
    </button>
  </div>
  <div
    v-if="!hiddens"
    class="fixed top-10 right-20 z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow"
  >
    <!-- dark:bg-gray-700 dark:divide-gray-600 -->
    <div class="px-4 py-3" role="none">
      <p class="text-sm text-gray-900" role="none">
        <!--  dark:text-white -->
        {{ info.user_name ? info.user_name : "USER" }}
      </p>
      <p class="text-sm font-medium text-gray-900 truncate" role="none">
        <!--  dark:text-gray-300 -->
        {{ info.email ? info.email : "user@email.com" }}
      </p>
    </div>
    <ul class="py-1" role="none">
      <li>
        <button
          @click="changeIt"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
          role="menuitem"
        >
          My Account
        </button>
        <!-- dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white -->
      </li>
      <li>
        <button
          href="#"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
          role="menuitem"
          @click="
            logout();
            toggle();
          "
        >
          Log out
        </button>
        <!-- dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white -->
      </li>
    </ul>
  </div>

  <div
    v-if="logoutToggle"
    class="fixed z-50 bg-gray-800 bg-opacity-20 top-0 left-0 flex justify-center align-middle"
    style="height: 100vh; width: 100vw"
  >
    <div class="w-1/4 rounded-xl mt-44 bg-white shadow h-1/4 animate-popup">
      <div class="w-full flex justify-end pt-2 pe-2">
        <button
          type="button"
          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
          @click="logout"
        >
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
          <span class="sr-only">Close modal</span>
        </button>
      </div>
      <div class="p-4 md:p-5 text-center">
        <svg
          class="mx-auto mb-4 text-gray-400 w-12 h-12"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 20 20"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
          />
        </svg>
        <h3 class="mb-5 text-lg font-normal text-gray-500">
          Are you sure you want to logout?
        </h3>
        <button
          @click="sendData"
          type="button"
          class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
        >
          Yes, I'm sure
        </button>
        <button
          @click="logout"
          type="button"
          class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
        >
          No, cancel
        </button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      formData: {},
      logoutToggle: false,
      info: {
        profile: "",
        user_name: "",
        email: "",
        contact: "",
      },
      id: -1,
    };
  },
  methods: {
    sendData() {
      const formData = this.formData;
      localStorage.removeItem("credentials");
      this.logout();
      window.location.reload();
      /* 
      this.$emit('reload') */
    },
    async sendData2(param) {
      const data = await this.$store.dispatch("sendData", {
        url: "api/citizen/basic/myaccount/view/request",
        data: {
          id: this.id,
        },
      });
      if (data["response"] == "Success") {
        this.info = await data["data"];
      }
    },
    changeIt() {
      this.$emit("changeA", "myAccount");
      this.toggle();
    },
    logout() {
      this.logoutToggle = !this.logoutToggle;
    },
  },
  mounted() {
    (async () => {
      await (async () => {
        const credentials = JSON.parse(localStorage.getItem("credentials"));
        this.id = credentials.id;
      })();
      await this.sendData2();
    })();
  },props:['hiddens', 'toggle']
};
</script>

<style scoped>
.animate-popup {
  animation: popup 0.6s ease-out forwards;
}

@keyframes popup {
  0% {
    transform: scale(0.5);
    opacity: 0;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}
</style>