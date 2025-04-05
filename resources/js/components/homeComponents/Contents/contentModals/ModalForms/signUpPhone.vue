<template>
    <div class="fixed z-50 bg-white top-0  animate-popup w-full overflow-auto  pb-20 parent-con" style="height: 100vh;">
      <div class="w-full flex justify-between p-2">
        <img :src="'/images/system/bg.png'" alt="" class="w-12 h-12 m-2">
        <svg
          class="w-10 h-10 p-2 text-blue-300 rounded-xl cursor-pointer hover:bg-opacity-50 hover:bg-blue-500 hover:text-white"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 14 14"
          @click.prevent="changeA()"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
          />
        </svg>
      </div>
      <h2 class="text-center text-xl font-bold text-gray-800 mb-2">
        Create Account
      </h2>
      <p class="text-center text-sm text-gray-600 mb-6">
        Join Crime Guard to help keep your community safe
      </p>
      <div v-if="face_detect"  class="fixed bg-gray-100" style="z-index: 10; top: 0; right: 0; width: 100vw; height: 100vh;">
        <face-scanner v-if="face_detect" :checked="check_it" :toggle="toggle_checker"/>
      </div>
      <form class="max-w-lg mx-auto pb-3 bg-white px-10">
        <div v-if="err || (!err && submited)" class="mb-4 p-4 rounded-md" :class="err ? 'bg-red-50 border border-red-300' : 'bg-green-50 border border-green-300'">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg v-if="err" class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
              <svg v-else class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium" :class="err ? 'text-red-800' : 'text-green-800'">
                {{ err ? 'Error' : 'Success' }}
              </h3>
              <div class="mt-2 text-sm" :class="err ? 'text-red-700' : 'text-green-700'">
                <p>
                  {{ err ? 'Please fill up the form correctly.' : 'Account request sent, waiting for police station to approve.' }}
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- HERE -->
        <!-- Personal Information -->
        <div class="w-full" v-show="active == 1">
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">Personal Information</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative z-0 w-full group">
              <input
                type="text"
                class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                v-model="signUpForm.last_name"
                required
              />
              <label
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Last Name</label>
            </div>
            <div class="relative z-0 w-full group">
              <input
                type="text"
                class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                v-model="signUpForm.first_name"                required
              />
              <label
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >First Name</label>
            </div>
            <div class="relative z-0 w-full group">
              <input
                type="text"
                class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                v-model="signUpForm.middle_name"
                required
              />
              <label
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Middle Name</label>
            </div>
          </div>
          
          <div class="grid grid-cols-2 gap-6 mt-4">
            <div class="relative z-0 w-full group">
              <label class="block text-sm font-medium text-gray-700 mb-2" for="valid_id">Valid ID</label>
              <input
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                type="file"
                @change="onFileChange($event, 'valid_id')"
              />
            </div>
            <div class="relative z-0 w-full group">
              <label
                class="block text-sm font-medium text-gray-600 mb-2"
                for="profile"
                >PROFILE CHECK:</label
              >
              <div class="flex items-center gap-2">
                <button 
                  v-if="face_checked"
                  type="button"
                  class="px-4 py-2 text-xs font-medium text-green-700 bg-green-200 border border-green-300 rounded-lg hover:bg-green-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                >
                  <span class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />  <polyline points="22 4 12 14.01 9 11.01" /></svg>
                    PROFILE VERIFIED
                  </span>
                </button>
                <button
                  v-else 
                  @click.prevent="toggle_checker()"
                  type="button"
                  class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                >
                  <span class="flex items-center">
                    <svg class="h-2 w-2 text-red-500 mr-1"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" /></svg>
                    VERIFY PROFILE
                  </span>
                </button>
                <span class="text-sm text-gray-500" v-if="signUpForm.profile">
                  {{ signUpForm.profile.name }}
                </span>
              </div>
              <input
                v-show="false"
                ref="profileInput"
                class="hidden"
                type="file"
                @change="onFileChange($event, 'profile')"
                accept="image/*"
              />
            </div>
          </div>
          
          <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sex</label>
            <select
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              v-model="signUpForm.gender"
            >
              <option value="">Select Gender</option>
              <option value="MALE">Male</option>
              <option value="FEMALE">Female</option>
            </select>
          </div>
          
          <div class="mt-4">
            <div class="relative z-0 w-full group">
              <input
                type="email"
                class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                v-model="signUpForm.email"
                required
              />
              <label
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Email Address</label>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div class="relative z-0 w-full group">
              <input
                type="tel"
                pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                v-model="signUpForm.contact"
                required
              />
              <label
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Mobile Number</label>
            </div>
            <div class="relative z-0 w-full group">
              <input
                type="text"
                class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                v-model="signUpForm.fb_name"
                required
              />
              <label
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Facebook Name</label>
            </div>
          </div>
        </div>  
        <div class="w-full" v-show="active == 2">
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">Current Address</h2>
          <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="relative z-0 w-full group">
                <input
                  id="signup_current_province"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="current_address.province"
                  @click="
                    setKeyVal('province', current_address);
                    generateAddress(current_address, 'province');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_current_province"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Province</label>
              </div>
              <div class="relative z-0 w-full group">
                <input
                  id="signup_current_city"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="current_address.city"
                  @click="
                    setKeyVal('city', current_address);
                    generateAddress(current_address, 'city');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_current_city"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >City</label>
              </div>
            </div>
      
            <div class="relative z-0 w-full group">
              <input
                id="signup_current_barangay"
                type="text"
                class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                v-model="current_address.barangay"
                @click="
                  setKeyVal('barangay', current_address);
                  generateAddress(current_address, 'barangay');
                "
                required
                placeholder=" "
              />
              <label
                for="signup_current_barangay"
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Barangay</label>
            </div>
      
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="relative z-0 w-full group">
                <input
                  id="signup_current_village"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="current_address.sitio"
                  @click="
                    setKeyVal('sitio', current_address);
                    generateAddress(current_address, 'sitio');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_current_village"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Sitio</label>
              </div>
              <div class="relative z-0 w-full group">
                <input
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="current_address.village"
                  @click="
                    setKeyVal('village', current_address);
                    generateAddress(current_address, 'village');
                  "
                  required
                  placeholder=" "
                />
                <label
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Village</label>
              </div>
              <div class="relative z-0 w-full group">
                <input
                  id="signup_current_street"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="current_address.street"
                  @click="
                    setKeyVal('street', current_address);
                    generateAddress(current_address, 'street');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_current_street"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Street</label>
              </div>
            </div>
      
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="relative z-0 w-full group">
                <input
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="current_address.house_number"
                  @click="
                    setKeyVal('house_number', current_address);
                    generateAddress(current_address, 'house_number');
                  "
                  required
                  placeholder=" "
                />
                <label
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >House No.</label>
              </div>
              <div class="relative z-0 w-full group">
                <input
                  id="signup_current_house_no"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="current_address.block"
                  @click="
                    setKeyVal('block', current_address);
                    generateAddress(current_address, 'block');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_current_house_no"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Block</label>
              </div>
            </div>
          </div>
      
          <!-- Address suggestions -->
          <div v-if="places.length > 0" class="mt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Suggestions:</h3>
            <ul class="bg-white divide-y divide-gray-200 rounded-md border border-gray-300 max-h-40 overflow-auto">
              <li v-for="p in places" :key="p" class="px-4 py-2 hover:bg-gray-100 cursor-pointer" @click="setAddress(values, key, p)">
                {{ p }}
              </li>
            </ul>
          </div>
        </div>
        <div class="w-full" v-show="active == 3">
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">Other Address</h2>
          <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="relative z-0 w-full group">
                <input
                  id="signup_other_province"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="other_address.province"
                  @click="
                    setKeyVal('province', other_address);
                    generateAddress(other_address, 'province');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_other_province"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Province</label>
              </div>
              <div class="relative z-0 w-full group">
                <input
                  id="signup_other_city"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="other_address.city"
                  @click="
                    setKeyVal('city', other_address);
                    generateAddress(other_address, 'city');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_other_city"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >City</label>
              </div>
            </div>
        
            <div class="relative z-0 w-full group">
              <input
                id="signup_other_barangay"
                type="text"
                class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                v-model="other_address.barangay"
                @click="
                  setKeyVal('barangay', other_address);
                  generateAddress(other_address, 'barangay');
                "
                required
                placeholder=" "
              />
              <label
                for="signup_other_barangay"
                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Barangay</label>
            </div>
        
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="relative z-0 w-full group">
                <input
                  id="signup_other_sitio"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="other_address.sitio"
                  @click="
                    setKeyVal('sitio', other_address);
                    generateAddress(other_address, 'sitio');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_other_sitio"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Sitio</label>
              </div>
              <div class="relative z-0 w-full group">
                <input
                  id="signup_other_village"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="other_address.village"
                  @click="
                    setKeyVal('village', other_address);
                    generateAddress(other_address, 'village');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_other_village"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Village</label>
              </div>
              <div class="relative z-0 w-full group">
                <input
                  id="signup_other_street"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="other_address.street"
                  @click="
                    setKeyVal('street', other_address);
                    generateAddress(other_address, 'street');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_other_street"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Street</label>
              </div>
            </div>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="relative z-0 w-full group">
                <input
                  id="signup_other_house_no"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="other_address.house_number"
                  @click="
                    setKeyVal('house_number', other_address);
                    generateAddress(other_address, 'house_number');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_other_house_no"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >House No.</label>
              </div>
              <div class="relative z-0 w-full group">
                <input
                  id="signup_other_block"
                  type="text"
                  class="block w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                  v-model="other_address.block"
                  @click="
                    setKeyVal('block', other_address);
                    generateAddress(other_address, 'block');
                  "
                  required
                  placeholder=" "
                />
                <label
                  for="signup_other_block"
                  class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Block</label>
              </div>
            </div>
          </div>
        
          <!-- Address suggestions -->
          <div v-if="places.length > 0" class="mt-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Suggestions:</h3>
            <ul class="bg-white divide-y divide-gray-200 rounded-md border border-gray-300 max-h-40 overflow-auto">
              <li v-for="p in places" :key="p" class="px-4 py-2 hover:bg-gray-100 cursor-pointer" @click="setAddress(values, key, p)">
                {{ p }}
              </li>
            </ul>
          </div>
        </div>
        <!-- Account Information -->
        <div class="w-full mt-10" v-show="active == len">
          <h2 class="text-2xl font-semibold mb-6 text-gray-800">Account Information</h2>
          <div class="space-y-6">
            <div class="relative">
              <input
                type="text"
                id="username"
                class="w-full px-4 py-2 text-gray-900 placeholder-transparent border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                placeholder="Username"
                v-model="signUpForm.user_name"
                required
              />
              <label
                for="username"
                class="absolute left-2 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600"
              >Username</label>
            </div>
            <div class="relative">
              <input
                type="password"
                id="password"
                class="w-full px-4 py-2 text-gray-900 placeholder-transparent border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                placeholder="Password"
                v-model="signUpForm.password"
                required
              />
              <label
                for="password"
                class="absolute left-2 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600"
              >Password</label>
            </div>
            <div class="relative">
              <input
                type="password"
                id="confirm-password"
                class="w-full px-4 py-2 text-gray-900 placeholder-transparent border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                placeholder="Confirm Password"
                v-model="confirmPass"
                required
              />
              <label
                for="confirm-password"
                class="absolute left-2 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600"
              >Confirm Password</label>
            </div>
          </div>
          <div class="mt-8 text-sm text-gray-600">
            <p>By creating an account, you agree to our <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>.</p>
          </div>
        </div>
      </form>
      <div class="w-full border-t-2 pt-6 flex justify-between items-center px-8">
        <button
          v-show="active != 1"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-md transition duration-300 ease-in-out flex items-center"
          @click="active-=3"
        >
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
          Back
        </button>
        <div v-if="active == 1" class="flex-grow"></div>
        <button
          v-show="active != len"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-md transition duration-300 ease-in-out flex items-center"
          @click="active+=3"
        >
          Next
          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>
        <button
          v-show="active == len"
          type="button"
          class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-6 rounded-md transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
          @click="sendData()"
        >
          Submit Request
        </button>
      </div>
    </div>
