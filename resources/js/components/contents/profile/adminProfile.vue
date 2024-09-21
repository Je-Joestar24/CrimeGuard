<template>
  <div
    class="fixed flex top-0 right-0 z-50 p-0 justify-end items-center w-full bg-gray-900 bg-opacity-50"
    style="height: 100vh"
  >
    <div class="bg-transparent w-full h-full" @click="toggleProfile()"></div>
    <div
      class="relative w-full max-w-4xl h-full m-0 bg-gray-400 border-l border-gray-500"
      style="width: 2000px"
    >
      <!-- Modal content -->
      <div class="relative bg-white shadow h-full">
        <!-- Modal header -->
        <div class="flex items-center justify-between border-b pb-4 pt-2">
          <h1 class="text-xl p-2 mx-5 font-bold">MY ACCOUNT</h1>
          <button
            type="button"
            @click="toggleProfile()"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
            data-modal-hide="default-modal"
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
        <!-- Modal body -->
        <div class="p-4 flex flex-col">
          <!-- pure display -->
          <display></display>
          <div class="flex flex-col w-full border my-4 rounded-xl shadow-lg">
            <h1 class="border-b rounded-t-xl py-1 px-3 font-bold">PRIVACY</h1>
            <account-info></account-info>
            <personal-info></personal-info>
            <reset-pass></reset-pass>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import display from "./display.vue";
import accountInfo from "./accountInfo.vue";
import personalInfo from './personalInfo.vue';
import resetPass from './resetPass.vue';

export default {
  components: { display, accountInfo, personalInfo, resetPass },
  props: ["toggleProfile", "closeProfile"],
  data() {
    return {
      id: -1,
    };
  },
  methods: {},
  mounted() {
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    this.id = credentials.id;
  },
};
</script>