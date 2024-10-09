<template>
  <div
    tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50"
  >
    <div class="relative w-full max-w-6xl">
      <div class="relative bg-white rounded-lg shadow-2xl">
        <button
          type="button"
          class="absolute top-5 right-5 text-gray-400 hover:text-gray-900 transition-colors duration-200"
          @click.prevent="toggle()"
        >
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
        <div class="p-5 md:p-8">
          <h2 class="text-3xl font-bold text-gray-900 mb-4 text-center">
            Account Details
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
              <div class="bg-gray-100 p-6 rounded-lg shadow-md flex flex-col items-center">
                <div class="w-48 h-48 mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
                  <img
                    v-if="profile"
                    :src="profile"
                    alt="User profile"
                    class="w-full h-full object-cover"
                  >
                  <svg
                    v-else
                    class="w-full h-full text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">
                  {{ user_name || 'No Name' }}
                </h3>
                <span class="text-sm text-gray-600">
                  Account ID: {{ suspectId }}
                </span>
              </div>
            </div>
            <div class="md:col-span-2">
              <basic :suspectIdRequest="suspectId" :sendUsername="sendData" />
            </div>
          </div>
          <div class="mt-5">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">
              Address Information
            </h3>
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
              <addresses :suspectIdRequest="suspectId" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
import basic from "./viewModalComponents/accounts/basic.vue";
import addresses from "./viewModalComponents/accounts/address.vue";

export default {
  components: {
    basic,
    addresses,
  },
  props: ["toggle", "suspectId", "isHidden", "hiddenT"],
  data() {
    return {
      user_name: '',
      profile: ''
    };
  },
  watch: {
  },
  created() {
  },
  methods: {
    sendData(param, profile) {
      this.user_name = param;
      this.profile = profile;
    },
    changeViewNav(param) {
      this.viewOtherNav.active = param;
    },
  },
};
</script>