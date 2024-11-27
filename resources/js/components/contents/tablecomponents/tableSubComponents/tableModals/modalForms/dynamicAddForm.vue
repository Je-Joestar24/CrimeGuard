<template>
  <form class="p-3 md:p-4 space-y-4 border border-gray-300 rounded-lg">
    <div
      v-for="model in formModel[$store.getters.CurrentActiveSideBar]"
      :key="model.title"
      class="space-y-3 border-b border-gray-200 pb-4 last:border-b-0"
    >
      <h3 v-if="model.title" class="text-sm font-semibold text-gray-700 mb-2">
        {{ model.title }}
      </h3>
      <div
        :class="`grid gap-4`"
        :style="{
          display: 'grid',
          gridTemplateColumns: `repeat(${model.cols}, minmax(0, 1fr))`,
        }"
      >
        <div class="relative" v-for="mdl in model.infos" :key="mdl.label">
          <input
            v-if="
              ['text', 'number', 'date', 'email', 'tel', 'password'].includes(
                mdl.type
              )
            "
            :type="mdl.type"
            v-model="mdl.input"
            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required
          />

          <div
            v-else-if="['file', 'file2'].includes(mdl.type)"
            class="relative border border-gray-300 rounded-md p-2"
          >
            <input
              v-if="mdl.type === 'file'"
              class="hidden"
              type="file"
              :id="mdl.label"
              @change="onFileChange"
            />
            <input
              v-if="mdl.type === 'file2'"
              class="hidden"
              type="file"
              :id="mdl.label"
              @change="onFileChange2"
            />
            <label
              :for="mdl.label"
              class="flex items-center justify-center w-full h-4 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none"
            >
              <span class="flex items-center space-x-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-6 h-3 text-gray-600"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                  />
                </svg>
              </span>
            </label>
          </div>

          <signatures
            v-else-if="mdl.type === 'signature'"
            class="w-full"
            :setData="changeSignature"
            :data="mdl.input"
          />

          <textarea
            v-else-if="mdl.type === 'area'"
            rows="2"
            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            v-model="mdl.input"
          ></textarea>

          <select
            v-else-if="mdl.type === 'select'"
            v-model="mdl.input"
            class="block w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="">{{ mdl.options.selected }}</option>
            <option
              v-for="opt in mdl.options.option"
              :key="opt.val"
              :value="opt.val"
            >
              {{ opt.nm }}
            </option>
          </select>

          <label
            class="absolute left-2 -top-2.5 px-1 bg-white text-xs font-medium text-gray-600"
          >
            {{ mdl.label }}
          </label>
        </div>
      </div>
    </div>

    <div class="flex justify-end pt-4 border-t border-gray-200">
      <button
        type="button"
        @click.prevent="sendData"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
      >
        Save
      </button>
    </div>
  </form>
</template>

<script>
import signatures from "./modComps/signature.vue";

