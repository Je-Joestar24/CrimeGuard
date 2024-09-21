<template>
  <homeC v-if="active == 'Home'"></homeC>
  <div
    v-if="active == 1"
    class="max-w-screen-xl flex flex-wrap items-center bg-white justify-between mx-auto p-4"
  >
    <about></about>
  </div>

  <ModalElems
    :change-active="changeActive"
    v-if="active == 'Sign up' || active == 'Login' || active == 'Report'"
    :active="active"
  ></ModalElems>
  <lists
    v-if="active == 'Recent Incidents' || active == 'Reported Incidents'"
    :active="active"
  ></lists>
  <myAccount v-if="active == 'myAccount'" :change-active="changeActive" :active="active"></myAccount>
</template>

<script>
import ModalElems from "./contentModals/FormElems.vue";
import about from "./contentModals/about.vue";
import homeC from "./contentModals/homeC.vue";
import lists from "./contentModals/lists.vue";
import myAccount from "./contentModals/myAccount.vue";

export default {
  props: ["active", "changeActive"],
  components: {
    ModalElems,
    about,
    homeC,
    lists,
    myAccount,
  },
  methods: {
    checkIfLogged() {
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      if (credentials) {
        return credentials.user_level == 3;
      }
    },
  },
  computed: {
    loggedIn() {
      const logged = this.checkIfLogged();

      return logged;
    },
  },
};
</script>

<style scoped>
body{
  background-color: rgb(0, 162, 255);
}
</style>