import { createRouter, createWebHistory } from "vue-router";

import Account from "../components/Account/Account.vue";
import Category from "../views/Category.vue";
import Checkout from "../views/Checkout.vue";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import Logout from "../views/Logout.vue";
import Product from "../views/Product.vue";
import Register from "../views/Register.vue";
import UsersList from "../components/Security/UsersList.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "Home",
      component: Home,
    },
    {
      path: "/category/:category",
      name: "Category",
      component: Category,
    },
    {
      path: "/product/:product",
      name: "Product",
      component: Product,
    },
    {
      path: "/checkout",
      name: "Checkout",
      component: Checkout,
    },
    {
      path: "/users",
      name: "UsersList",
      component: UsersList,
    },
    {
      path: "/login",
      name: "Login",
      component: Login,
    },
    {
      path: "/register",
      name: "Register",
      component: Register,
    },
    {
      path: "/logout",
      name: "Logout",
      component: Logout,
    },
    {
      path: "/account",
      name: "Account",
      component: Account,
    },
  ],
});

export default router;
