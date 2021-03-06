import Dashboard from "./components/Dashboard";
import Profile from "./components/Profile";
import Developer from "./components/Developer";
import Users from "./components/Users";
import NotFound from "./components/NotFound";


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
            path: "/developer",
            component: Developer
        },
        {
            path: "/users",
            component: Users
        },
        {
            path: "*",
            component: NotFound
        }
    ]
};
