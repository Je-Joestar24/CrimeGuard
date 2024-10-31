<template>
    <button
      class="flex flex-col items-center text-gray-500 hover:text-blue-600 transition duration-150 ease-in-out"
      :class="{ 'text-blue-600': active }"
    >
      <span v-html="iconSvg" class="w-6 h-6 mx-auto"></span>
      <span class="text-xs mt-1 font-medium mx-auto">{{ label }}</span>
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
          shield: `<svg   width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="5" />  <path d="M12 7v-4m-1 0h2" />  <path d="M12 7v-4m-1 0h2" transform="rotate(45 12 12)" />  <path d="M12 7v-4m-1 0h2" transform="rotate(90 12 12)" />  <path d="M12 7v-4m-1 0h2" transform="rotate(135 12 12)" />  <path d="M12 7v-4m-1 0h2" transform="rotate(180 12 12)" />  <path d="M12 7v-4m-1 0h2" transform="rotate(225 12 12)" />  <path d="M12 7v-4m-1 0h2" transform="rotate(270 12 12)" />  <path d="M12 7v-4m-1 0h2" transform="rotate(315 12 12)" /></svg>`,
          track: `<svg class=" text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <line x1="12" y1="3" x2="12" y2="7" />  <line x1="12" y1="21" x2="12" y2="18" />  <line x1="3" y1="12" x2="7" y2="12" />  <line x1="21" y1="12" x2="18" y2="12" />  <line x1="12" y1="12" x2="12" y2="12.01" /></svg>`,
          bell: `<svg    viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />  <path d="M13.73 21a2 2 0 0 1-3.46 0" /></svg>`,
          account: `<svg   fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
</svg>
`
        };
        return icons[this.icon] || '';
      }
    }
  }
  </script>
  
  