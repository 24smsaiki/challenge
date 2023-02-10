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
              >Mes commandes</router-link
            >
          </span>
        </li>
        <li>
          <span
            ><router-link active-class="active" to="/account/addresses"
              >Mes adresses</router-link
            ></span
          >
        </li>
        <li>
          <span
            ><router-link active-class="active" to="/account/settings"
              >Paramètres</router-link
            ></span
          >
        </li>
      </ul>
    </nav>
  </div>
</template>
