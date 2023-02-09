import { createRouter, createWebHistory } from "vue-router";

import Account from "../components/Account/Account.vue";
import Category from "../views/Category.vue";
import Checkout from "../views/Checkout.vue";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import Logout from "../views/Logout.vue";
import Product from "../views/Product.vue";
import Register from "../views/Register.vue";

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
      component: () => import("../views/Category.vue"),
    },
    {
      path: "/product/:product",
      name: "Product",
      component: () => import("../views/Product.vue"),
    },
    {
      path: "/checkout",
      name: "Checkout",
      component: Checkout,
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
    {
      path: "/order/payment/success/:id",
      name: "PaymentSuccess",
      // component: () => import("../views/PaymentSuccess.vue"),
      component: () => import("../views/Checkout.vue"),
    },
    {
      path: "/join-us",
      name: "JoinUs",
      component: () => import("../views/Seller.vue"),
    },
  ],
});

export default router;
