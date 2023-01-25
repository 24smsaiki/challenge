import { createRouter, createWebHistory } from "vue-router";

import Category from "../views/Category.vue";
import Checkout from "../views/Checkout.vue";
import Home from "../views/Home.vue";
import Product from "../views/Product.vue";

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
      component: () => import("../components/security/UsersList.vue"),
    },
    {
      path: "/login",
      name: "Login",
      component: () => import("../views/Login.vue"),
    },
    {
      path: "/register",
      name: "Register",
      component: () => import("../views/Register.vue"),
    },
    {
      path: "/logout",
      name: "Logout",
      component: () => import("../views/Logout.vue"),
    },
  ],
});

export default router;
