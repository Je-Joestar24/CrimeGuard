<template>
  <MenuItems
    :page="page"
  ></MenuItems>
</template>

<script>
import MenuItems from "./components/MenuItems.vue";
export default {
  components: { MenuItems },
  props: ["page"],
};
</script>