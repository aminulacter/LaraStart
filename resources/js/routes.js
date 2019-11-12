import Dashboard from "./components/Dashboard";
import Profile from "./components/Profile";
import Users from "./components/Users";


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
        },
        {
            path: "/users",
            component: Users
        }
    ]
};
