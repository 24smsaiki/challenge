import { createRouter, createWebHistory } from "vue-router";

import Account from "../components/Account/Account.vue";
import Addresses from "../components/Account/Addresses.vue";
import Category from "../views/Category.vue";
import Checkout from "../views/Checkout.vue";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import Logout from "../views/Logout.vue";
import NotFound from "../views/NotFound.vue";
import Orders from "../components/Account/Orders.vue";
import Product from "../views/Product.vue";
import Register from "../views/Register.vue";
import Settings from "../components/Account/Settings.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "Home",
      component: Home,
    },
    { path: "/:pathMatch(.*)*", name: "NotFound", component: NotFound },
    {
      path: "/category/:category",
      name: "Category",
      component: Category,
      meta: { requiresAuth: true },
    },
    {
      path: "/product/:product",
      name: "Product",
      component: Product,
      meta: { requiresAuth: true },
    },
    {
      path: "/checkout",
      name: "Checkout",
      component: Checkout,
      meta: { requiresAuth: true },
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
      meta: { requiresAuth: true },
    },
    {
      path: "/order/payment/success/:id",
      name: "PaymentSuccess",
      // component: () => import("../views/PaymentSuccess.vue"),
      components: Checkout,
      meta: { requiresAuth: true },
    },
    {
      path: "/account/orders",
      name: "Orders",
      component: Orders,
      meta: { requiresAuth: true },
    },
    {
      path: "/account/addresses",
      name: "Addresses",
      component: Addresses,
      meta: { requiresAuth: true },
    },
    {
      path: "/account/settings",
      name: "Settings",
      component: Settings,
      meta: { requiresAuth: true },
    },
  ],
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("app-token");
  const app = JSON.parse(localStorage.getItem("app-user"));

  if (app?.exp < Date.now() / 1000) {
    localStorage.removeItem("app-token");
    localStorage.removeItem("app-user");
    window.location.reload();
  }

  if (to.matched.some((record) => record.meta.requiresAuth) && !token) {
    next({ name: "Login" });
  } else {
    next();
  }
});

export default router;
