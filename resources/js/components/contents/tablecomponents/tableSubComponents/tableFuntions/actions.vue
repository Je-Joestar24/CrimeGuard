<template>
  <button
    type="button"
    class="floatingComponentToggle py-1 px-5 me-2 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200"
    @click.prevent="opened = false"
  >
    <!-- dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 -->
    Action
  </button>
  <!-- Dropdown menu -->
  <div
    :class="isOpen"
    class="floatingComponents z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 absolute"
  >
    <ul
      class="py-2 text-sm text-gray-700 dark:text-gray-200"
      aria-labelledby="dropdownHoverButton"
    >
      <li>
        <button
          class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
        >
          Edit
        </button>
        
      </li>
      <li>
        <button
          class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
        >
          Delete
        </button>
        
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      opened: "false",
    };
  },
  mounted() {
    document.addEventListener("click", this.handleClickOutside);
  },
  beforeUnmount() {
    document.removeEventListener("click", this.handleClickOutside);
  },
  computed: {
    isOpen() {
      return {
        hidden: this.opened,
      };
    },
  },
  methods: {
    handleClickOutside(event) {
      if (
        !document
          .querySelector(".floatingComponentToggle")
          .contains(event.target) &&
        !document.querySelector(".floatingComponents").contains(event.target) &&
        !document
          .querySelector(".floatingComponents")
          .classList.contains("hidden")
      )
        this.opened = true;
    },
  },
};
</script>