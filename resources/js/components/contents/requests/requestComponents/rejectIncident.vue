<template>
  <div
    tabindex="-1"
    class="fixed inset-0 z-50 items-center justify-center flex bg-gray-900 bg-opacity-20"
  >
    <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg border shadow-2xl">
        <!-- :class="{' hidden ': isHidden}" dark:bg-gray-700 -->
        <button
          type="button"
          class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
          @click.prevent="toggle('')"
        >
          <!--@click="hiddenT('delete')"  dark:hover:bg-gray-600 dark:hover:text-white -->
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
        <div class="p-4 md:p-5 text-center">
          <svg
            class="mx-auto mb-4 text-gray-400 w-12 h-12 :text-gray-200"
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
          <h3 class="mb-1 text-lg font-normal text-gray-500">
            <!-- dark:text-gray-400 -->
            Are you sure you want to reject this report?
          </h3>

          <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Your message</label>
          <textarea id="message" v-model="rej_message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4" placeholder="Write your thoughts here..."></textarea>
          
          <button
            type="button"
            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
            :class="{'cursor-not-allowed':(rej_message == '')}"
            :disabled="(rej_message == '')"
            @click="sendData(rej_message)"
          >
            <!--
                @click.prevent="sendData()" dark:focus:ring-red-800 -->
            Yes, I'm sure
          </button>
          <button
            data-modal-hide="popup-modal"
            type="button"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
            @click="toggle('')"
          >
            <!-- @click="hiddenT('delete')" dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 -->
            No, cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["sendData", "toggle"],
  data() {
    return {
      rej_message: ""
    };
  },
};
</script>