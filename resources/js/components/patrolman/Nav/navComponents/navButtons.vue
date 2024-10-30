<template>
    <button
      class="flex flex-col items-center text-gray-500 hover:text-blue-600 transition duration-150 ease-in-out"
      :class="{ 'text-blue-600': active }"
    >
      <span v-html="iconSvg" class="w-6 h-6"></span>
      <span class="text-xs mt-1 font-medium">{{ label }}</span>
    </button>
  </template>
  
  <script>
  export default {
    props: {
      icon: {
        type: String,
        required: true
      },
      label: {
        type: String,
        required: true
      },
      active: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      iconSvg() {
        const icons = {
          home: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v9m0 0h4m-4 0v-4a2 2 0 114 0v4m-4 0h4m-4-4a2 2 0 014 0" /></svg>`,
          shield: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22c4.418 0 8-3.582 8-8V7.414a1 1 0 00-.293-.707l-8-8a1 1 0 00-1.414 0l-8 8A1 1 0 002 7.414V14c0 4.418 3.582 8 8 8z" /></svg>`,
          pay: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 6h18M4 14h16m-4 0a3 3 0 003 3H7a3 3 0 003-3m-6 0a3 3 0 003 3h8a3 3 0 003-3m0 0h-4" /></svg>`,
          bell: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405a2.032 2.032 0 00-.586-.399l-.02-.02a4.992 4.992 0 00-.02-7.175A5.026 5.026 0 0012 4.01V4a5.002 5.002 0 00-9.97 1.175 5 5 0 001.176 7.175l-.021.02a2.02 2.02 0 00-.586.399L4 17h5" /></svg>`,
          support: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8a3 3 0 013 3h-6a3 3 0 013-3zM4 9V7.25A5.25 5.25 0 019.25 2h5.5A5.25 5.25 0 0120 7.25V9M6 15v5m12-5v5m-6-5v5" /></svg>`
        };
        return icons[this.icon] || '';
      }
    }
  }
  </script>
  
  