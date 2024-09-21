<template>
  <tr>
    <th scope="col" class="p-4">
      <div class="flex items-center">
        <input
          class="w-4 h-4  rounded"
          :class="{'dark:focus:ring-blue-600 ring-offset-gray-800 focus:ring-offset-gray-800 focus:ring-2bg-gray-700 border-gray-600':$store.getters.theme, ' focus:ring-blue-500 text-blue-600 bg-gray-100 border-gray-300':!$store.getters.theme}"
          
          type="checkbox"
          />
          <!--
            id="SelectAllElems"
            onclick="selectAll(`${this.id}`, 'elems', '1')"
         -->
      </div>
    </th>

    <th
      scope="col"
      class="px-6 py-3"
      v-for="(heads, i) in headers"
    >
      {{ heads }}
    </th>
    <th class="px-6 py-3">Action</th>
  </tr>
</template>


<script>
export default {
  props: ["headers"],

};
</script>