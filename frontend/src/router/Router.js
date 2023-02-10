import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "Home",
      component: import("../views/Home.vue"),
    },
    {
      path: "/:pathMatch(.*)*",
      name: "NotFound",
      component: import("../views/NotFound.vue"),
    },
    {
      path: "/category/:category",
      name: "Category",
      component: import("../views/Category.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/product/:product",
      name: "Product",
      component: import("../views/Product.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/checkout",
      name: "Checkout",
      component: import("../views/Checkout.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/login",
      name: "Login",
      component: import("../views/Login.vue"),
    },
    {
      path: "/register",
      name: "Register",
      component: import("../views/Register.vue"),
    },
    {
      path: "/logout",
      name: "Logout",
      component: import("../views/Logout.vue"),
    },
    // {
    //   path: "/account",
    //   name: "Account",
    //   component: JSON.parse(localStorage.getItem("app-user"))?.roles.includes(
    //     "ROLE_SELLER"
    //   )
    //     ? import("../components/Account/seller/Account.vue")
    //     : import("../components/Account/client/Account.vue"),
    //   meta: { requiresAuth: true },
    // },
    {
      path: "/order/payment/success/:id",
      name: "PaymentSuccess",
      component: () => import("../views/Checkout.vue"),
    },
    {
      path: "/join-us",
      name: "JoinUs",
      component: () => import("../views/Seller.vue"),
      meta: { requiresAuth: true },
      
    },
    // {
    //   path: "/account/orders",
    //   name: "Orders",
    //   component: JSON.parse(localStorage.getItem("app-user"))?.roles.includes(
    //     "ROLE_SELLER"
    //   )
    //     ? import("../components/Account/seller/Orders.vue")
    //     : import("../components/Account/client/Orders.vue"),
    //   meta: { requiresAuth: true },
    // },
    {
      path: "/account/addresses",
      name: "Addresses",
      component: import("../components/Account/client/Addresses.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/account/settings",
      name: "Settings",
      component: import("../components/Account/client/Settings.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/admin/dashboard",
      name: "AdminDashboard",
      component: import("../views/Admin/Dashboard.vue"),
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
