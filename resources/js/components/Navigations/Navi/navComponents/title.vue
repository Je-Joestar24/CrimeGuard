<template>
  <div class="flex items-center justify-start rtl:justify-end">
    <button
      data-drawer-target="logo-sidebar"
      data-drawer-toggle="logo-sidebar"
      aria-controls="logo-sidebar"
      type="button"
      class="inline-flex items-center p-2 text-sm  rounded-lg sm:hidden  focus:outline-none focus:ring-2  "
      :class="{'text-gray-400 hover:bg-gray-700 focus:ring-gray-600':$store.getters.theme,'text-gray-500 hover:bg-gray-100 focus:ring-gray-200 ':!$store.getters.theme}"
    >
      <span class="sr-only">Open sidebar</span>
      <svg
        class="w-6 h-6"
        aria-hidden="true"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          clip-rule="evenodd"
          fill-rule="evenodd"
          d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
        ></path>
      </svg>
    </button>
    <a href="https://flowbite.com" class="flex ms-2 md:me-24">
      <img class=" h-8" :src="'/images/system/bg.png'" alt="">
      <span
        class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap"
        :class="{'text-white':$store.getters.theme,'':!$store.getters.theme}"
      >
        Crime Guard
        <!--  --></span
      >
    </a>
  </div>
</template>
<script>
</script>