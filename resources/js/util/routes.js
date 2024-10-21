import { createRouter, createWebHashHistory } from "vue-router";
import Home from "@/components/Home.vue";
import Admin from "@/components/Admin.vue";
import DashBoard from "@/components/contents/DashBoard.vue";
import Incidents from "@/components/contents/Incidents.vue";
import allAccounts from "@/components/contents/allAccounts.vue";
import Maps from "@/components/contents/Maps.vue";
import Monitoring from "@/components/contents/Monitoring.vue";
import Notif from "@/components/contents/Notif.vue";
import Reports from "@/components/contents/Reports.vue";
import Requests from "@/components/contents/Requests.vue"
import archive from "@/components/contents/archive.vue";
import Analytics from "@/components/contents/Analytics.vue";
import ForgetPass from "@/components/homeComponents/Contents/forgotPass.vue";
import Officer from "@/components/Officer.vue";

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        { path: '/:index?', component: Home},
        { path: '/Admin', component: Admin, children:[
            {
                path: 'Dashboard',
                component: DashBoard
            },
            {
                path: 'Requests',
                component: Requests
            },
            {
                path: 'Incidents',
                component: Incidents
            },
            {
                path: 'Accounts',
                component: allAccounts
            },
            {
                path: 'Maps',
                component: Maps
            },
            {
                path: 'Archive',
                component: archive
            },
            {
                path: 'Monitoring',
                component: Monitoring
            },
            {
                path: 'Notifications',
                component: Notif
            },
            {
                path: 'Reports',
                component: Reports
            },
            {
                path: 'Analytics',
                component: Analytics
            }
        ] },
        { path: '/Officer', component: Officer, children:[
            {
                path: 'Dashboard',
                component: DashBoard
            },
            {
                path: 'Requests',
                component: Requests
            },
            {
                path: 'Incidents',
                component: Incidents
            },
            {
                path: 'Maps',
                component: Maps
            },
            {
                path: 'Notifications',
                component: Notif
            },
            {
                path: 'Reports',
                component: Reports
            },
            {
                path: 'Analytics',
                component: Analytics
            }
        ] },
        { path: '/forgotPass', component: ForgetPass},
    ]
})

export default router;