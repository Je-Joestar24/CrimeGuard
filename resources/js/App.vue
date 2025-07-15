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
  watch: {},
  created() {
    const credentials = JSON.parse(localStorage.getItem("credentials"));
    if (credentials) {
      if (credentials.user_level == 1) {
        this.$router.push("/Admin/Dashboard");
      } else if (credentials.user_level == 2) {
        this.$router.push("/OFFICER/Dashboard");
      }
    }
  },
  methods: {},
};
</script>
  
<script setup>
import { faker } from "@faker-js/faker";
import { onMounted } from "vue";
import { useStore } from 'vuex'

const store = useStore()
let users = [];
const filipinoFullNames = [
  { firstname: "Christian", lastname: "Dela Cruz", gender: "male" },
  { firstname: "Jonald", lastname: "Reyes", gender: "male" },
  { firstname: "Mark", lastname: "Santos", gender: "male" },
  { firstname: "Joshua", lastname: "Bautista", gender: "male" },
  { firstname: "Angelo", lastname: "Garcia", gender: "male" },
  { firstname: "RJ", lastname: "Ramos", gender: "male" },
  { firstname: "Jayvee", lastname: "Mendoza", gender: "male" },
  { firstname: "Justine", lastname: "Torres", gender: "male" },
  { firstname: "Rey", lastname: "Lopez", gender: "male" },
  { firstname: "Kevin", lastname: "Gonzales", gender: "male" },
  { firstname: "Jomar", lastname: "Fernandez", gender: "male" },
  { firstname: "Francis", lastname: "Cruz", gender: "male" },
  { firstname: "Arvin", lastname: "Castro", gender: "male" },
  { firstname: "John Paul", lastname: "Flores", gender: "male" },
  { firstname: "Ken", lastname: "Morales", gender: "male" },
  { firstname: "Alden", lastname: "Salazar", gender: "male" },
  { firstname: "Nathan", lastname: "Dominguez", gender: "male" },
  { firstname: "Enzo", lastname: "Aguilar", gender: "male" },
  { firstname: "Miguel", lastname: "Navarro", gender: "male" },
  { firstname: "Cedric", lastname: "Vega", gender: "male" },
  { firstname: "Christiana", lastname: "Alvarez", gender: "female" },
  { firstname: "Hira", lastname: "Talle", gender: "female" },
  { firstname: "Angel", lastname: "Rodriguez", gender: "female" },
  { firstname: "Joy", lastname: "Martinez", gender: "female" },
  { firstname: "Kim", lastname: "Rivera", gender: "female" },
  { firstname: "Mae", lastname: "Sanchez", gender: "female" },
  { firstname: "Danica", lastname: "Tornos", gender: "female" },
  { firstname: "Ella", lastname: "Domaos", gender: "female" },
  { firstname: "Princess", lastname: "Payod", gender: "female" },
  { firstname: "Lovely", lastname: "Maristelle", gender: "female" },
  { firstname: "Clarisse", lastname: "Salve", gender: "female" },
  { firstname: "Charmaine", lastname: "Tio", gender: "female" },
  { firstname: "Jasmine", lastname: "Hermoso", gender: "female" },
  { firstname: "Kyla", lastname: "Donayre", gender: "female" },
  { firstname: "Lianne", lastname: "Dosdos", gender: "female" },
  { firstname: "Nicole", lastname: "Pastor", gender: "female" },
  { firstname: "Heart", lastname: "Dinoy", gender: "female" },
  { firstname: "Rica", lastname: "Cabatchete", gender: "female" },
  { firstname: "Sheena", lastname: "Burlas", gender: "female" },
  { firstname: "Bianca", lastname: "Guape", gender: "female" },
  { firstname: "Christian", lastname: "Payod", gender: "male" },
  { firstname: "Jonald", lastname: "Dinoy", gender: "male" },
  { firstname: "Mark", lastname: "Guape", gender: "male" },
  { firstname: "Joshua", lastname: "Salve", gender: "male" },
  { firstname: "Angelo", lastname: "Domaos", gender: "male" },
  { firstname: "RJ", lastname: "Cruz", gender: "male" },
  { firstname: "Jayvee", lastname: "Rodriguez", gender: "male" },
  { firstname: "Justine", lastname: "Dosdos", gender: "male" },
  { firstname: "Rey", lastname: "Donayre", gender: "male" },
  { firstname: "Kevin", lastname: "Santos", gender: "male" },
  { firstname: "Jomar", lastname: "Lopez", gender: "male" },
  { firstname: "Francis", lastname: "Talle", gender: "male" },
  { firstname: "Arvin", lastname: "Gonzales", gender: "male" },
  { firstname: "John Paul", lastname: "Morales", gender: "male" },
  { firstname: "Ken", lastname: "Pastor", gender: "male" },
  { firstname: "Alden", lastname: "Burlas", gender: "male" },
  { firstname: "Nathan", lastname: "Reyes", gender: "male" },
  { firstname: "Enzo", lastname: "Fernandez", gender: "male" },
  { firstname: "Miguel", lastname: "Navarro", gender: "male" },
  { firstname: "Cedric", lastname: "Tio", gender: "male" },
  { firstname: "Christiana", lastname: "Martinez", gender: "female" },
  { firstname: "Hira", lastname: "Vega", gender: "female" },
  { firstname: "Angel", lastname: "Aguilar", gender: "female" },
  { firstname: "Joy", lastname: "Cabatchete", gender: "female" },
  { firstname: "Kim", lastname: "Rivera", gender: "female" },
  { firstname: "Mae", lastname: "Castro", gender: "female" },
  { firstname: "Danica", lastname: "Bautista", gender: "female" },
  { firstname: "Ella", lastname: "Salazar", gender: "female" },
  { firstname: "Princess", lastname: "Mendoza", gender: "female" },
  { firstname: "Lovely", lastname: "Dominguez", gender: "female" },
  { firstname: "Clarisse", lastname: "Flores", gender: "female" },
  { firstname: "Charmaine", lastname: "Dela Cruz", gender: "female" },
  { firstname: "Jasmine", lastname: "Alvarez", gender: "female" },
];
// Delay function that returns a Promise
const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms))

