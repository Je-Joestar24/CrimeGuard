<template>
  <div
    tabindex="-1"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-20"
  >
    <div class="relative w-full max-w-6xl">
      <div class="relative bg-white rounded-lg border shadow-2xl">
        <div class="flex justify-end p-3 border-b">
          <span class=" w-full px-2 py-2 text-xl font-bold">EDIT INCIDENT</span>
          <button
            type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
            @click="toggle(-1)"
          >
            <!--  @click.prevent="toggle()" -->
            <svg
              class="w-3 h-3"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 14 14"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
              />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <form class="p-4 md:p-5" >
          <!-- Form fields -->
          <div class="grid md:grid-cols-3 md:gap-6">
            <div class="relative z-0 w-full mb-5 group">
              <input
                type="text"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="data.incident.IRF_Entry_no"
              />
              <label
                class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >IRF ENTRY NUMBER:</label
              >
            </div>
            <div class="relative z-0 w-full mb-5 group">
              
              <input
                type="text"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                required
                v-model="data.incident_types.incident_name"
                @click="disableWatcher = false; search('incidentT', data.incident_types.incident_name);"
                @focusout="clearIt()"
              />
              <label
                for="floating_company"
                class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >TYPE OF INCIDENT:</label
              >
            </div><!-- 
            <div class="relative z-0 w-full mb-5 group">
              <input
                type="text"
                v-model="data.incident.copy_for"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                required
              />
              <label
                for="floating_company"
                class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >COPY FOR:</label
              >
            </div> -->
            <div class="relative z-0 w-full mb-5 group">
              <select
            v-model="data.incident.status"
            class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
          >
            <option value="">SELECT STATUS</option>
            <option value="respond">RESPONDED</option>
            <option value="reject">REJECTED</option>
            <option value="pending">PENDING</option>
            <option value="under investigation">UNDER INVESTIGATION</option>
            <option value="clear">CLEARED</option>
            <option value="solve">SOLVED</option>
          </select>
              <label
                for="floating_company"
                class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >STATUS:</label
              >
            </div>
          </div>
          <div class="grid md:grid-cols-2 md:gap-6">
            <div class="grid md:grid-cols-2 md:gap-6 group">
              <div class="relative z-0 w-full group">
                <div class="relative z-0 w-full group">
                  <input
                    type="date"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=""
                    v-model="data.incident.date_reported"
                    required
                  />
                </div>
                <label
                  for="floating_phone"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >Date Reported:</label
                >
              </div>
              <div class="relative z-0 w-full group">
                <input
                  type="time"
                  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                  v-model="data.incident.time_reported"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  required
                />
                <label
                  for="floating_phone"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >Time Reported:</label
                >
              </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 group">
              <div class="relative z-0 w-full mb-5 group">
                <input
                  type="date"
                  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                    v-model="data.incident.date_of_incident"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  required
                />
                <label
                  for="floating_phone"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >Date of Incident:</label
                >
              </div>
              <div class="relative z-0 w-full mb-5 group">
                <input
                  type="time"
                  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                  v-model="data.incident.time_of_incident"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  required
                />
                <label
                  for="floating_phone"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >Time of Incident:</label
                >
              </div>
            </div>
          </div>
          <div class="grid md:grid-cols-3 md:gap-6">
            <div class="flex  flex-row px-0 w-full">
              <div class="relative z-0 w-full mb-5 group">
                <input
                  type="text"
                  v-model="data.incident.barangay"
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=""
                  @click="generateAddress(data.incident.barangay)"
                  @focusout="clearIt2"
                  required
                />
                <label
                  for="floating_company"
                  class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >Barangay:</label
                >
                <div
                  v-if="places.length > 0"
                  class="absolute bg-white w-full rounded-md pt-1 border"
                >
                  <div class="max-h-24 overflow-auto flex flex-col rounded-md">
                    <div
                      class="px-4 hover:bg-gray-50 py-1 border-b"
                      v-for="place in places"
                      @click.prevent="setAddress(place )"
                    >
                      {{ place }}
                    </div>
                  </div>
                </div>
              </div>
              <svg  class="h-10 border-b-2 border-gray-300 mt-0.5 w-10 p-2 text-gray-900"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
              </svg>
              
            </div>
            <div class="flex col-span-2 flex-row px-0 w-full">
              <div class="relative z-0 w-full mb-5 group">
                <input
                  type="text"
                  v-model="data.incident.location"
                  
                  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none -dark:text-white -dark:border-gray-600 -dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=""
                  required
                />
              <label
                for="floating_company"
                class="peer-focus:font-medium absolute text-sm text-gray-500 -dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:-dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                >Place of Incident:</label
              >
              </div>
              <svg @click="toggleLocation" class="h-10 border-b-2 border-gray-300 mt-0.5 w-10 p-2 text-gray-900"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </div>
          </div>
          <p
            class="text-lg font-semibold text-gray-900 truncate -dark:text-white"
          >
            Involve Personalities
          </p>
          <div class="grid md:grid-cols-3 md:gap-6">
            <ul
              class="max-w-md divide-y divide-gray-200 -dark:divide-gray-700 -dark:bg-gray-600 rounded-md px-2 my-2 overflow-auto h-40 shadow border"
            >
            <!-- Witness -->
              <p
                class="text-md font-semibold text-gray-900 truncate -dark:text-white py-1 mt-2"
              >               
              <span v-if="!addWitnessClicked">Witness</span>

              <form v-if="addWitnessClicked" class="max-w-md mx-auto">   
                  <div class="relative">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-2 ">        
                          <button
                          type="button"
                          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-6 h-6 inline-flex justify-center items-center"
                          @click="addWitnessClicked = !addWitnessClicked"
                          >
                          <!--  @click.prevent="toggle()" -->
                              <svg
                                  class="w-3 h-3"
                                  aria-hidden="true"
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="none"
                                  viewBox="0 0 14 14"
                              >
                                  <path
                                  stroke="currentColor"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                  />
                              </svg>
                          <span class="sr-only">Close modal</span>
                          </button>
                      </div>
                      <input v-model="witness.search" type="search" class="block w-full p-3 ps-10 text-xs text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 " placeholder="Search Witness..." required />
                      <!-- dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 -->
                      <button type="button" @click.prevent="toggleEnvolved('Witness')" class="text-white absolute end-2.5 bottom-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-xs rounded-lg text-xs px-2 py-1 "><!-- dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 -->+ new</button>
                  </div>
              </form>
              <!-- search witness -->
              <div v-if="witness.list.length > 0 && witness.search != ''" class=" bg-black max-h-20 fixed overflow-auto bg-transparent flex-col" style="width: 336px;">
                <div  v-for="(person, i) in witness.list" class="bg-white w-full border-b flex cursor-pointer  active:bg-gray-500 hover:bg-gray-200" @click="addSearched('witness', {'witness':person})">
                  <span class=" w-full text-gray-800 font-semibold">{{ person.firstname }} {{ person.lastname }}</span>
                  <span class=" w-full text-end">{{ person.mobile_phone }}
                  </span>
                </div>
              </div>
              
              <button
              v-if="!addWitnessClicked"
              @click="addWitnessClicked = !addWitnessClicked"
                type="button"
                class="float-end text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-0.5 me-2 mb-1 -dark:bg-blue-600 -dark:hover:bg-blue-700 focus:outline-none -dark:focus:ring-blue-800"
              >
                + Add
              </button>
              </p>
              <li class="w-full mt-2 h-20 flex-col overflow-auto">
                <div v-for="(wtnss, i) in data.witness" class=" w-full border-b flex">
                  <span class=" w-full text-gray-800 font-semibold">{{ wtnss.witness.firstname }} {{ wtnss.witness.lastname }}</span>
                  <span class=" w-full text-end">{{ wtnss.witness.mobile_phone }}
                    <button class="bg-red-500 rounded-md  font-semibold text-xs text-white ms-2 px-2" @click="removeItem('witness',i)"> 
                      REMOVE  
                    </button>
                  </span>
                </div>
              </li>
            </ul>
            <ul
              class="max-w-md divide-y divide-gray-200 -dark:divide-gray-700 -dark:bg-gray-600 rounded-md px-2 my-2 h-40 shadow border"
            >
            <!-- SUspects -->
              <p
                class="text-md font-semibold text-gray-900 truncate -dark:text-white py-1 mt-2"
              >
                <span v-if="!addSuspectClicked">Suspects</span>
                <form v-if="addSuspectClicked" class="max-w-md mx-auto">   
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-2 ">        
                            <button
                            type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-6 h-6 inline-flex justify-center items-center"
                            @click="addSuspectClicked = !addSuspectClicked"
                            >
                            <!--  @click.prevent="toggle()" -->
                                <svg
                                    class="w-3 h-3"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 14 14"
                                >
                                    <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                    />
                                </svg>
                            <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <input type="search" v-model="suspects.search" class="block w-full p-3 ps-10 text-xs text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 " placeholder="Search Suspects..." required />
                        <!-- dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 -->
                        <button type="button" @click.prevent="toggleEnvolved('Suspects')" class="text-white absolute end-2.5 bottom-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-xs rounded-lg text-xs px-2 py-1 "><!-- dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 -->+ new</button>
                    
                  </div>
                    
                </form>
                <!-- Search Suspects -->
                <div v-if="suspects.list.length > 0 && suspects.search != ''" class=" bg-black max-h-20 fixed overflow-auto bg-transparent flex-col" style="width: 336px;">
                  
                  <div  v-for="(spct, i) in suspects.list" class="bg-white w-full border-b flex cursor-pointer  active:bg-gray-500 hover:bg-gray-200" @click="addSearched('suspects', {'suspect':spct})">
                    <span class=" w-full text-gray-800 font-semibold">{{ spct.firstname }} {{ spct.lastname }}</span>
                    <span class=" w-full text-end">{{ spct.mobile_phone }}
                    </span>
                  </div>
                </div>
                
                <button
                v-if="!addSuspectClicked"
                @click="addSuspectClicked = !addSuspectClicked"
                  type="button"
                  class="float-end text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-0.5 me-2 mb-1 -dark:bg-blue-600 -dark:hover:bg-blue-700 focus:outline-none -dark:focus:ring-blue-800"
                >
                  + Add
                </button>
              </p>
              <li class="w-full mt-2 h-20 flex-col overflow-auto">
                <div v-for="(spct, i) in data.suspects" class=" w-full border-b flex">
                  <span class=" w-full text-gray-800 font-semibold">{{ spct.suspect.firstname }} {{ spct.suspect.lastname }}</span>
                  <span class=" w-full text-end">{{ spct.suspect.mobile_phone }}
                    <button class="bg-red-500 rounded-md  font-semibold text-xs text-white ms-2 px-2" @click="removeItem('suspects',i)"> 
                      REMOVE  
                    </button>
                  </span>
                </div>
              </li>
            </ul>
            <ul
              class="max-w-md divide-y divide-gray-200 -dark:divide-gray-700 -dark:bg-gray-600 rounded-md px-2 my-2  h-40 shadow border"
            >
            <!-- Victims -->
              <p
                class="text-md font-semibold text-gray-900 truncate -dark:text-white py-1 mt-2"
              >               
              <span v-if="!addVictimClicked">Victims</span>
              
              <form v-if="addVictimClicked" class="max-w-md mx-auto">   
                  <div class="relative">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-2 ">        
                          <button
                          type="button"
                          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-6 h-6 inline-flex justify-center items-center"
                          @click="addVictimClicked = !addVictimClicked"
                          >
                          <!--  @click.prevent="toggle()" -->
                              <svg
                                  class="w-3 h-3"
                                  aria-hidden="true"
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="none"
                                  viewBox="0 0 14 14"
                              >
                                  <path
                                  stroke="currentColor"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                  />
                              </svg>
                          <span class="sr-only">Close modal</span>
                          </button>
                      </div>
                      <input v-model="victims.search" type="search" class="block w-full p-3 ps-10 text-xs text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 " placeholder="Search Victims..." required />
                      <!-- dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 -->
                      <button type="button" @click.prevent="toggleEnvolved('Victims')" class="text-white absolute end-2.5 bottom-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-xs rounded-lg text-xs px-2 py-1 "><!-- dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 -->+ new</button>
                  </div>
              </form>
              <!-- search victims -->
              <div v-if="victims.list.length > 0 && victims.search != ''" class=" bg-black max-h-20 fixed overflow-auto bg-transparent flex-col" style="width: 336px;">
                  
                <div  v-for="(person, i) in victims.list" class="bg-white w-full border-b flex cursor-pointer  active:bg-gray-500 hover:bg-gray-200" @click="addSearched('victims', {'victim':person})">
                  <span class=" w-full text-gray-800 font-semibold">{{ person.firstname }} {{ person.lastname }}</span>
                  <span class=" w-full text-end">{{ person.mobile_phone }}
                  </span>
                </div>
              </div>
              
              <button
              v-if="!addVictimClicked"
              @click="addVictimClicked = !addVictimClicked"
                type="button"
                class="float-end text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-0.5 me-2 mb-1 -dark:bg-blue-600 -dark:hover:bg-blue-700 focus:outline-none -dark:focus:ring-blue-800"
              >
                + Add
              </button>
              </p>
              <li class="w-full mt-2 h-20 flex-col overflow-auto">
                <div v-for="(victim, i) in data.victims" class=" w-full border-b flex">
                  <span class=" w-full text-gray-800 font-semibold">{{ victim.victim.firstname }} {{ victim.victim.lastname }}</span>
                  <span class=" w-full text-end">{{ victim.victim.mobile_phone }}
                    <button class="bg-red-500 rounded-md  font-semibold text-xs text-white ms-2 px-2" @click="removeItem('victims',i)"> 
                      REMOVE  
                    </button>
                  </span>
                </div>
              </li>
            </ul>
          </div>
          <label
            for="message"
            class="block mb-2 text-sm font-medium text-gray-900 -dark:text-white"
            >Narative of the Incident</label
          >
          <textarea
            id="message"
            rows="4"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 -dark:bg-gray-700 -dark:border-gray-600 -dark:placeholder-gray-400 -dark:text-white -dark:focus:ring-blue-500 -dark:focus:border-blue-500"
            placeholder="Write the Narative here..."
            v-model="data.incident_narrative.details"
          ></textarea>
        </form>
        <div class="flex justify-start p-5 py-2 pt-0">
          <button
            type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            @click="sendData"
          ><!--  -->
            DONE
          </button>
        </div>
      </div>
    </div>
    <!-- search incident -->
    
    <div v-if=" incidentT.list.length > 0" class=" max-h-32 overflow-auto fixed top-72 w-96 bg-white divide-y divide-gray-100 rounded-lg border shadow ">
      <ul class="py-2 text-sm text-gray-700 border-b" >
        <li  v-for="inc in incidentT.list" >
          <span @click.prevent="selectIncident(inc.incident_name, inc.id)" class="block px-4 py-1 hover:bg-gray-100  border-b">{{ inc.incident_name }} <span class="text-xs text-gray-600">{{ inc.sub_type != null ? `(${inc.sub_type})` : ''}}</span></span>
        </li>
      </ul>
  </div>
    <div v-show="envolvedOpen" class="w-full flex bg-black fixed bg-opacity-20" style="height: 100vh">
      <div class="w-1/2 bg-transparent"></div>
      <div class="bg-white w-full flex-col rounded-s-lg">
        <div class="flex justify-end p-3 border-b">
          <span class="w-full text-start px-3 text-2xl font-bold text-gray-800"
            >{{ formId }}</span
          >
          <button
            type="button"
            @click.prevent="toggleEnvolved('')"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
          >
            <!--  @click.prevent="toggle()" -->
            <svg
              class="w-3 h-3"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 14 14"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
              />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <div class="h-full">
          <envolvePersons :toggle="toggleEnvolved" :sendPerson="addData" :envolvePerson="formId"></envolvePersons>
        </div>
      </div>
    </div>
  </div>

  
  <selector v-if="locSelectorOpen" :toggleIt="toggleLocation" :sendIt="setLocation"></selector>
    
  
