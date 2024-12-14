<template>
  <div :id="subElem.id">
    <button
      type="button"
      @click.prevent="open = !open"
      class="flex items-center justify-between w-full p-3 text-gray-700 rounded-lg transition-colors duration-150 ease-in-out relative"
      :class="{
        'bg-blue-50 text-blue-600': isActive,
        'hover:bg-gray-100': !isActive,
      }"
    >
      <div class="flex items-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-5 h-5 mr-3"
        >
          <path
            v-for="(paths, i) in subElem.pth"
            :key="i"
            :stroke-linecap="paths['stroke-linecap']"
            :stroke-linejoin="paths['stroke-linejoin']"
            :d="paths.d"
          />
        </svg>
        <span class="font-medium">{{ subElem.nm }}</span>
      </div>
      <svg
        class="w-4 h-4 transition-transform duration-200"
        :class="{ 'transform rotate-180': open }"
        fill="currentColor"
        viewBox="0 0 20 20"
      >
        <path
          fill-rule="evenodd"
          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
          clip-rule="evenodd"
        />
      </svg>
      <div
        v-if="subElem.id == 'requests' && !open && $store.state.incidentmarker"
        class="incident-marker h-3 w-3 bg-red-400 rounded-full absolute top-0 left-0 animate-bounce"
      ></div>
    </button>
    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0"
    >
      <ul v-show="open" class="mt-2 space-y-2 pl-11">
        <li v-for="(innV, i) in subElem.collapse" :key="i">
          <router-link
            :id="innV.itemId"
            @click.prevent="
              changes(innV.api, [
                innV.itemId,
                innV.innerTitlePage,
                subElem.id,
                innV.tableIndex,
              ])
            "
            class="flex items-center p-2 text-gray-600 rounded-lg transition-colors duration-150 ease-in-out relative"
            :to="subElem.nm"
            :class="{
              'bg-blue-50 text-blue-600':
                innV.itemId == $store.state.CurrentActiveSideBar,
              'hover:bg-gray-100':
                innV.itemId != $store.state.CurrentActiveSideBar,
            }"
          >
            {{ innV.itemDisplay }}
            <div
              v-if="innV.itemId == 'reportedIncidents' && open && $store.state.incidentmarker"
              class="incident-marker h-3 w-3 bg-red-400 rounded-full absolute top-0 left-0 animate-bounce "
            ></div>
          </router-link>
        </li>
      </ul>
    </transition>
  </div>
</template>

<script>
export default {
  props: ["subElem"],
  data() {
    return {
      open: false,
    };
  },
  computed: {
    isActive() {
      return this.subElem.collapse.some(
        (item) => item.itemId === this.$store.state.CurrentActiveSideBar
      );
    },
  },
  methods: {
    async changes(param1, param2) {
      await this.$store.dispatch("changeAPI", param1);
      await this.$store.commit("changeActivePage", param2);
    },
  },
};
</script>