export default {
  data() {
    return {
      prevRecord: "",
      formModel: {
        innerNameIncidents: [
          {
            cols: 1,
            infos: [
              { type: "text", label: "Incident Name", input: "" },
              /*               {
                type: "select",
                label: "Incident Type",
                input: "",
                options: {
                  selected: "Select Incident",
                  option: [
                    { nm: "Index", val: "Index" },
                    { nm: "Non Index", val: "Non-Index" },
                    { nm: "Special", val: "Special" },
                  ],
                },
              }, */
              { type: "text", label: "Incident Subtype", input: "" },
              { type: "text", label: "Incident Category", input: "" },
            ],
          },
        ],
        innerWitnesses: [
          {
            cols: "4",
            infos: [
              { type: "text", label: "FAMILY NAME", input: "" },
              { type: "text", label: "FIRST NAME", input: "" },
              { type: "text", label: "MIDDLE NAME", input: "" },
              { type: "text", label: "QUALIFIER", input: "" },
              { type: "text", label: "NICKNAME", input: "" },
              { type: "text", label: "CITIZENSHIP", input: "" },
              {
                type: "select",
                label: "GENDER",
                input: "",
                options: {
                  selected: "GENDER",
                  option: [
                    { nm: "MALE", val: "Male" },
                    { nm: "FEMALE", val: "Female" },
                  ],
                },
              },
              { type: "text", label: "CIVIL STATUS", input: "" },
              { type: "date", label: "DATE OF BIRTH", input: "" },
              { type: "number", label: "AGE", input: "" },
              { type: "text", label: "PLACE OF BIRTH", input: "" },
              { type: "text", label: "HOME PHONE", input: "" },
              { type: "text", label: "MOBILE PHONE", input: "" },
              { type: "text", label: "UNDER INFLUENCE OF", input: "" },
            ],
          },
          {
            title: "Current Address",
            cols: "5",
            infos: [
              { type: "text", label: "HOUSE NUMBER/STREET", input: "" },
              { type: "text", label: "VILLAGE/SITIO", input: "" },
              { type: "text", label: "BARANGAY", input: "" },
              { type: "text", label: "TOWN/CITY", input: "" },
              { type: "text", label: "PROVINCE", input: "" },
            ],
          },
          {
            title: "Other Address",
            cols: "5",
            infos: [
              { type: "text", label: "OTHER(HOUSE NUMBER/STREET)", input: "" },
              { type: "text", label: "OTHER(VILLAGE/SITIO)", input: "" },
              { type: "text", label: "OTHER(BARANGAY)", input: "" },
              { type: "text", label: "OTHER(TOWN/CITY)", input: "" },
              { type: "text", label: "OTHER(PROVINCE)", input: "" },
            ],
          },
          {
            title: "Additional Infos",
            cols: "5",
            infos: [
              {
                type: "text",
                label: "HIGHEST EDUCATION ATTAINMENT",
                input: "",
              },
              { type: "text", label: "OCCUPATION", input: "" },
              { type: "file", label: "ID CARD PRESENTED", input: "" },
              { type: "text", label: "EMAIL ADDRESS", input: "" },
              { type: "text", label: "FB ACCOUNT", input: "" },
              { type: "signature", label: "SIGNATURE", input: "" },
            ],
          },
        ],
        innerVictims: [
          {
            cols: 4,
            infos: [
              { type: "text", label: "FAMILY NAME", input: "" },
              { type: "text", label: "FIRST NAME", input: "" },
              { type: "text", label: "MIDDLE NAME", input: "" },
              { type: "text", label: "QUALIFIER", input: "" },
              { type: "text", label: "NICKNAME", input: "" },
              { type: "text", label: "CITIZENSHIP", input: "" },
              {
                type: "select",
                label: "GENDER",
                input: "",
                options: {
                  selected: "GENDER",
                  option: [
                    { nm: "MALE", val: "Male" },
                    { nm: "FEMALE", val: "Female" },
                  ],
                },
              },
              { type: "text", label: "CIVIL STATUS", input: "" },
              { type: "date", label: "DATE OF BIRTH", input: "" },
              { type: "number", label: "AGE", input: "" },
              { type: "text", label: "PLACE OF BIRTH", input: "" },
              { type: "text", label: "HOME PHONE", input: "" },
              { type: "text", label: "MOBILE PHONE", input: "" },
              { type: "text", label: "UNDER INFLUENCE OF", input: "" },
            ],
          },
          {
            title: "Current Address",
            cols: 5,
            infos: [
              { type: "text", label: "HOUSE NUMBER/STREET", input: "" },
              { type: "text", label: "VILLAGE/SITIO", input: "" },
              { type: "text", label: "BARANGAY", input: "" },
              { type: "text", label: "TOWN/CITY", input: "" },
              { type: "text", label: "PROVINCE", input: "" },
            ],
          },
          {
            title: "Other Address",
            cols: 5,
            infos: [
              { type: "text", label: "OTHER(HOUSE NUMBER/STREET)", input: "" },
              { type: "text", label: "OTHER(VILLAGE/SITIO)", input: "" },
              { type: "text", label: "OTHER(BARANGAY)", input: "" },
              { type: "text", label: "OTHER(TOWN/CITY)", input: "" },
              { type: "text", label: "OTHER(PROVINCE)", input: "" },
            ],
          },
          {
            title: "Additional Infos",
            cols: 5,
            infos: [
              {
                type: "text",
                label: "HIGHEST EDUCATION ATTAINMENT",
                input: "",
              },
              { type: "text", label: "OCCUPATION", input: "" },
              { type: "file", label: "ID CARD PRESENTED", input: "" },
              { type: "text", label: "EMAIL ADDRESS", input: "" },
              { type: "text", label: "FB ACCOUNT", input: "" },
            ],
          },
        ],
        innerSuspects: [
          {
            cols: 8,
            infos: [
              { type: "text", label: "FAMILY NAME", input: "" },
              { type: "text", label: "FIRST NAME", input: "" },
              { type: "text", label: "MIDDLE NAME", input: "" },
              { type: "text", label: "QUALIFIER", input: "" },
              { type: "text", label: "NICKNAME", input: "" },
              { type: "text", label: "CITIZENSHIP", input: "" },
              {
                type: "select",
                label: "GENDER",
                input: "",
                options: {
                  selected: "GENDER",
                  option: [
                    { nm: "MALE", val: "Male" },
                    { nm: "FEMALE", val: "Female" },
                  ],
                },
              },
              { type: "text", label: "CIVIL STATUS", input: "" },
              { type: "date", label: "DATE OF BIRTH", input: "" },
              { type: "number", label: "AGE", input: "" },
              { type: "text", label: "PLACE OF BIRTH", input: "" },
              { type: "text", label: "HOME PHONE", input: "" },
              { type: "text", label: "MOBILE PHONE", input: "" },
              { type: "text", label: "UNDER INFLUENCE", input: "" },
              { type: "text", label: "RELATIONSHIP TO VICTIM", input: "" },
              { type: "file", label: "ID CARD PRESENTED", input: "" },
            ],
          },
          {
            title: "Current Address",
            cols: 5,
            infos: [
              { type: "text", label: "HOUSE NUMBER/STREET", input: "" },
              { type: "text", label: "VILLAGE/SITIO", input: "" },
              { type: "text", label: "BARANGAY", input: "" },
              { type: "text", label: "TOWN/CITY", input: "" },
              { type: "text", label: "PROVINCE", input: "" },
            ],
          },
          {
            title: "Other Address",
            cols: 5,
            infos: [
              { type: "text", label: "OTHER(HOUSE NUMBER/STREET)", input: "" },
              { type: "text", label: "OTHER(VILLAGE/SITIO)", input: "" },
              { type: "text", label: "OTHER(BARANGAY)", input: "" },
              { type: "text", label: "OTHER(TOWN/CITY)", input: "" },
              { type: "text", label: "OTHER(PROVINCE)", input: "" },
            ],
          },
          {
            title: "Work Adresses",
            cols: 5,
            infos: [
              { type: "text", label: "HOUSE NUMBER/STREET", input: "" },
              { type: "text", label: "VILLAGE/SITIO", input: "" },
              { type: "text", label: "BARANGAY", input: "" },
              { type: "text", label: "TOWN/CITY", input: "" },
              { type: "text", label: "PROVINCE", input: "" },
            ],
          },
          {
            title: "(Physical Characteristics)",
            cols: 7,
            infos: [
              { type: "text", label: "HEIGHT", input: "" },
              { type: "text", label: "WEIGHT", input: "" },
              { type: "text", label: "EYE COLOR", input: "" },
              { type: "text", label: "EYE DESCRIPTION", input: "" },
              { type: "text", label: "HAIR COLOR", input: "" },
              { type: "text", label: "HAIR DESCRIPTION", input: "" },
              { type: "text", label: "BUILT", input: "" },
            ],
          },
          {
            title: "Additional Infos",
            cols: 7,
            infos: [
              {
                type: "text",
                label: "HIGHEST EDUCATION ATTAINMENT",
                input: "",
              },
              { type: "text", label: "OCCUPATION", input: "" },
              /* { type: "text", label: "ID CARD PRESENTED", input: "" }, */
              { type: "text", label: "EMAIL ADDRESS", input: "" },
              { type: "text", label: "FB ACCOUNT", input: "" },
              { type: "text", label: "PNP RANK", input: "" },
              { type: "text", label: "UNIT ASSIGNMENT", input: "" },
              { type: "text", label: "GROUP AFFILLATION", input: "" },
              {
                type: "select",
                label: "HAS PREVIOUS RECORDS",
                input: "",
                options: {
                  selected: "NO PREVIOUS RECORDS",
                  option: [
                    { nm: "YES", val: "YES" },
                    { nm: "NO", val: "NO" },
                  ],
                },
              },
              { type: "text", label: "PREVIOUS RECORD STATUS", input: "" },
            ],
          },
        ],
        innerCitizenAccounts: [
          {
            cols: 5,
            infos: [
              { type: "text", label: "LAST NAME", input: "" },
              { type: "text", label: "FIRST NAME", input: "" },
              { type: "text", label: "MIDDLE NAME", input: "" },
              {
                type: "select",
                label: "GENDER",
                input: "",
                options: {
                  selected: "GENDER",
                  option: [
                    { nm: "MALE", val: "Male" },
                    { nm: "FEMALE", val: "Female" },
                  ],
                },
              },
              { type: "text", label: "FACEBOOK NAME", input: "" },
              { type: "text", label: "EMAIL ADDRESS", input: "" },
              { type: "text", label: "MOBILE NUMBER", input: "" },
              { type: "file2", label: "VALID ID", input: "" },
              { type: "file", label: "PROFILE", input: "" },
            ],
          },
          {
            title: "Current Adress",
            cols: 5,
            infos: [
              { type: "text", label: "HOUSE NUMBER/STREET", input: "" },
              { type: "text", label: "VILLAGE/SITIO", input: "" },
              { type: "text", label: "BARANGAY", input: "" },
              { type: "text", label: "TOWN/CITY", input: "" },
              { type: "text", label: "PROVINCE", input: "" },
            ],
          },
          {
            title: "Other Adress",
            cols: 5,
            infos: [
              { type: "text", label: "OTHER(HOUSE NUMBER/STREET)", input: "" },
              { type: "text", label: "OTHER(VILLAGE/SITIO)", input: "" },
              { type: "text", label: "OTHER(BARANGAY)", input: "" },
              { type: "text", label: "OTHER(TOWN/CITY)", input: "" },
              { type: "text", label: "OTHER(PROVINCE)", input: "" },
            ],
          },
          {
            title: "Account Information",
            cols: 3,
            infos: [
              { type: "text", label: "USERNAME", input: "" },
              { type: "password", label: "PASSWORD", input: "" },
              { type: "password", label: "CONFIRM PASSWORD", input: "" },
            ],
          },
        ],
        innerOfficerAccounts: [
          {
            cols: 5,
            infos: [
              { type: "text", label: "LAST NAME", input: "" },
              { type: "text", label: "FIRST NAME", input: "" },
              { type: "text", label: "MIDDLE NAME", input: "" },
              {
                type: "select",
                label: "GENDER",
                input: "",
                options: {
                  selected: "GENDER",
                  option: [
                    { nm: "MALE", val: "Male" },
                    { nm: "FEMALE", val: "Female" },
                  ],
                },
              },{
                type: "select",
                label: "STATION",
                input: "",
                options: {
                  selected: "STATION",
                  option: [
                    { nm: "STATION 1", val: 1 },
                    { nm: "STATION 2", val: 2 },
                    { nm: "STATION 3", val: 3 },
                    { nm: "STATION 4", val: 4 },
                    { nm: "STATION 5", val: 5 },
                    { nm: "STATION 6", val: 6 },
                  ],
                },
              },
              { type: "text", label: "EMAIL ADDRESS", input: "" },
              { type: "text", label: "MOBILE NUMBER", input: "" },
              { type: "text", label: "RANK", input: "" },
              { type: "file", label: "PROFILE", input: "" },
              {
                type: "select",
                label: "OFFICER TYPE",
                input: 2,
                options: {
                  selected: "SELECT OFFICER TYPE",
                  option: [
                    { nm: "PATROL GROUP", val: 4 },
                    { nm: "OFFICE GROUP", val: 2 },
                  ],
                },
              },
            ],
          },
          {
            title: "Current Adress",
            cols: 5,
            infos: [
              { type: "text", label: "HOUSE NUMBER/STREET", input: "" },
              { type: "text", label: "VILLAGE/SITIO", input: "" },
              { type: "text", label: "BARANGAY", input: "" },
              { type: "text", label: "TOWN/CITY", input: "" },
              { type: "text", label: "PROVINCE", input: "" },
            ],
          },
          {
            title: "Other Adress",
            cols: 5,
            infos: [
              { type: "text", label: "OTHER(HOUSE NUMBER/STREET)", input: "" },
              { type: "text", label: "OTHER(VILLAGE/SITIO)", input: "" },
              { type: "text", label: "OTHER(BARANGAY)", input: "" },
              { type: "text", label: "OTHER(TOWN/CITY)", input: "" },
              { type: "text", label: "OTHER(PROVINCE)", input: "" },
            ],
          },
          {
            title: "Account Information",
            cols: 3,
            infos: [
              { type: "text", label: "USERNAME", input: "" },
              { type: "password", label: "PASSWORD", input: "" },
              { type: "password", label: "CONFIRM PASSWORD", input: "" },
            ],
          },
        ],
      },
      file: null,
      file2: null,
      fileUrl2: "",
      responseMessage: "",
      fileUrl: "",
      id: -1,
    };
  },
  /* IDS */
  methods: {
    extractData() {
      const form = [];

      for (const rows of this.formModel[
        this.$store.getters.CurrentActiveSideBar
      ]) {
        for (const data of rows.infos) {
          form.push(data.input);
        }
      }
      //console.log(form);
    },
    changeSignature(param) {
      this.formModel.innerWitnesses[3].infos[5].input = param;
      console.log(this.formModel.innerWitnesses);
    },
    async sendData() {
      this.loadinging();
      switch (this.$store.getters.getActive) {
        case "innerVictims":
          await this.sendVictims();
          break;
        case "innerWitnesses":
          await this.sendWitness();
          break;
        case "innerNameIncidents":
          await this.sendIncidentType();
          break;
        case "innerSuspects":
          await this.sendSuspect();
          break;
        case "innerCitizenAccounts":
          await this.sendAccount();
          break;
        case "innerOfficerAccounts":
          await this.sendOfficer();
          break;
      }
    },
    async sendVictims() {
      const model = {
        victim: {
          firstname: this.formModel.innerVictims[0].infos[1].input,
          lastname: this.formModel.innerVictims[0].infos[0].input,
          middlename: this.formModel.innerVictims[0].infos[2].input,
          qualifier: this.formModel.innerVictims[0].infos[3].input,
          nickname: this.formModel.innerVictims[0].infos[4].input,
          citizenship: this.formModel.innerVictims[0].infos[5].input,
          gender: this.formModel.innerVictims[0].infos[6].input,
          civil_status: this.formModel.innerVictims[0].infos[7].input,
          birth_date: this.formModel.innerVictims[0].infos[8].input,
          age: this.formModel.innerVictims[0].infos[9].input,
          place_of_birth: this.formModel.innerVictims[0].infos[10].input,
          home_phone: this.formModel.innerVictims[0].infos[11].input,
          mobile_phone: this.formModel.innerVictims[0].infos[12].input,
          highest_educ_attainment:
            this.formModel.innerVictims[3].infos[0].input,
          occupation: this.formModel.innerVictims[3].infos[1].input,
          id_card_presented: this.formModel.innerVictims[3].infos[2].input,
          email: this.formModel.innerVictims[3].infos[3].input,
          fb_account: this.formModel.innerVictims[3].infos[4].input,
          archived_at: null,
          edited_by: this.id /* OFFICER */,
          deleted_by: null,
          added_by: this.id /* OFFICER */,
          under_influence_of: this.formModel.innerVictims[0].infos[13].input,
        },
        current_address: {
          street: this.formModel.innerVictims[1].infos[0].input,
          house_number: this.formModel.innerVictims[1].infos[0].input,
          village: this.formModel.innerVictims[1].infos[1].input,
          barangay: this.formModel.innerVictims[1].infos[2].input,
          city: this.formModel.innerVictims[1].infos[3].input,
          province: this.formModel.innerVictims[1].infos[4].input,
        },
        other_address: {
          street: this.formModel.innerVictims[2].infos[0].input,
          house_number: this.formModel.innerVictims[2].infos[0].input,
          village: this.formModel.innerVictims[2].infos[1].input,
          barangay: this.formModel.innerVictims[2].infos[2].input,
          city: this.formModel.innerVictims[2].infos[3].input,
          province: this.formModel.innerVictims[2].infos[4].input,
        },
        id: this.id,
      };
      const send = await {
        data: model,
        url: "api/victims/add/item/request",
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this.outLoading();
        await this.clearForm();
      } else {
        this.outLoading();
        await alert("An error occured, please try again.");
      }
    },
    async sendWitness() {
      const model = {
        witness: {
          firstname: this.formModel.innerWitnesses[0].infos[1].input,
          lastname: this.formModel.innerWitnesses[0].infos[0].input,
          middlename: this.formModel.innerWitnesses[0].infos[2].input,
          qualifier: this.formModel.innerWitnesses[0].infos[3].input,
          nickname: this.formModel.innerWitnesses[0].infos[4].input,
          citizenship: this.formModel.innerWitnesses[0].infos[5].input,
          gender: this.formModel.innerWitnesses[0].infos[6].input,
          civil_status: this.formModel.innerWitnesses[0].infos[7].input,
          birth_date: this.formModel.innerWitnesses[0].infos[8].input,
          age: this.formModel.innerWitnesses[0].infos[9].input,
          place_of_birth: this.formModel.innerWitnesses[0].infos[10].input,
          home_phone: this.formModel.innerWitnesses[0].infos[11].input,
          mobile_phone: this.formModel.innerWitnesses[0].infos[12].input,
          highest_educ_attainment:
            this.formModel.innerWitnesses[3].infos[0].input,
          occupation: this.formModel.innerWitnesses[3].infos[1].input,
          id_card_presented: this.formModel.innerWitnesses[3].infos[2].input,
          signature: this.formModel.innerWitnesses[3].infos[5].input,
          email: this.formModel.innerWitnesses[3].infos[3].input,
          fb_account: this.formModel.innerWitnesses[3].infos[4].input,
          edited_by: this.id /* OFFICER */,
          added_by: this.id /* OFFICER */,
          under_influence_of: this.formModel.innerWitnesses[0].infos[13].input,
        },
        current_address: {
          street: this.formModel.innerWitnesses[1].infos[0].input,
          house_number: this.formModel.innerWitnesses[1].infos[0].input,
          village: this.formModel.innerWitnesses[1].infos[1].input,
          barangay: this.formModel.innerWitnesses[1].infos[2].input,
          city: this.formModel.innerWitnesses[1].infos[3].input,
          province: this.formModel.innerWitnesses[1].infos[4].input,
        },
        other_address: {
          street: this.formModel.innerWitnesses[2].infos[0].input,
          house_number: this.formModel.innerWitnesses[2].infos[0].input,
          village: this.formModel.innerWitnesses[2].infos[1].input,
          barangay: this.formModel.innerWitnesses[2].infos[2].input,
          city: this.formModel.innerWitnesses[2].infos[3].input,
          province: this.formModel.innerWitnesses[2].infos[4].input,
        },
        id: this.id,
      };
      const send = await {
        data: model,
        url: "api/witness/add/item/request",
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this.outLoading();
        await this.clearForm();
      } else {
        this.outLoading();
        await alert("An error occured, please try again.");
      }
    },
    async sendSuspect() {
      const model = {
        suspect: {
          firstname: this.formModel.innerSuspects[0].infos[1].input,
          lastname: this.formModel.innerSuspects[0].infos[0].input,
          middlename: this.formModel.innerSuspects[0].infos[2].input,
          qualifier: this.formModel.innerSuspects[0].infos[3].input,
          nickname: this.formModel.innerSuspects[0].infos[4].input,
          citizenship: this.formModel.innerSuspects[0].infos[5].input,
          gender: this.formModel.innerSuspects[0].infos[6].input,
          civil_status: this.formModel.innerSuspects[0].infos[7].input,
          birth_date: this.formModel.innerSuspects[0].infos[8].input,
          age: this.formModel.innerSuspects[0].infos[9].input,
          place_of_birth: this.formModel.innerSuspects[0].infos[10].input,
          home_phone: this.formModel.innerSuspects[0].infos[11].input,
          mobile_phone: this.formModel.innerSuspects[0].infos[12].input,
          under_influence_of: this.formModel.innerSuspects[0].infos[13].input,
          relation_to_victim: this.formModel.innerSuspects[0].infos[14].input,
          profile: this.formModel.innerSuspects[0].infos[15].input,
          highest_educ_attainment:
            this.formModel.innerSuspects[5].infos[0].input,
          occupation: this.formModel.innerSuspects[5].infos[1].input,
          email: this.formModel.innerSuspects[5].infos[2].input,
          fb_account: this.formModel.innerSuspects[5].infos[3].input,
          pnp_rank: this.formModel.innerSuspects[5].infos[4].input,
          unit_assignment: this.formModel.innerSuspects[5].infos[5].input,
          group_affiliation: this.formModel.innerSuspects[5].infos[6].input,
          has_previous_record:
            this.formModel.innerSuspects[5].infos[7].input === "YES",
          status: this.formModel.innerSuspects[5].infos[8].input,
          height: this.formModel.innerSuspects[4].infos[0].input,
          weight: this.formModel.innerSuspects[4].infos[1].input,
          built: this.formModel.innerSuspects[4].infos[6].input,
          eyes_color: this.formModel.innerSuspects[4].infos[2].input,
          eyes_description: this.formModel.innerSuspects[4].infos[3].input,
          hair_color: this.formModel.innerSuspects[4].infos[4].input,
          hair_description: this.formModel.innerSuspects[4].infos[5].input,
          edited_by: this.id,
          added_by: this.id,
        },
        current_address: {
          street: this.formModel.innerSuspects[1].infos[0].input,
          house_number: this.formModel.innerSuspects[1].infos[0].input,
          village: this.formModel.innerSuspects[1].infos[1].input,
          barangay: this.formModel.innerSuspects[1].infos[2].input,
          city: this.formModel.innerSuspects[1].infos[3].input,
          province: this.formModel.innerSuspects[1].infos[4].input,
        },
        other_address: {
          street: this.formModel.innerSuspects[2].infos[0].input,
          house_number: this.formModel.innerSuspects[2].infos[0].input,
          village: this.formModel.innerSuspects[2].infos[1].input,
          barangay: this.formModel.innerSuspects[2].infos[2].input,
          city: this.formModel.innerSuspects[2].infos[3].input,
          province: this.formModel.innerSuspects[2].infos[4].input,
        },
        work_address: {
          street: this.formModel.innerSuspects[3].infos[0].input,
          house_number: this.formModel.innerSuspects[3].infos[0].input,
          village: this.formModel.innerSuspects[3].infos[1].input,
          barangay: this.formModel.innerSuspects[3].infos[2].input,
          city: this.formModel.innerSuspects[3].infos[3].input,
          province: this.formModel.innerSuspects[3].infos[4].input,
        },
        id: this.id,
      };
      if (model.suspect.has_previous_record) {
        model.suspect["previous_records_details"] =
          this.formModel.innerSuspects[6].infos[0].input;
        model.suspect.status = this.formModel.innerSuspects[5].infos[8].input;
      }

      const send = await {
        data: model,
        url: "api/suspects/add/item/request",
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this.outLoading();
        await this.clearForm();
      } else {
        this.outLoading();
        await alert("An error occured, please try again.");
      }
    },
    async sendIncidentType() {
      const model = {
        incident_name: this.formModel.innerNameIncidents[0].infos[0].input,
        category: this.formModel.innerNameIncidents[0].infos[2].input,
        sub_type: this.formModel.innerNameIncidents[0].infos[1].input,
        edited_by: this.id,
        added_by: this.id,
      };

      const send = await {
        data: model,
        url: "api/incidentNames/add/item/request",
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this.outLoading();
        await this.clearForm();
      } else {
        this.outLoading();
        await alert("An error occured, please try again.");
      }
    },
    clearForm() {
      const form = [];

      for (const rows of this.formModel[
        this.$store.getters.CurrentActiveSideBar
      ]) {
        for (const data of rows.infos) {
          data.input = null;
        }
      }
      this.reloadTab1({}, this.$store.getters.api);
      //console.log(form);
      this.toggle();
    },
    async sendAccount() {
      const passwrd = this.formModel.innerCitizenAccounts[3].infos[1].input;
      const model = {
        user: {
          last_name: this.formModel.innerCitizenAccounts[0].infos[0].input,
          first_name: this.formModel.innerCitizenAccounts[0].infos[1].input,
          middle_name: this.formModel.innerCitizenAccounts[0].infos[2].input,
          gender: this.formModel.innerCitizenAccounts[0].infos[3].input,
          email: this.formModel.innerCitizenAccounts[0].infos[5].input,
          contact: this.formModel.innerCitizenAccounts[0].infos[6].input,
          profile: this.formModel.innerCitizenAccounts[0].infos[8].input,
          user_name: this.formModel.innerCitizenAccounts[3].infos[0].input,
          password:
            passwrd === this.formModel.innerCitizenAccounts[3].infos[2].input
              ? passwrd
              : null,
          accepted_by: 3,
        },
        current_address: {
          street: this.formModel.innerCitizenAccounts[1].infos[0].input,
          house_number: this.formModel.innerCitizenAccounts[1].infos[0].input,
          village: this.formModel.innerCitizenAccounts[1].infos[1].input,
          barangay: this.formModel.innerCitizenAccounts[1].infos[2].input,
          city: this.formModel.innerCitizenAccounts[1].infos[3].input,
          province: this.formModel.innerCitizenAccounts[1].infos[4].input,
        },
        other_address: {
          street: this.formModel.innerCitizenAccounts[2].infos[0].input,
          house_number: this.formModel.innerCitizenAccounts[2].infos[0].input,
          village: this.formModel.innerCitizenAccounts[2].infos[1].input,
          barangay: this.formModel.innerCitizenAccounts[2].infos[2].input,
          city: this.formModel.innerCitizenAccounts[2].infos[3].input,
          province: this.formModel.innerCitizenAccounts[2].infos[4].input,
        },
        citizen_credentials: {
          valid_id: this.formModel.innerCitizenAccounts[0].infos[7].input,
          fb_name: this.formModel.innerCitizenAccounts[0].infos[4].input,
          accepted_by: 3,
        },
        id: this.id,
      };
      if (!model.user.password) alert("password does not match!");
      else {
        const send = await {
          data: model,
          url: "api/citizenusers/add/item/request",
        };

        const data = await this.$store.dispatch("sendData", send);
        this.res = await data["response"];

        if (this.res == "Success") {
          this.outLoading();
          await this.clearForm();
        } else {
          this.outLoading();
          await alert("An error occured, please try again.");
        }
      }
    },
    async sendOfficer() {
      const passwrd = this.formModel.innerOfficerAccounts[3].infos[1].input;
      const model = {
        user: {
          last_name: this.formModel.innerOfficerAccounts[0].infos[0].input,
          first_name: this.formModel.innerOfficerAccounts[0].infos[1].input,
          middle_name: this.formModel.innerOfficerAccounts[0].infos[2].input,
          gender: this.formModel.innerOfficerAccounts[0].infos[3].input,
          email: this.formModel.innerOfficerAccounts[0].infos[5].input,
          contact: this.formModel.innerOfficerAccounts[0].infos[6].input,
          profile: this.formModel.innerOfficerAccounts[0].infos[8].input,
          user_name: this.formModel.innerOfficerAccounts[3].infos[0].input,
          password:
            passwrd === this.formModel.innerOfficerAccounts[3].infos[2].input
              ? passwrd
              : null,
          accepted_by: 3,
          user_level: this.formModel.innerOfficerAccounts[0].infos[9].input,
        },
        current_address: {
          street: this.formModel.innerOfficerAccounts[1].infos[0].input,
          house_number: this.formModel.innerOfficerAccounts[1].infos[0].input,
          village: this.formModel.innerOfficerAccounts[1].infos[1].input,
          barangay: this.formModel.innerOfficerAccounts[1].infos[2].input,
          city: this.formModel.innerOfficerAccounts[1].infos[3].input,
          province: this.formModel.innerOfficerAccounts[1].infos[4].input,
        },
        other_address: {
          street: this.formModel.innerOfficerAccounts[2].infos[0].input,
          house_number: this.formModel.innerOfficerAccounts[2].infos[0].input,
          village: this.formModel.innerOfficerAccounts[2].infos[1].input,
          barangay: this.formModel.innerOfficerAccounts[2].infos[2].input,
          city: this.formModel.innerOfficerAccounts[2].infos[3].input,
          province: this.formModel.innerOfficerAccounts[2].infos[4].input,
        },
        officer_credentials: {
          station: this.formModel.innerOfficerAccounts[0].infos[4].input,
          rank: this.formModel.innerOfficerAccounts[0].infos[7].input,
        },
        id: this.id,
      };

      if (!model.user.password) alert("password does not match!");
      else {
        const send = await {
          data: model,
          url: "api/officerusers/add/item/request",
        };

        const data = await this.$store.dispatch("sendData", send);
        this.res = await data["response"];

        if (this.res == "Success") {
          this.outLoading();
          await this.clearForm();
        } else {
          this.outLoading();
          await alert("An error occured, please try again.");
        }
      }
    },
    onFileChange2(event) {
      this.file2 = event.target.files[0];
      this.uploadFile2();
    },
    async uploadFile2() {
      if (!this.file2) {
        this.responseMessage = "No file selected.";
        return;
      }

      let formData = new FormData();
      formData.append("file", this.file2);

      try {
        const response = await this.$store.dispatch("sendData", {
          url: "api/file/upload",
          data: formData,
        });
        this.responseMessage = response["response"];
        if (this.responseMessage == "Success") {
          this.fileUrl2 = response.file_path;
          if (
            this.$store.getters.CurrentActiveSideBar == "innerCitizenAccounts"
          )
            this.formModel.innerCitizenAccounts[0].infos[7].input =
              this.fileUrl2;
        }
      } catch (error) {
        console.error(error);
        this.responseMessage = "Upload failed.";
      }
      alert(this.responseMessage);
    },
    onFileChange(event) {
      this.file = event.target.files[0];
      this.uploadFile();
    },
    async uploadFile() {
      if (!this.file) {
        this.responseMessage = "No file selected.";
        return;
      }

      let formData = new FormData();
      formData.append("file", this.file);

      try {
        const response = await this.$store.dispatch("sendData", {
          url: "api/file/upload",
          data: formData,
        });
        this.responseMessage = response["response"];
        if (this.responseMessage == "Success") {
          this.fileUrl = response.file_path;
          if (this.$store.getters.CurrentActiveSideBar == "innerWitnesses")
            this.formModel.innerWitnesses[3].infos[2].input = this.fileUrl;
          if (this.$store.getters.CurrentActiveSideBar == "innerVictims")
            this.formModel.innerVictims[3].infos[2].input = this.fileUrl;
          if (this.$store.getters.CurrentActiveSideBar == "innerSuspects")
            this.formModel.innerSuspects[0].infos[15].input = this.fileUrl;
          if (
            this.$store.getters.CurrentActiveSideBar == "innerCitizenAccounts"
          )
            this.formModel.innerCitizenAccounts[0].infos[8].input =
              this.fileUrl;
          if (
            this.$store.getters.CurrentActiveSideBar == "innerOfficerAccounts"
          )
            this.formModel.innerOfficerAccounts[0].infos[8].input =
              this.fileUrl;
        }
      } catch (error) {
        console.error(error);
        this.responseMessage = "Upload failed.";
      }
      alert(this.responseMessage);
    },
    initAutocomplete() {
      if (typeof google === "undefined") {
        console.error("Google Maps JavaScript API not loaded");
        return;
      }
    },
    setItUp(theId, key) {
      const input = document.getElementById(theId);
      const autocomplete = new google.maps.places.Autocomplete(input, {
        types: ["address"],
        fields: ["address_components"],
        componentRestrictions: { country: "ph" }, // Restrict to the Philippines
      });

      autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();

        autocomplete.getPlace().address_components.forEach((component) => {
          const types = component.types;
          const value = component.long_name;

          if (types.includes("street_number")) {
            this[key].house_number = value;
          } else if (types.includes("route")) {
            this[key].street = value;
          } else if (
            types.includes("sublocality") ||
            types.includes("sublocality_level_1")
          ) {
            this[key].village = value;
          } else if (types.includes("locality")) {
            this[key].city = value;
          } else if (types.includes("administrative_area_level_2")) {
            this[key].barangay = value;
          } else if (types.includes("administrative_area_level_1")) {
            this[key].province = value;
          }
        });
      });
    },
    async loadAPI() {
      return new Promise((resolve, reject) => {
        const script = document.createElement("script");
        script.src =
          "https://maps.googleapis.com/maps/api/js?key=AIzaSyAfuU61GhND_tK2_KxcvLtT3tLbJiqlmTM&libraries=places";
        script.async = true;
        script.defer = true;
        script.onload = resolve;
        script.onerror = reject;
        document.head.appendChild(script);
      });
    },
  },
  created() {
    this.loadAPI();
    const credential = JSON.parse(localStorage.getItem("credentials"));
    this.id = credential.id;
  },
  props: ["reloadTab1", "toggle", "loadinging", "outLoading"],
  computed: {},
  watch: {
    "formModel.innerSuspects.5.infos.7.input": function (newVal, oldVal) {
      console.log("The input value changed from", oldVal, "to", newVal);

      if (newVal == "YES")
        this.formModel.innerSuspects.push({
          cols: 1,
          infos: [
            { type: "area", label: "PREVIOUS RECORD DETAILS", input: "" },
          ],
        });
      else if (oldVal == "YES" && newVal != "YES")
        this.formModel.innerSuspects.pop();
    },
    "formModel.innerSuspects.6.infos.0.input": function (newVal, oldVal) {
      console.log(newVal, oldVal);
    },
  },
  components: {
    signatures,
  },
};
</script>

<style>
</style>