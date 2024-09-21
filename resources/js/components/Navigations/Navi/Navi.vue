<template>
  <Title></Title>
  <Profile :toggle-profile="tProfile3" ></Profile>
</template>

<script>
import Profile from "./navComponents/profile.vue";
import Title from "./navComponents/title.vue";

export default {
  components: {
    Profile,
    Title,
  },props:['toggleProfile'],
  methods:{
    tProfile3(){
      this.toggleProfile();
    }
  }
};
</script>