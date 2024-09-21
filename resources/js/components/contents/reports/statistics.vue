<template>
  <div
    class="flex gap-0"
  >
    <button
      v-for="nav in reprotsNav"
      class="px-3 font-semibold border shadow-sm py-1 rounded-t-lg hover:bg-gray-100"
      :class="{ 'bg-gray-200': active == nav }"
      @click="changePage(nav)"
    >
      {{ nav }}
    </button>
  </div>
  <incidents v-if="active == 'INCIDENTS'"></incidents>
  <accounts v-if="active == 'ACCOUNT REQUESTS'"></accounts>
  <officeracc v-if="active== 'OFFICER ACCOUNTS'"/>
</template>

<script>
import incidents from "./statistical/incidents.vue";
import accounts from "./statistical/accounts.vue";
import officeracc from "./statistical/officeracc.vue";

export default {
  components: {
    incidents,
    accounts,
    officeracc
  },
  data() {
    return {
      reprotsNav: ["INCIDENTS"/* , "INCIDENT REPORTS" */, "ACCOUNT REQUESTS", "OFFICER ACCOUNTS"],
      active: "INCIDENTS",
    };
  },
  methods: {
    changePage(param) {
      this.active = param;
    },
  },
};
</script>