const address = {
  street: "",
  house_number: "",
  village: "",
  barangay: "",
  city: "",
  province: "",
  block: "",
  sitio: "",
};

const generate = (firstname, lastname, con, gender) => {
  const alpha = "ABCDEFGHIJKLMNOP";
  return {
    email: `${firstname}${lastname}@gmail.com`
      .split(" ")
      .join("")
      .toLowerCase(),
    valid_id: "naaysud",
    password: "password123",
    first_name: firstname,
    last_name: lastname,
    middle_name: `${alpha.charAt(Math.floor(Math.random() * alpha.length))}`,
    contact: `09073013${Number(con) + 100}`,
    gender: gender,
    fb_name: `${firstname} ${lastname}`,
    user_name: `${firstname}${con}`,
    profile: "naaysud",
    accepted_by: 3,
  };
};

const sreq = async (signUpForm, current_address, other_address) => {
  const sf = {
    user: signUpForm,
    id: 3,
    current_address: current_address,
    other_address: other_address,
    citizen_credentials: {
      valid_id: signUpForm.valid_id,
      fb_name: signUpForm.fb_name,
      accepted_by: 3,
    },
  };

  const toBESEND = {
    url: "api/citizenusers/add/item/request",
    data: sf,
  };

  console.log(toBESEND)
  await store.dispatch("sendData", toBESEND);
};
/* 
onMounted(async () => {
  for (let i = 0; i < 35; i++) {
    const user = filipinoFullNames[i];
    const generated = generate(
      user.firstname,
      user.lastname,
      i,
      user.gender.toUpperCase()
    );

    try {
      await sreq(generated, address, address)
    } catch (error) {
      console.error(`Failed on ${user.firstname} ${user.lastname}:`, error)
    }

    await delay(1500)
  }
}) */
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
  
