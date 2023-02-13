<template>
  <div class="sidebar">
    <nav class="nav">
      <ul>
        <li>
          <span>
            <router-link active-class="active" to="/account"
              >Profil</router-link
            >
          </span>
        </li>
        <li>
          <span>
            <router-link active-class="active" to="/account/orders"
              >Mes ventes</router-link
            >
          </span>
        </li>
        <li>
          <span>
            <router-link active-class="active" to="/account/products"
              >Mes produits</router-link
            >
          </span>
        </li>
        <li>
          <span>
            <router-link active-class="active" to="/account/backOrders"
              >Mes retours</router-link
            >
          </span>
        </li>
        <li>
          <span>
            <router-link active-class="active" to="/account/settings"
              >Paramètres</router-link
            >
          </span>
        </li>
      </ul>
    </nav>
  </div>
</template>
