<template>
  <form class="p-4 md:p-5">
    <div v-for="model in formModel[envolvePerson]">
      <p v-if="model.title" class="text-gray-700 mb-3">
        {{ "(" + model.title + ")" }}:
      </p>
      <div
        v-bind:class="`grid gap-3`"
        :style="
          'display:grid; grid-template-columns: repeat(' +
          model.cols +
          ', 1fr);'
        "
      >
        <div class="relative z-0 w-full mb-5 group" v-for="mdl in model.infos">
          <input
            v-if="
              mdl.type != 'select' &&
              mdl.type != 'area' &&
              mdl.type != 'file' &&
              mdl.type != 'file2' &&
              mdl.type != 'signature'
            "
            :type="mdl.type"
            v-model="mdl.input"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" "
            required
          />

          <input
            class="block pt-2 pb-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            v-if="mdl.type == 'file'"
            type="file"
            @change="onFileChange"
          />

          <input
            class="block pt-2 pb-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            v-if="mdl.type == 'file2'"
            type="file"
            @change="onFileChange2"
          />

          <signatures
            class="w-full"
            v-if="mdl.type == 'signature'"
            :setData="changeSignature"
            :data="mdl.input"
          ></signatures>
          <label
            class="block mb-2 text-sm font-medium text-gray-500"
            v-if="mdl.type == 'area'"
            >{{ mdl.label }}</label
          >
          <textarea
            v-if="mdl.type == 'area'"
            rows="2"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Write here..."
            v-model="mdl.input"
          ></textarea>
          <select
            v-if="mdl.type == 'select'"
            v-model="mdl.input"
            class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
          >
            <option value="">{{ mdl.options.selected }}</option>
            <option v-for="opt in mdl.options.option" :value="opt.val">
              {{ opt.val }}
            </option>
          </select>
          <label
            v-if="mdl.type != 'area'"
            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >{{ mdl.label }}</label
          >
        </div>
      </div>
    </div>
    <button
      type="button"
      @click.prevent="sendData"
      class="text-white wfu bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-2.5 py-1.5 text-center"
      data-modal-hide="incident-modal"
    >
      <!-- dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 -->
      SAVE
    </button>
  </form>
</template>
  

  <script>
