<template>
  <tr>

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