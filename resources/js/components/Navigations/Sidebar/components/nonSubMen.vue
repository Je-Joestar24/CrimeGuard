<template>
  <router-link
    @click.prevent="
      changes(subElems.api, [subElems.id, subElems.titlePage, subElems.id])
    "
    class="flex items-center p-3 text-gray-700 rounded-lg transition-colors duration-150 ease-in-out relative"
    :to="subElems.nm"
    :class="{
      'bg-blue-50 text-blue-600':
        subElems.id == $store.state.CurrentActiveSideBar,
      'hover:bg-gray-100': subElems.id != $store.state.CurrentActiveSideBar,
    }"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
      stroke-width="1.5"
      stroke="currentColor"
      class="w-5 h-5 mr-3"
    >
      <path
        v-for="pt in subElems.pth"
        :key="pt.d"
        :stroke-linecap="pt['stroke-linecap']"
        :stroke-linejoin="pt['stroke-linejoin']"
        :d="pt.d"
      />
    </svg>
    <span class="font-medium">{{ subElems.nm }}</span>
  </router-link>
</template>

<script>
export default {
  props: ["subElems"],
  methods: {
    changes(param1, param2) {
      this.$store.dispatch("changeAPI", param1);
      this.$store.commit("changeActivePage", param2);
    },
  },
};
</script>