import { createRouter, createWebHistory } from 'vue-router'
import Home from "../views/Home.vue";
import CategoryPage from "../views/CategoryPage.vue";
import ProductPage from "../views/ProductPage.vue";
import Checkout from "../views/Checkout.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: "/", name: "Home", component: Home },
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
      name: "Checkout",
      component: Checkout,
    },
    {
      path: '/users',
      name: 'users',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../components/security/UsersList.vue')
    },
  ]
})

export default router
