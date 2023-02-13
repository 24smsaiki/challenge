<script setup>
import Header from "../../Header.vue";
import Sidebar from "./SidebarSeller.vue";
import Profile from "./ProfileSeller.vue";
</script>

<template>
  <Header @toggle-menu-show="$emit('toggle-menu-show', $event)"></Header>
  <section id="account">
    <Sidebar />
    <div class="content">
      <Profile />
    </div>
  </section>
</template>

<style lang="scss">
#account,
#orders,
#products,
#profile,
#ordersBack {
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

          a {
            color: white;

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

            &.active {
              color: #d87d4a;
            }

            &:not(.active):hover {
              color: #d87d4a;
            }

            &:not(.active)::after {
              opacity: 0;
            }
          }
        }
      }
    }
  }

  .content {
    border: 1px solid black;
    border-radius: 5px;
    padding: 15px;
    height: 100%;
    width: calc(100% - 300px);
    margin-left: 25px;
  }
}
</style>