import signatures from "../modComps/signature.vue"
;
export default {
  data() {
    return {
      prevRecord: "",
      formModel: {
        Witness: [
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
        Victims: [
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
        Suspects: [
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
      },
    };
  },
  methods: {
    changeSignature(param){
      this.formModel.Witness[3].infos[5].input = param;
      console.log(this.formModel.innerWitnesses)
    },
    async sendData() {
      switch (this.envolvePerson) {
        case "Victims":
          await this.sendVictims();
          break;
        case "Witness":
          await this.sendWitness();
          break;
        case "Suspects":
          await this.sendSuspect();
          break;
      }
    },
    async sendVictims() {
      const model = {
        victim: {
          firstname: this.formModel.Victims[0].infos[1].input,
          lastname: this.formModel.Victims[0].infos[0].input,
          middlename: this.formModel.Victims[0].infos[2].input,
          qualifier: this.formModel.Victims[0].infos[3].input,
          nickname: this.formModel.Victims[0].infos[4].input,
          citizenship: this.formModel.Victims[0].infos[5].input,
          gender: this.formModel.Victims[0].infos[6].input,
          civil_status: this.formModel.Victims[0].infos[7].input,
          birth_date: this.formModel.Victims[0].infos[8].input,
          age: this.formModel.Victims[0].infos[9].input,
          place_of_birth: this.formModel.Victims[0].infos[10].input,
          home_phone: this.formModel.Victims[0].infos[11].input,
          mobile_phone: this.formModel.Victims[0].infos[12].input,
          highest_educ_attainment:
            this.formModel.Victims[3].infos[0].input,
          occupation: this.formModel.Victims[3].infos[1].input,
          id_card_presented: this.formModel.Victims[3].infos[2].input,
          email: this.formModel.Victims[3].infos[3].input,
          fb_account: this.formModel.Victims[3].infos[4].input,
          archived_at: null,
          edited_by: this.id /* OFFICER */,
          deleted_by: null,
          added_by: this.id /* OFFICER */,
          under_influence_of: this.formModel.Victims[0].infos[13].input,
        },
        current_address: {
          street: this.formModel.Victims[1].infos[0].input,
          house_number: this.formModel.Victims[1].infos[0].input,
          village: this.formModel.Victims[1].infos[1].input,
          barangay: this.formModel.Victims[1].infos[2].input,
          city: this.formModel.Victims[1].infos[3].input,
          province: this.formModel.Victims[1].infos[4].input,
        },
        other_address: {
          street: this.formModel.Victims[2].infos[0].input,
          house_number: this.formModel.Victims[2].infos[0].input,
          village: this.formModel.Victims[2].infos[1].input,
          barangay: this.formModel.Victims[2].infos[2].input,
          city: this.formModel.Victims[2].infos[3].input,
          province: this.formModel.Victims[2].infos[4].input,
        },
        id: this.id,
      };
      const send = { key: "victims", data: model };
      this.sendPerson(send);
      this.clearForm();
    },
    async sendWitness() {
      const model = {
        witness: {
          firstname: this.formModel.Witness[0].infos[1].input,
          lastname: this.formModel.Witness[0].infos[0].input,
          middlename: this.formModel.Witness[0].infos[2].input,
          qualifier: this.formModel.Witness[0].infos[3].input,
          nickname: this.formModel.Witness[0].infos[4].input,
          citizenship: this.formModel.Witness[0].infos[5].input,
          gender: this.formModel.Witness[0].infos[6].input,
          civil_status: this.formModel.Witness[0].infos[7].input,
          birth_date: this.formModel.Witness[0].infos[8].input,
          age: this.formModel.Witness[0].infos[9].input,
          place_of_birth: this.formModel.Witness[0].infos[10].input,
          home_phone: this.formModel.Witness[0].infos[11].input,
          mobile_phone: this.formModel.Witness[0].infos[12].input,
          highest_educ_attainment:
            this.formModel.Witness[3].infos[0].input,
          occupation: this.formModel.Witness[3].infos[1].input,
          id_card_presented: this.formModel.Witness[3].infos[2].input,
          signature: this.formModel.Witness[3].infos[5].input,
          email: this.formModel.Witness[3].infos[3].input,
          fb_account: this.formModel.Witness[3].infos[4].input,
          edited_by: this.id /* OFFICER */,
          added_by: this.id /* OFFICER */,
          under_influence_of: this.formModel.Witness[0].infos[13].input,
        },
        current_address: {
          street: this.formModel.Witness[1].infos[0].input,
          house_number: this.formModel.Witness[1].infos[0].input,
          village: this.formModel.Witness[1].infos[1].input,
          barangay: this.formModel.Witness[1].infos[2].input,
          city: this.formModel.Witness[1].infos[3].input,
          province: this.formModel.Witness[1].infos[4].input,
        },
        other_address: {
          street: this.formModel.Witness[2].infos[0].input,
          house_number: this.formModel.Witness[2].infos[0].input,
          village: this.formModel.Witness[2].infos[1].input,
          barangay: this.formModel.Witness[2].infos[2].input,
          city: this.formModel.Witness[2].infos[3].input,
          province: this.formModel.Witness[2].infos[4].input,
        },
        id: this.id,
      };
      const send = { key: "witness", data: model };
      this.sendPerson(send);
      this.clearForm();
    },
    async sendSuspect() {
      const model = {
        suspect: {
          firstname: this.formModel.Suspects[0].infos[1].input,
          lastname: this.formModel.Suspects[0].infos[0].input,
          middlename: this.formModel.Suspects[0].infos[2].input,
          qualifier: this.formModel.Suspects[0].infos[3].input,
          nickname: this.formModel.Suspects[0].infos[4].input,
          citizenship: this.formModel.Suspects[0].infos[5].input,
          gender: this.formModel.Suspects[0].infos[6].input,
          civil_status: this.formModel.Suspects[0].infos[7].input,
          birth_date: this.formModel.Suspects[0].infos[8].input,
          age: this.formModel.Suspects[0].infos[9].input,
          place_of_birth: this.formModel.Suspects[0].infos[10].input,
          home_phone: this.formModel.Suspects[0].infos[11].input,
          mobile_phone: this.formModel.Suspects[0].infos[12].input,
          under_influence_of: this.formModel.Suspects[0].infos[13].input,
          relation_to_victim: this.formModel.Suspects[0].infos[14].input,
          profile: this.formModel.Suspects[0].infos[15].input,
          highest_educ_attainment:
            this.formModel.Suspects[5].infos[0].input,
          occupation: this.formModel.Suspects[5].infos[1].input,
          email: this.formModel.Suspects[5].infos[2].input,
          fb_account: this.formModel.Suspects[5].infos[3].input,
          pnp_rank: this.formModel.Suspects[5].infos[4].input,
          unit_assignment: this.formModel.Suspects[5].infos[5].input,
          group_affiliation: this.formModel.Suspects[5].infos[6].input,
          has_previous_record:
            this.formModel.Suspects[5].infos[7].input === "YES",
          status: this.formModel.Suspects[5].infos[8].input,
          height: this.formModel.Suspects[4].infos[0].input,
          weight: this.formModel.Suspects[4].infos[1].input,
          built: this.formModel.Suspects[4].infos[6].input,
          eyes_color: this.formModel.Suspects[4].infos[2].input,
          eyes_description: this.formModel.Suspects[4].infos[3].input,
          hair_color: this.formModel.Suspects[4].infos[4].input,
          hair_description: this.formModel.Suspects[4].infos[5].input,
          edited_by: this.id,
          added_by: this.id,
        },
        current_address: {
          street: this.formModel.Suspects[1].infos[0].input,
          house_number: this.formModel.Suspects[1].infos[0].input,
          village: this.formModel.Suspects[1].infos[1].input,
          barangay: this.formModel.Suspects[1].infos[2].input,
          city: this.formModel.Suspects[1].infos[3].input,
          province: this.formModel.Suspects[1].infos[4].input,
        },
        other_address: {
          street: this.formModel.Suspects[2].infos[0].input,
          house_number: this.formModel.Suspects[2].infos[0].input,
          village: this.formModel.Suspects[2].infos[1].input,
          barangay: this.formModel.Suspects[2].infos[2].input,
          city: this.formModel.Suspects[2].infos[3].input,
          province: this.formModel.Suspects[2].infos[4].input,
        },
        work_address: {
          street: this.formModel.Suspects[3].infos[0].input,
          house_number: this.formModel.Suspects[3].infos[0].input,
          village: this.formModel.Suspects[3].infos[1].input,
          barangay: this.formModel.Suspects[3].infos[2].input,
          city: this.formModel.Suspects[3].infos[3].input,
          province: this.formModel.Suspects[3].infos[4].input,
        },
        id: this.id,
      };

      if (model.suspect.has_previous_record) {
        model.suspect["previous_records_details"] =
          this.formModel.Suspects[6].infos[0].input;
        model.suspect.status = this.formModel.Suspects[5].infos[8].input;
      }
      //console.log(model);

      const send = { key: "suspects", data: model };
      this.sendPerson(send);
      this.clearForm();
    },
    clearForm() {
      const form = [];

      for (const rows of this.formModel[this.envolvePerson]) {
        for (const data of rows.infos) {
          data.input = null;
        }
      }
      this.toggle("");
      //console.log(form);
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
          if (this.envolvePerson == "Witness") {
            this.formModel.Witness[3].infos[2].input = this.fileUrl;
          }
          if (this.envolvePerson == "Victims") {
            this.formModel.Victims[3].infos[2].input = this.fileUrl;
            console.log(this.formModel.Victims);
          }
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

      if (this.envolvePerson == "Victims") {
        this.setItUp("victim_current_street");
        this.setItUp("victim_current_village");
        this.setItUp("victim_current_barangay");
        this.setItUp("victim_current_city");
        this.setItUp("victim_current_province");

        this.setItUp("victim_current_street");
        this.setItUp("victim_current_village");
        this.setItUp("victim_current_barangay");
        this.setItUp("victim_current_city");
        this.setItUp("victim_current_province");
      }
    },
    setItUp(theId) {
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
            console.log(value);
          } else if (types.includes("route")) {
            console.log(value);
          } else if (
            types.includes("sublocality") ||
            types.includes("sublocality_level_1")
          ) {
            console.log(value);
          } else if (types.includes("locality")) {
            console.log(value);
          } else if (types.includes("administrative_area_level_2")) {
            console.log(value);
          } else if (types.includes("administrative_area_level_1")) {
            console.log(value);
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
    (async () => {
      await this.loadAPI();
      await this.initAutocomplete();
    })();
    // alert(this.envolvePerson);
  },
  props: ["reloadTab1", "envolvePerson", "sendPerson", "toggle"],
  computed: {},
  watch: {
    "formModel.Suspects.5.infos.7.input": function (newVal, oldVal) {
      console.log("The input value changed from", oldVal, "to", newVal);

      if (newVal == "YES")
        this.formModel.Suspects.push({
          cols: 1,
          infos: [
            { type: "area", label: "PREVIOUS RECORD DETAILS", input: "" },
          ],
        });
      else if (oldVal == "YES" && newVal != "YES")
        this.formModel.Suspects.pop();
    },
    "formModel.Suspects.6.infos.0.input": function (newVal, oldVal) {
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