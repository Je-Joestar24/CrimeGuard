<template>
  <div
    tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50"
  >
    <div class="relative w-full max-w-6xl">
      <div class="relative bg-white rounded-lg shadow-2xl overflow-hidden">
        <button
          type="button"
          class="absolute top-4 right-4 text-gray-400 hover:text-gray-900 transition-colors duration-200"
          @click.prevent="toggle()"
        >
          <svg
            class="w-6 h-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
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
        <div class="p-6 md:p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Account Details</h2>
          <div class="flex flex-col md:flex-row gap-8">
            <div class="md:w-1/3">
              <div class="bg-gray-100 p-6 rounded-lg shadow-inner flex flex-col items-center">
                <div class="w-48 h-48 mb-4 rounded-full overflow-hidden border-4 border-white shadow-lg">
                  <img
                    v-if="profile"
                    :src="profile"
                    alt="Profile"
                    class="w-full h-full object-cover"
                  >
                  <svg
                    v-else
                    class="w-full h-full text-gray-300"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                  </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ user_name || "No Data" }}</h3>
                <p class="text-sm text-gray-600">Account ID: {{ suspectId }}</p>
              </div>
            </div>
            <div class="md:w-2/3">
              <basic :suspectIdRequest="suspectId" :set="set" class="mb-8"></basic>
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Address Information</h3>
              <addresses :suspectIdRequest="suspectId"></addresses>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import basic from './accountProfile/basic.vue';
import addresses from './accountProfile/address.vue';

export default {
  components: {
    basic,
    addresses
  },
  props: ["toggle", "suspectId"],
  data() {
    return {
      profile: "",
      user_name: ""
    };
  },
  methods: {
    set(profile, user) {
      this.profile = profile;
      this.user_name = user;
    }
  },
};
</script>