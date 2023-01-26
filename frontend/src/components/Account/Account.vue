<script setup>
import Header from "../Header.vue";
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)" />
  <section id="account">
    <div class="sidebar">
      <nav class="nav">
        <ul>
          <li class="active"><span>Profil</span></li>
          <li><span>Mes commandes</span></li>
          <li><span>Mes adresses</span></li>
          <li><span>Paramètres</span></li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <h1>Mon profil</h1>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam
        voluptates, quod, quia, voluptate quae voluptatem quibusdam quos
        accusantium quas dolorum quidem. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam, quae. Quisquam, quae.
        Quisquam, quae. Quisquam, quae. Quisquam,
      </p>
    </div>
  </section>
</template>

<style scoped lang="scss">
#account {
  height: 700px;
  margin: 25px;
  display: flex;
  flex-direction: row;

  .sidebar {
    height: 100%;
    border: 1px solid black;
    border-radius: 5px;
    width: 300px;
    background: black;
    .nav {
      position: relative;
      margin: 0 15%;
      text-align: right;
      top: 50%;
      transform: translateY(-50%);
      font-weight: bold;
    }

    .nav ul {
      list-style: none;

      li {
        position: relative;

        span {
          cursor: pointer;
          line-height: 5em;
          text-transform: uppercase;
          text-decoration: none;
          letter-spacing: 0.4em;
          color: rgba(#fff, 0.8);
          display: block;
          transition: all ease-out 300ms;
        }

        &.active span {
          color: #d87d4a;
        }

        &:not(.active)::after {
          opacity: 0.2;
        }

        &:not(.active):hover span {
          color: #d87d4a;
        }

        &::after {
          content: "";
          position: absolute;
          width: 100%;
          height: 0.2em;
          background: black;
          left: 0;
          bottom: 0;
          background-image: linear-gradient(to right, #d87d4a, #ef6210);
        }
      }
    }
  }

  .content {
    border: 1px solid black;
    border-radius: 5px;
    padding: 25px;
    height: 100%;
    width: calc(100% - 300px);
    margin-left: 25px;
  }
}
</style>