</template>
  
  <script>
import axios from "axios";
import FaceScanner from "./faceScanner.vue";

export default {
  data() {
    return {
      signUpForm: {
        email: "",
        valid_id: "",
        password: "",
        first_name: "",
        last_name: "",
        middle_name: "",
        contact: "",
        user_name: "",
        gender: "",
        fb_name: "",
        profile: "",
        accepted_by: 3
      },
      current_address: {
        street: "",
        house_number: "",
        village: "",
        barangay: "",
        city: "",
        province: "",
        block: "",
        sitio: "",
      },
      other_address: {
        street: "",
        house_number: "",
        village: "",
        barangay: "",
        city: "",
        province: "",
        block: "",
        sitio: "",
      },
      confirmPass: "",
      formComplete: true,
      err: false,
      submited: false,
      active: 1,
      selectedPlace: null,
      places: [],
      activePlace: "",
      key: null,
      values: null,
      toggler: false,
      valid_id: null,
      profile: null,
      len: 3,
      face_detect: false,
      face_checked: false
    };
  },
  computed: {
    passIncorrect() {
      const confirmPass = this.confirmPass;
      const password = this.signUpForm.password;
      return confirmPass != password && password != "" && confirmPass != "";
    },
    formIncomplete() {
      for (const c of Object.values(this.signUpForm)) {
        if (c == "") {
          this.formComplete = false;
          alert();
          break;
        }
      }
      return this.formComplete;
    },
    isPhone() {
      return window.innerWidth <= 768;
    },
  },
  components: {
    FaceScanner
  },
  methods: {
    async signUpRequest() {
      const sf = { 
        user: {
          last_name: this.signUpForm.last_name,
          first_name: this.signUpForm.first_name,
          middle_name: this.signUpForm.middle_name,
          gender: this.signUpForm.gender,
          email: this.signUpForm.email,
          contact: this.signUpForm.contact,
          profile: this.signUpForm.profile,
          user_name: this.signUpForm.user_name,
          password: this.signUpForm.password,
          accepted_by: 3
        },
        id: 3,
        current_address: this.current_address,
        other_address: this.other_address,
        citizen_credentials: {
          valid_id: this.signUpForm.valid_id,
          fb_name: this.signUpForm.fb_name,
          accepted_by: 3
        }
      }

      const toBESEND = {
        url: "api/citizenusers/add/item/request",
        data: sf,
      };

      const test = await this.$store.dispatch("sendData", toBESEND);
      return test["response"];
      //await console.log(test);
    },
    changeA() {
      this.changeActive("Home");
    },
    setAddress(param, key, value) {
      param[key] = value;
      this.places = [];
      this.toggler = false;
    },
    setKeyVal(key, val) {
      this.key = key;
      this.values = val;
      this.toggler = true;
    },
    async generateAddress(search, selected) {
      const data = {
        selected: [selected],
        search: search,
      };
      this.activePlace = selected;
      const send = {
        url: "api/address/request",
        data: data,
      };

      const test = await this.$store.dispatch("sendData", send);
      if (test["response"] == "Success") {
        this.places = test.data;
        console.log(this.places);
      } else {
        alert("Error");
      }
    },
    async sendData() {
      
      if(!this.face_checked){
        alert("Please create a profile");
        return;
      }
      if (this.passIncorrect /*  || !this.formIncomplete */) {
        this.err = await true;
        console.log(this.signUpForm, this.confirmPass);
        return;
      }

      //this.$store.commit("addUser", this.signUpForm);
      //console.log(this.$store.state.userInfo);
      console.log(this.signUpForm)

      const res = await this.signUpRequest();

      if (res != "Error") {
        await this.clearForm(this.signUpForm);
        await this.clearForm(this.other_address);
        await this.clearForm(this.current_address);
        this.submited = await true;
        this.err = await false;
      } else {
        alert("Username Email or Phone, already Exists!");
      }
      //const test = await this.$store.dispatch("sendData", toBESEND);
    },
    clearForm(param) {
      for (const key of Object.keys(param)) {
        if (key != "userLevel") param[key] = "";
      }
      this.confirmPass = "";
    },
    getAddressData(addressData) {
      console.log(addressData);
      addressData.formatted_address;
    },
    initAutocomplete() {
      if (typeof google === "undefined") {
        console.error("Google Maps JavaScript API not loaded");
        return;
      }
      this.setItUp("signup_current_street", "current_address");
      this.setItUp("signup_current_house_no", "current_address");
      this.setItUp("signup_current_village", "current_address");
      this.setItUp("signup_current_barangay", "current_address");
      this.setItUp("signup_current_city", "current_address");
      this.setItUp("signup_current_province", "current_address");

      this.setItUp("signup_other_street", "other_address");
      this.setItUp("signup_other_house_no", "other_address");
      this.setItUp("signup_other_village", "other_address");
      this.setItUp("signup_other_barangay", "other_address");
      this.setItUp("signup_other_city", "other_address");
      this.setItUp("signup_other_province", "other_address");
      /* 
        const input = document.getElementById('autocomplete');
        const autocomplete = new google.maps.places.Autocomplete(input, {
          types: ['address'],
          fields: ['address_components'],
          componentRestrictions: { country: 'ph' }, // Restrict to the Philippines
        });
  
        autocomplete.addListener('place_changed', () => {
          const place = autocomplete.getPlace(); 
          if (!place.geometry) {
            console.error('No details available for input: ' + place.name);
            return;
          } 
  
          // Handle the selected place details
          autocomplete.getPlace().address_components.forEach(component => {
          const types = component.types;
          const value = component.long_name;
  
          if (types.includes('street_number')) {
            this.current_address.house_number = value;
          } else if (types.includes('route')) {
            this.current_address.street = value;
          } else if (types.includes('sublocality') || types.includes('sublocality_level_1')) {
            this.current_address.village = value;
          } else if (types.includes('locality')) {
            this.current_address.city = value;
          } else if (types.includes('administrative_area_level_2')) {
            this.current_address.barangay = value;
          } else if (types.includes('administrative_area_level_1')) {
            this.current_address.province = value;
          }
        });
        }); */
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

        this[key].house_number = "";
        this[key].street = "";
        this[key].village = "";
        this[key].city = "";
        this[key].barangay = "";
        this[key].province = "";

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
          } else if (types.includes("administrative_area_level_1")) {
            //this[key].barangay = value;
          } else if (types.includes("administrative_area_level_2")) {
            this[key].province = value;
          }
        });
      });
    },
    onFileChange(event, fileType) {
      this[fileType] = event.target.files[0];
      this.uploadFile(fileType);
    },

    async uploadFile(fileType) {
      const file = this[fileType];
      if (!file) {
        this.responseMessage = `No ${fileType} selected.`;
        return;
      }

      let formData = new FormData();
      formData.append("file", file);

      try {
        const response = await this.$store.dispatch("sendData", {
          url: "api/file/upload",
          data: formData,
        });

        this.responseMessage = response["response"];
        if (this.responseMessage == "Success") {
          this.signUpForm[fileType] = response.file_path;
        }
      } catch (error) {
        console.error(error);
        this.responseMessage = `Upload of ${fileType} failed.`;
      }

      console.log(this.signUpForm);
      alert(this.responseMessage);
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
    isPhoneM() {
      return window.innerWidth <= 768;
    },
    check_it(){
      this.face_checked = true;
    },
    toggle_checker(){
      this.face_detect = !this.face_detect;
    }
  },
  mounted() {
    (async () => {
      await this.loadAPI();
      /* await this.initAutocomplete(); */
      if (window.innerWidth <= 768) {
        this.len = 4;
      }
      console.log(this.len);
    })();
  },
  watch: {
    "current_address.province": function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.setKeyVal("province", this.current_address);
        this.generateAddress(this.current_address, "province");
      }
    },
    "current_address.city": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("city", this.current_address);
        this.generateAddress(this.current_address, "city");
      }
    },
    "current_address.barangay": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("barangay", this.current_address);
        this.generateAddress(this.current_address, "barangay");
      }
    },
    "current_address.city": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("city", this.current_address);
        this.generateAddress(this.current_address, "city");
      }
    },
    "current_address.sitio": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("sitio", this.current_address);
        this.generateAddress(this.current_address, "sitio");
      }
    },
    "current_address.village": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("village", this.current_address);
        this.generateAddress(this.current_address, "village");
      }
    },
    "current_address.street": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("street", this.current_address);
        this.generateAddress(this.current_address, "street");
      }
    },
    "current_address.house_number": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("house_number", this.current_address);
        this.generateAddress(this.current_address, "house_number");
      }
    },
    "current_address.block": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("block", this.current_address);
        this.generateAddress(this.current_address, "block");
      }
    },
    "other_address.province": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("province", this.other_address);
        this.generateAddress(this.other_address, "province");
      }
    },
    "other_address.city": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("city", this.other_address);
        this.generateAddress(this.other_address, "city");
      }
    },
    "other_address.barangay": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("barangay", this.other_address);
        this.generateAddress(this.other_address, "barangay");
      }
    },
    "other_address.city": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("city", this.other_address);
        this.generateAddress(this.other_address, "city");
      }
    },
    "other_address.sitio": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("sitio", this.other_address);
        this.generateAddress(this.other_address, "sitio");
      }
    },
    "other_address.village": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("village", this.other_address);
        this.generateAddress(this.other_address, "village");
      }
    },
    "other_address.street": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("street", this.other_address);
        this.generateAddress(this.other_address, "street");
      }
    },
    "other_address.house_number": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("house_number", this.other_address);
        this.generateAddress(this.other_address, "house_number");
      }
    },
    "other_address.block": function (newVal, oldVal) {
      if (newVal != oldVal && this.toggler) {
        this.setKeyVal("block", this.other_address);
        this.generateAddress(this.other_address, "block");
      }
    },
  },
  props: ["changeActive"],
};
</script>
  <style scoped>
.animate-popup {
  animation: popup 0.1s ease-out forwards;
}

@keyframes popup {
  0% {
    transform: scale(0.5);
    opacity: 0;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}
</style>
