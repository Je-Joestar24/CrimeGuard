<template>
  <button
    type="button"
    @click.prevent="open = !open"
    :id="subElem.id"
    class="flex items-center w-full p-2 text-base  transition duration-75 rounded-lg group "
    :class="{'text-white hover:bg-gray-700 active:bg-gray-600':$store.getters.theme,'text-gray-900 hover:bg-gray-100 active:bg-gray-200':!$store.getters.theme}"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke-width="1.5"
      stroke="currentColor"
      class="w-5 h-5 transition duration-75"
    >
      <path
        v-for="(paths, i) in subElem.pth"
        :stroke-linecap="paths['stroke-linecap']"
        :stroke-linejoin="paths['stroke-linejoin']"
        :d="paths.d"
      />
    </svg>
    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{
      subElem.nm
    }}</span>
    <svg
      class="w-3 h-3"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
      fill="currentColor"
    >
      <path
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="m1 1 4 4 4-4"
      />
    </svg>
  </button>
  <ul class="py-2 space-y-2" :class="isOpen">
    <!-- id="${vals[4]}" -->
    <li v-for="(innV, i) in subElem.collapse" class="rounded-lg">
      <router-link
        :id="innV.itemId"
        
        @click.prevent="changes(innV.api, [innV.itemId, innV.innerTitlePage, subElem.id, innV.tableIndex]); "
        class="flex items-center w-full p-2   transition duration-75 rounded-lg pl-11 group "
        :to="subElem.nm"
        :class="{
          'text-white active:bg-gray-600 hover:bg-gray-700 ':$store.getters.theme,'text-gray-900 active:bg-gray-200 hover:bg-gray-100':!$store.getters.theme,
          'bg-gray-200': innV.itemId == $store.state.CurrentActiveSideBar && !$store.getters.theme,
          'bg-gray-600': innV.itemId == $store.state.CurrentActiveSideBar && $store.getters.theme,
        }"
      >
        <!-- dark: -->
        {{ innV.itemDisplay }}</router-link>
    </li>
  </ul>
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
    isOpen() {
      return {
        hidden: !this.open
      };
    }
  },methods:{
    async changes(param1, param2){
      await this.$store.dispatch('changeAPI', param1);
      await this.$store.commit('changeActivePage', param2);
    }
  }
};
</script>