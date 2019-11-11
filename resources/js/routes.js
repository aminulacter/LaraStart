import Dashboard from "./components/Dashboard";
import Profile from "./components/Profile";


export default {
     mode: "history",

     linkActiveClass: "active",

    routes: [
        {
            path: "/dashboard",
            component: Dashboard
        },
        {
            path: "/profile",
            component: Profile
        }
    ]
};
