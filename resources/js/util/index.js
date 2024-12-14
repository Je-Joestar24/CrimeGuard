import { createStore } from "vuex";

import axios from "./axios.js";

export default createStore({
    state: {
        pages: [
            {
                id: "dashboard",
                pth: [
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z",
                    },
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z",
                    },
                ],
                nm: "Dashboard",
                titlePage: "DASHBOARD",
                api: 'api/dashboard/counts/Display',
                type: 0,
            },
            {
                id: "requests",
                pth: [
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z",
                    },
                ],
                nm: "Requests",
                type: 1,
                contId: "IncidentsCollapse",
                collapseId: "IncidentCollapseContainerId",
                collapse: [

                    {
                        itemId: "reportedIncidents",
                        itemDisplay: "Incident Reports",
                        innerTitlePage: "CITIZEN REPORTS",
                        tableIndex: 0,
                        api: 'api/incidents/table/Display',
                    },
                    {
                        itemId: "regRequests",
                        itemDisplay: "Registration request",
                        innerTitlePage: "CITIZEN REGISTRATION REQUESTS",
                        tableIndex: 0,
                        api: 'api/incidents/table/Display',
                    },
                ],
            },
            {
                id: "maps",
                pth: [
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 01-5.276 3.67m0 0a9 9 0 01-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25",
                    },
                ],
                nm: "Maps",
                type: 1,
                contId: "MapsCollapse",
                collapseId: "MapsCollapseContainerId",
                collapse: [
                    {
                        itemId: "innerMonitoring",
                        itemDisplay: "Monitor",
                        innerTitlePage: "MONITORING MAP",
                        api: '',
                    },
                    {
                        itemId: "innerHeatMap",
                        itemDisplay: "Heat Map",
                        innerTitlePage: "HEAT MAP",
                        api: '',
                    },
                ],
            },
            {
                id: "incidents",
                pth: [
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z",
                    },
                ],
                nm: "Incidents",
                type: 1,
                contId: "IncidentsCollapse",
                collapseId: "IncidentCollapseContainerId",
                collapse: [
                    {
                        itemId: "innerIncident",
                        itemDisplay: "Incident",
                        innerTitlePage: "INCIDENTS",
                        tableIndex: 0,
                        api: 'api/incidents/table/Display',
                        delete: '',
                    },
                    {
                        itemId: "innerSuspects",
                        itemDisplay: "Suspect",
                        innerTitlePage: "SUSPECTS",
                        tableIndex: 1,
                        api: 'api/suspect/table/Display',
                    },
                    {
                        itemId: "innerVictims",
                        itemDisplay: "Victim",
                        innerTitlePage: "VICTIMS",
                        tableIndex: 2,
                        api: 'api/victims/table/Display',
                    },
                    {
                        itemId: "innerWitnesses",
                        itemDisplay: "Witness",
                        innerTitlePage: "WITNESS",
                        tableIndex: 3,
                        api: 'api/witness/table/Display',
                    },
                    {
                        itemId: "innerNameIncidents",
                        itemDisplay: "Type of Incident",
                        innerTitlePage: "TYPE OF INCIDENTS",
                        tableIndex: 4,
                        api: 'api/incidentNames/table/Display',
                    },
                ],
            },
            {
                id: "analytics",
                pth: [
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z",
                    },
                ],
                nm: "Analytics",
                type: 0,
                titlePage: "ANALYTICS",
                api: '',
            },
            {
                id: "reports",
                pth: [
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z",
                    },
                ],
                nm: "Reports",
                type: 0,
                titlePage: "REPORTS",
                api: ''
            },
            {
                id: "accounts",
                pth: [
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z",
                    },
                ],
                nm: "accounts",
                type: 1,
                contId: "accountCollapse",
                collapseId: "accountCollapseContainerId",
                collapse: [
                    {
                        itemId: "innerCitizenAccounts",
                        itemDisplay: "Citizen Accounts",
                        innerTitlePage: "CITIZEN ACCOUNTS",
                        tableIndex: 6,
                        api: 'api/citizenUsers/table/Display'
                    },
                    {
                        itemId: "innerOfficerAccounts",
                        itemDisplay: "Officer Accounts",
                        innerTitlePage: "OFFICER ACCOUNTS",
                        tableIndex: 7,
                        api: 'api/officerUsers/table/Display'
                    },
                ],
            },
            {
                id: "officeMonitoring",
                pth: [
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Zm-7.518-.267A8.25 8.25 0 1 1 20.25 10.5M8.288 14.212A5.25 5.25 0 1 1 17.25 10.5",
                    },
                ],
                nm: "Monitoring",
                type: 1,
                contId: "logsCollapse",
                collapseId: "logsCollapseContainerId",
                collapse: [
                    {
                        itemId: "innerLogs",
                        itemDisplay: "Logs",
                        innerTitlePage: "OFFICER LOGS",
                        api: 'api/logs/list/Display'
                    },
                    {
                        itemId: "innerActivies",
                        itemDisplay: "Activies",
                        innerTitlePage: "OFFICER ACTIVITIES",
                        api: 'api/activity/list/Display'
                    },
                ],
            },
            {
                id: "archivedData",
                pth: [
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z",
                    },
                ],
                nm: "Archive",
                type: 1,
                contId: "IncidentsCollapse",
                collapseId: "IncidentCollapseContainerId",
                collapse: [
                    {
                        itemId: "innerIncidentArchive",
                        itemDisplay: "Incident",
                        innerTitlePage: "INCIDENTS ARCHIVE",
                        tableIndex: 0,
                        api: 'api/incidents/archive/table/Display',
                    },
                    {
                        itemId: "innerSuspectsArchive",
                        itemDisplay: "Suspect",
                        innerTitlePage: "SUSPECTS ARCHIVE",
                        tableIndex: 1,
                        api: 'api/suspect/archive/table/Display',
                    },
                    {
                        itemId: "innerVictimsArchive",
                        itemDisplay: "Victim",
                        innerTitlePage: "VICTIMS ARCHIVE",
                        tableIndex: 2,
                        api: 'api/victims/archive/table/Display',
                    },
                    {
                        itemId: "innerWitnessesArchive",
                        itemDisplay: "Witness",
                        innerTitlePage: "WITNESS ARCHIVE",
                        tableIndex: 3,
                        api: 'api/witness/archive/table/Display',
                    },
                    {
                        itemId: "innerAccountsArchive",
                        itemDisplay: "Accounts",
                        innerTitlePage: "ACCOUNTS ARCHIVE",
                        tableIndex: 3,
                        api: 'api/citizenUsers/archive/table/Display',
                    }
                ],
            },
            {
                id: "notifications",
                pth: [
                    {
                        "stroke-linecap": "round",
                        "stroke-linejoin": "round",
                        d: "M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5",
                    },
                ],
                nm: "Notifications",
                type: 0,
                titlePage: "NOTIFICATIONS",
                api: 'api/notifications/list/Display'
            },
        ],
        darkMode: false,
        currentPage: 0,
        verificationRes: false,
        dark: true,
        HomePageComponents: {
            modals: {
                form: 0
            }
        },
        LoadingProcess: {
            data: {
                formData: {},
                pageRequest: -1
            }
        },
        CurrentActiveSideBar: "dashboard",
        CurrentActiveTitleNavigation: "DASHBOARD",
        DisplayModuleId: "dashboard",
        CurrentTableIndexPos: 0,
        userInfo: [
            {
                id: 0,
                email: 'jpar1252003@gmail.com',
                password: 'Jejomar09',
                'first-name': 'Jejomar',
                'last-name': 'Parrilla',
                'contact-number': '09073010472',
                'user-name': 'Jejomar09',
                'user-level': 1
            },
            {
                id: -1,
                email: 'jpar1252003@gmail.com',
                password: 'Jejomar',
                'first-name': 'Jejomar',
                'last-name': 'Parrilla',
                'contact-number': '09073010472',
                'user-name': 'Jejomar',
                'user-level': 2
            },
            {
                id: 100,
                email: 'sammer.sanchez@wlcormoc.edu.ph',
                password: 'Sammer',
                'first-name': 'Sammer',
                'last-name': 'Sanchez',
                'contact-number': '09090909',
                'user-name': 'Sammer',
                'user-level': 1
            },
            {
                id: 101,
                email: 'sammer.sanchez@wlcormoc.edu.ph',
                password: 'Sammer1',
                'first-name': 'Sammer1',
                'last-name': 'Sanchez1',
                'contact-number': '09090909',
                'user-name': 'Sammer1',
                'user-level': 3
            }
        ],
        userId: 1,
        userLevel: -1,
        api: '',
        delete_api: '',
        api__KEY: "AIzaSyCi6_67DxspQmKQhErlif7UYTmXOvcdO6k"
    },
    mutations: {
        // Define your mutations to modify state variables
        changeActivePage(state, elems) {
            state.CurrentActiveSideBar = elems[0];
            state.CurrentActiveTitleNavigation = elems[1];
            state.DisplayModuleId = elems[2];
        },
        changeCurrentPage(state, NewPage) {
            state.currentPage = NewPage;
        },
        changeHomeCurrentModalForm(state, area) {
            state.HomePageComponents.modals.form = area % 4;
        },
        requestSendData(state, data) {
            state.LoadingProcess.data.formData = data;
        },
        addUser(state, data) {
            const userFormat = {
                id: 0,
                email: '',
                password: '',
                'first-name': '',
                'last-name': '',
                'contact-number': '',
                'user-name': '',
                'user-level': 3
            }
            const info = [];
            info.push(state.userId);

            for (const microData of Object.values(data)) info.push(microData);

            let index = 0;

            for (const keys of Object.keys(userFormat)) {
                userFormat[keys] = info[index];
                index++;
            }

            state.userInfo.push(userFormat);
            state.userId++;
        },
        verifyUser(state) {
            state.verificationRes = true;
        },
        changeVerificationRes(state, change) {
            state.verificationRes = change;
        }, changeTheme(state) {
            state.darkMode = !state.darkMode;
        }, changeUserLevel(state, change) {
            state.userLevel = change;
        }, changeApi(state, param) {
            state.api = param;
        }
    },
    actions: {
        // Define your actions to perform asynchronous operations
        changeVerify({ commit }, change) {
            commit('changeVerificationRes', change);
            commit('changeUserLevel', -1);
        },
        changeTheme({ commit, getters }) {
            commit('changeTheme');
            if (getters.theme) document.body.classList.add("bg-gray-800")
            else document.body.classList.remove("bg-gray-800");
        },
        verifyUser({ commit, getters }, login) {

            const userInfo = getters.userInfo;

            for (const info of userInfo) {
                if ((info['user-name'] == login.user || login.user == info.email) && info.password == login.pass) {
                    commit('verifyUser')
                    commit('changeUserLevel', info["user-level"])
                    localStorage.setItem('level', info["user-level"]);
                    return;
                }
            }

        },
        militaryToNormalTime({ commit }, param) {
            var timeComponents = param.split(":");
            var hours = parseInt(timeComponents[0]);
            var minutes = parseInt(timeComponents[1]);

            var period = hours < 12 ? "AM" : "PM";

            hours = hours > 12 ? hours - 12 : hours;
            hours = hours == 0 ? 12 : hours;

            var normalTime =
                hours + ":" + (minutes < 10 ? "0" : "") + minutes + " " + period;
            return normalTime;
        },
        changeActivePage({ commit }, elems) {
            commit('changeActivePage', elems);
        },
        changeAPI({ commit }, param) {
            commit('changeApi', param);
        },
        /* to set the data of the table state */
        async generateTableData({ commit }, param) {
            try {
                const t = await axios.get(param);
                const test = await t.data;
                return test;
            } catch (err) {
                return 'err';

            }

        },
        async sendData({ commit }, param) {

            try {
                const response = await axios.post(param.url, param.data);
                const data = await response.data;
                return data;
            } catch (error) {
                console.error("Error:", error);
                return 'err';
            }
        }, async logout() {
            try {
                await axios.post('api/logout');

                localStorage.removeItem('token');
                localStorage.removeItem('credentials');

                return true;
            } catch (error) {
                console.error('Error during logout:', error.response);
                return false;
            }
        }, async checkToken({ commit }) {
            try {
                await axios.get('api/check-token');

                return true;
            } catch (error) {

                return false;
            }
        }, async checkUserAccess({ commit }, param = 'api/check-level-1') {
            try {
                const response = await axios.get(param);
                return true; // Returns the user's level directly from token data
            } catch (error) {
                return false;
            }
        },
    },
    getters: {
        // Define your getters to compute derived state based on store state
        userInfo(state) {
            return state.userInfo;
        },
        verificationResult(state) {
            return state.verificationRes;
        },
        CurrentActiveSideBar(state) {
            return state.CurrentActiveSideBar;
        },
        theme(state) {
            return state.darkMode;
        },
        currentPage(state) {
            return state.currentPage;
        }, getActive(state) {
            return state.CurrentActiveSideBar;
        }, pages(state) {
            return state.pages;
        }, currentActiveTitle(state) {
            return state.CurrentActiveTitleNavigation;
        }, level(state) {
            return state.userLevel;
        }, api(state) {
            return state.api;
        }
    }
})