import { createRouter, createWebHistory } from "vue-router";

import CategoryPage from "../views/CategoryPage.vue";
import Checkout from "../views/Checkout.vue";
import Home from "../views/Home.vue";
import ProductPage from "../views/ProductPage.vue";

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
      name: "CategoryPage",
      component: CategoryPage,
    },
    {
      path: "/product/:product",
      name: "ProductPage",
      component: ProductPage,
    },
    {
      path: "/checkout",
      name: "CheckoutPage",
      component: Checkout,
    },
    {
      path: "/users",
      name: "UsersPage",
      component: () => import("../components/security/UsersList.vue"),
    },
    {
      path: "/login",
      name: "LoginPage",
      component: () => import("../views/LoginPage.vue"),
    },
    {
      path: "/register",
      name: "RegisterPage",
      component: () => import("../views/RegisterPage.vue"),
    },
  ],
});

export default router;
