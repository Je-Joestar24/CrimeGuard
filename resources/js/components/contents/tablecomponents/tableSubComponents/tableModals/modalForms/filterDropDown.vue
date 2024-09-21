<template>
  <h2 class="">
    <button
      type="button"
      class="flex items-center justify-between my-2 px-2 font-medium rtl:text-right text-gray-500 border rounded-md border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3"
      @click.prevent="toggleFilter()"
    >
      Filter
      <svg
        data-accordion-icon
        class="w-3 h-3 rotate-180 shrink-0"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 10 6"
      >
        <path
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M9 5 5 1 1 5"
        />
      </svg>
    </button>
  </h2>
  <div class="border bg-gray-50" :class="{ hidden }">
    <h2
      class="shadow border bg-gray-200 w-full px-2 font-medium text-gray-600 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
    >
      Filter <span class="capitalize">{{ getTitle }}</span>
    </h2>
    <div v-for="filterers in filters[$store.getters.getActive]">
      <h2>
        <button
          type="button"
          class="flex items-center bg-gray-100 w-full justify-between px-2 font-medium rtl:text-right border-b text-gray-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3"
          @click.prevent="filterers.isClose = !filterers.isClose"
        >
          {{ filterers.nm }}
          <svg
            data-accordion-icon
            class="w-3 h-3 rotate-180 shrink-0"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 10 6"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5 5 1 1 5"
            />
          </svg>
        </button>
      </h2>
      <div class="flex gap-2" :class="{ hidden: filterers.isClose }">
        <div
          v-for="items in filterers.items"
          class="flex items-center px-4 rounded"
        >
          <div v-if="filterers.type == 'checkbox'">
            <input
              id="bordered-checkbox-1"
              :type="filterers.type"
              :value="items.value"
              name="bordered-checkbox"
              class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              v-model="items.input"
            />
            <label
              class="py-4 px-2 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
              >{{ items.label }}</label
            >
          </div>

          <div class="p-4" v-if="filterers.type == 'text'">
            <div class="relative z-0 w-full mb-5 group">
              <input
                :type="filterers.type"
                v-model="items.input"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                required
              />
              <!-- 
          <select
            v-if="mdl.type == 'select'"
            v-model="mdl.input"
            class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
          >
            <option value="">{{ mdl.options.selected }}</option>
            <option v-for="opt in mdl.options.option" :value="opt.val">
              {{ opt.val }}
            </option>
          </select>
        
        -->
              <label
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >{{ items.label }}</label
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filters: {
        innerIncident: [
          {
            nm: "Victims",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Suspect",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Witness",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Categories",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Index", value: "index", input: false },
              { label: "Non-Index", value: "none index", input: false },
              {
                label: "Against Persons",
                value: "against person",
                input: false,
              },
              {
                label: "Against Property",
                value: "against property",
                input: false,
              },
              {
                label: "Traffic Incidents",
                value: "traffic incidents",
                input: false,
              },
              { label: "Special Laws", value: "special laws", input: false },
            ],
          },
        ],
        innerSuspects: [
          {
            nm: "Victims",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Suspect",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Witness",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Categories",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Index", value: "index", input: false },
              { label: "Non-Index", value: "none index", input: false },
              {
                label: "Against Persons",
                value: "against person",
                input: false,
              },
              {
                label: "Against Property",
                value: "against property",
                input: false,
              },
              {
                label: "Traffic Incidents",
                value: "traffic incidents",
                input: false,
              },
              { label: "Special Laws", value: "special laws", input: false },
            ],
          },
        ],
        innerVictims: [
          {
            nm: "Victims",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Suspect",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Witness",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Categories",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Index", value: "index", input: false },
              { label: "Non-Index", value: "none index", input: false },
              {
                label: "Against Persons",
                value: "against person",
                input: false,
              },
              {
                label: "Against Property",
                value: "against property",
                input: false,
              },
              {
                label: "Traffic Incidents",
                value: "traffic incidents",
                input: false,
              },
              { label: "Special Laws", value: "special laws", input: false },
            ],
          },
        ],
        innerWitnesses: [
          {
            nm: "Victims",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Suspect",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Witness",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Categories",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Index", value: "index", input: false },
              { label: "Non-Index", value: "none index", input: false },
              {
                label: "Against Persons",
                value: "against person",
                input: false,
              },
              {
                label: "Against Property",
                value: "against property",
                input: false,
              },
              {
                label: "Traffic Incidents",
                value: "traffic incidents",
                input: false,
              },
              { label: "Special Laws", value: "special laws", input: false },
            ],
          },
        ],
        innerNameIncidents: [
          {
            nm: "Categories",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Index", value: "index", input: false },
              { label: "Non-Index", value: "none index", input: false },
              {
                label: "Against Persons",
                value: "against person",
                input: false,
              },
              {
                label: "Against Property",
                value: "against property",
                input: false,
              },
              {
                label: "Traffic Incidents",
                value: "traffic incidents",
                input: false,
              },
              { label: "Special Laws", value: "special laws", input: false },
            ],
          },
        ],
        innerCitizenAccounts:[
          {
            nm: "Citizen Accounts",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          }
        ],
        innerOfficerAccounts:[
          {
            nm: "Officer Accounts",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          }
        ],
        innerLogs:[
          {
            nm: "Date logs",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Today", value: "today", input: false },
              { label: "Last Week", value: "last week", input: false }
            ],
          }
        ],
        innerActivies:[
          {
            nm: "Officer Accounts",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Senior Citizen", value: "senior", input: false },
              { label: "Minor", value: "minor", input: false },
              { label: "Adult", value: "adult", input: false },
              { label: "Male", value: "male", input: false },
              { label: "Female", value: "female", input: false }
            ],
          },
          {
            nm: "Activies",
            isClose: true,
            type: "checkbox",
            items: [
              { label: "Deleted Some Datas today", value: "senior", input: false },
              { label: "Added Some Datas today", value: "minor", input: false },
              { label: "Edited Some Datas today", value: "adult", input: false }
            ],
          }
        ],
      },
      hidden: true,
      title: "",
    };
  },
  computed: {
    getTitle() {
      this.title = this.$store.getters.currentActiveTitle + "";
      this.title = this.title.toLowerCase();
      return this.title;
    },
  },
  methods: {
    toggleFilter() {
      this.hidden = !this.hidden;
    },
    testing() {
      if (this.filters[this.$store.getters.getActive][0].type == "checkbox")
        for (const c of this.filters[this.$store.getters.getActive][0].items)
          if (c.input) console.log(c.value);
    },
  },
};
</script>