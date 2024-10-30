<template>
  <div
    class="w-screen-xl flex flex-wrap items-center justify-center mx-auto p-4"
  >
    <div class="relative p-4 w-full max-w-xl max-h-full sm:mt-20 md:mt-40">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow">
        <!-- Modal header -->
        <div
          class="flex items-center justify-between p-4 md:p-5 border-b rounded-t"
        >
          <h3 class="text-xl font-semibold text-gray-900">
            {{ active }}
          </h3>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
          <!-- forms -->
          <reportForm v-if="active == 'Report'"></reportForm>
        </div>
      </div>
    </div>
  </div>
  <signUpForm :change-active="changeActive" v-if="active == 'Sign up' && !isPhone"></signUpForm>
  <loginForm :change-active="changeActive" v-if="active == 'Login'"></loginForm>
  <sign-up-phone :change-active="changeActive" v-if="active == 'Sign up' && isPhone"/>
</template>


<script>
import loginForm from "./ModalForms/loginForms.vue";
import signUpForm from "./ModalForms/signUpForm.vue";
import signUpPhone from "./ModalForms/signUpPhone.vue";
import reportForm from "./ModalForms/reportForm.vue";

export default {
  data() {
    return {};
  },
  props: ["active", "changeActive"],
  components: {
    loginForm,
    signUpForm,
    reportForm,
    signUpPhone
  },
  computed: {
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
};
</script>