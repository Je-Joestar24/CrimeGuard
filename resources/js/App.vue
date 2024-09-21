<template>
    <router-view></router-view>

  </template>
  
  <script>
  
  export default {
    data() {
      return {
        test: [],
      };
    },
    watch: {
    },
    created() {
      
      const credentials = JSON.parse(localStorage.getItem("credentials"));
      if(credentials){
        if(credentials.user_level == 1 || credentials.user_level == 2){
          this.$router.push("/Admin/Dashboard");
        }
      }
    },
    methods: {
    },
  };
  </script>
  
  <style>
  * {
    transition: 200ms;
  }
  
  ::-webkit-scrollbar {
    width: 5px;
  }
  
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }
  
  ::-webkit-scrollbar-thumb {
    background: #888;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: #555;
  }
  </style>
  
