import { createRouter, createWebHistory } from "vue-router";

import { useProductStore } from "../stores/ProductStore";

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
      path: "/product/:product",
      name: "Product",
      component: import("../views/Product.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/paymentRefused",
      name: "Payment",
      component: import("../components/Checkout/Payment.vue"),
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
    {
      path: "/account",
      name: "Account",
      component: import("../components/Account/Account.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/order/payment/success/:id",
      name: "PaymentSuccess",
      component: () => import("../views/Checkout.vue"),
    },
    {
      path: "/join-us",
      name: "JoinUs",
      component: () => import("../views/Seller.vue"),
    },
    {
      path: "/account/orders",
      name: "Orders",
      component: import("../components/Account/Orders.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/account/addresses",
      name: "Addresses",
      component: import("../components/Account/client/AddressesClient.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/account/backOrders",
      name: "BackOrders",
      component: import("../components/Account/Back.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/account/products",
      name: "Products",
      component: import("../components/Account/seller/ProductsSeller.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/account/settings",
      name: "Settings",
      component: import("../components/Account/Settings.vue"),
      meta: { requiresAuth: true },
    },
    {
      path: "/Admin/Orders",
      name: "AdminOrders",
      component: import("../views/Admin/Orders.vue"),
      meta: { requiresAuth: true },
      beforeEnter: (to, from, next) => {
        if (isAdmin()) {
          next();
        } else {
          next({ name: "Home" });
        }
      }
    },
    {
      path: "/Admin/Products",
      name: "AdminProducts",
      component: import("../views/Admin/Products.vue"),
      meta: { requiresAuth: true},
      beforeEnter: (to, from, next) => {
        if (isAdmin()) {
          next();
        } else {
          next({ name: "Home" });
        }
      }
    },
    {
      path: "/Admin/Users",
      name: "AdminUsers",
      component: import("../views/Admin/Users.vue"),
      meta: { requiresAuth: true },
      beforeEnter: (to, from, next) => {
        if (isAdmin()) {
          next();
        } else {
          next({ name: "Home" });
        }
      }
    },
    {
      path: "/Admin/sellers",
      name: "AdminSellers",
      component: import("../views/Admin/Sellers.vue"),
      meta: { requiresAuth: true },
      beforeEnter: (to, from, next) => {
        if (isAdmin()) {
          next();
        } else {
          next({ name: "Home" });
        }
      }
    },
    {
      path: "/Admin/Carriers",
      name: "AdminCarriers",
      component: import("../views/Admin/Carriers.vue"),
      meta: { requiresAuth: true },
      beforeEnter: (to, from, next) => {
        if (isAdmin()) {
          next();
        } else {
          next({ name: "Home" });
        }
      }
    },
    {
      path: "/Admin/form",
      name: "AdminForm",
      component: import("../components/Admin/Form.vue"),
      meta: { requiresAuth: true },
      beforeEnter: (to, from, next) => {
        if (isAdmin()) {
          next();
        } else {
          next({ name: "Home" });
        }
      }
    },
    {
      path: "/Admin/Dashboard",
      name: "AdminDashboard",
      component: import("../views/Admin/Dashboard.vue"),
      meta: { requiresAuth: true, requiresAdmin: true },
      beforeEnter: (to, from, next) => {
        if (isAdmin()) {
          next();
        } else {
          next({ name: "Home" });
        }
      }
    },
    {
      path: "/products",
      name: "AllProducts",
      component: import("../views/Products.vue"),
      meta: { requiresAuth: true },
    },
  ],
});

const isAdmin = () => {
  const app = JSON.parse(localStorage.getItem("app-user"));
  if (app?.roles === "ROLE_ADMIN") {
    return true;
  }
  return false;
};


router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("app-token");
  const app = JSON.parse(localStorage.getItem("app-user"));

  if (app?.exp < Date.now() / 1000) {
    localStorage.removeItem("app-token");
    localStorage.removeItem("app-user");
    window.location.reload();
  }

  useProductStore().fetchProducts();

  if (to.matched.some((record) => record.meta.requiresAuth) && !token) {
    next({ name: "Login" });
  } else {
    next();
  }
 

});

export default router;