</template>


<script>
import envolvePersons from "./incidentAddForm/envolvePersons.vue";

import selector from "./modComps/selector.vue";
export default {
  data() {
    return {
      envolvedOpen: false,
      addSuspectClicked: false,
      addWitnessClicked: false,
      addVictimClicked: false,
      disableWatcher: false,
      locSelectorOpen: false,
      formId: "",
      data: {
        incident: {
          IRF_Entry_no: "",
          copy_for: "",
          date_reported: "",
          time_reported: "",
          date_of_incident: "",
          time_of_incident: "",
          location: "",
          incident_type: 1,
          status: "",
          barangay: ""
        },
        suspects: [],
        witness: [],
        victims: [],
        incident_types: {
          incident_name: "",
        },
        incident_narrative: {
          details: "",
        },
      },
      suspects: {
        search: "",
        list: [],
      },
      victims: {
        search: "",
        list: [],
      },
      witness: {
        search: "",
        list: [],
      },
      incidentT: {
        search: "",
        list: [],
      },
      searchUrl: {
        witness: "api/witness/search/Display",
        suspects: "api/suspect/search/Display",
        victims: "api/victims/search/Display",
        incidentT: "api/incidentNames/search/Display",
      },
      id: -1,
      places: []
    };
  },
  created() {
    this.extractData();
    this.disableWatcher = true;

    const credential = JSON.parse(localStorage.getItem("credentials"));
    this.id = credential.id;
  },
  components: {
    envolvePersons,
    selector,
  },
  methods: {
    toggleEnvolved(param) {
      this.envolvedOpen = !this.envolvedOpen;
      this.formId = param;
    },
    toggleLocation() {
      this.locSelectorOpen = !this.locSelectorOpen;
    },
    setLocation(param) {
      this.data.incident.location = param["address"];
      this.data.incident["latitude"] = param["latitude"];
      this.data.incident["longitude"] = param["longitude"];

      this.data.incident["barangay"] = param["barangay"];
      console.log(this.data.incident);
      //console.log(this.data.incident)
      this.toggleLocation();
    },
    async extractData() {
      const send = {
        url: "api/incidents/edit/item/request",
        data: { id: parseInt(this.rId) },
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this.data.incident = data["data"]["incident"];
        this.data.incident['barangay'] = data["data"]["incident"]['barangay'] ? data["data"]["incident"]['barangay'] : "";
        this.data.incident["id"] = parseInt(this.rId);
        this.data.incident["status"] = this.data.incident["status"].toLowerCase();

        this.data.incident_types = data["data"]["incident_types"];
        this.data.suspects = this.wrapByKey("suspect", data.data.suspects);
        this.data.victims = this.wrapByKey("victim", data.data.victims);
        this.data.witness = this.wrapByKey("witness", data.data.witness);
        this.data.incident_narrative = data.data.incident_narrative;
      } else {
        await alert("An error occured, please try again.");
      }
    },
    async clearIt() {
      await this.sleep(500);
      this.incidentT.list = [];
    },
    sleep(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    },
    addData(param) {
      this.data[param.key].push(param.data);
    },
    removeItem(keys, param) {
      this.data[keys].splice(param, 1);
    },
    async sendData() {
      const data1 = this.data;
      data1.incident["edited_by"] = this.id;
      data1["id"] = this.id;

      const send = await {
        data: data1,
        url: "api/incidents/update/item/request",
      };

      console.log(this.data);
      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        await alert("Successfully updated Incident.");
        this.reloadTab("", this.$store.getters.api);
        await this.toggle();
      } else {
        await alert("An error occured, please try again.");
      }
    },
    wrapByKey(key, arr) {
      let temp = [];
      if (key == "suspect") for (const c of arr) temp.push({ suspect: c });
      if (key == "witness") for (const c of arr) temp.push({ witness: c });
      if (key == "victim") for (const c of arr) temp.push({ victim: c });
      return temp;
    },
    /* search functions */
    async search(key, param) {
      const send = await {
        data: { search: param },
        url: this.searchUrl[key],
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this[key].list = data.data;
      } else {
        await alert("An error occured, please try again.");
      }
    },
    addSearched(key, item) {
      this.addData({ key: key, data: item });
      this[key].list = [];
    },
    clearForm() {
      this.data = {
        incident: {
          IRF_Entry_no: "",
          copy_for: "",
          date_reported: "",
          time_reported: "",
          date_of_incident: "",
          time_of_incident: "",
          location: "",
          added_by: this.id,
          edited_by: this.id,
          incident_type: 1,
          barangay: ""
        },
        suspects: [],
        witness: [],
        victims: [],
        incident_types: {
          incident_name: "",
        },
        incident_narrative: {
          details: "",
        },
      };
      this.reloadTab("", "api/incidents/table/Display");
    },
    async search(key, param) {
      const send = await {
        data: { search: param },
        url: this.searchUrl[key],
      };

      const data = await this.$store.dispatch("sendData", send);
      this.res = await data["response"];

      if (this.res == "Success") {
        this[key].list = data.data;
      } else {
        await alert("An error occured, please try again.");
      }
    },
    selectIncident(item, tId) {
      this.data.incident_types.incident_name = item;
      this.incidentT.list = [];
      this.data.incident.incident_type = tId;
      this.disableWatcher = true;
    },
    setAddress(value) {
      this.data.incident.barangay = value;
      this.places = [];
    },
    async generateAddress(search) {
      const data = {
        search: search,
      };

      const send = {
        url: "api/barangay/request",
        data: data,
      };

      const test = await this.$store.dispatch("sendData", send);
      if (test["response"] == "Success") {
        this.places = test.data;
      } else {
        alert("Error");
      }
    },

    async clearIt2() {
      await this.sleep(500);
      this.places = [];
    },
  },
  props: ["toggle", "reloadTab", "rId"],
  watch: {
    "suspects.search": function (newVal, oldVal) {
      if (newVal) {
        this.search("suspects", newVal);
      }
    },
    "victims.search": function (newVal, oldVal) {
      if (newVal) {
        this.search("victims", newVal);
      }
    },
    "witness.search": function (newVal, oldVal) {
      if (newVal) {
        this.search("witness", newVal);
      }
    },
    "data.incident_types.incident_name": function (newVal, oldVal) {
      if (newVal != oldVal && !this.disableWatcher) {
        this.search("incidentT", newVal);
      }
    },
    "data.incident.barangay": function (newVal, oldVal) {
      if (newVal != oldVal) {
        this.generateAddress(newVal);
      }
    },
  },
};
</script>