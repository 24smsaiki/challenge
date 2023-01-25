<script>
import * as Request from "../../services/Request";

export default {
  data() {
    return {
      users: [],
    };
  },
  mounted() {
    Request.make("get", "user/all")
      .then((response) => {
        this.users = response;
      })
      .catch((error) => {
        console.error(error);
      });
  },
};
</script>

<template>
  <div class="container">
    <table>
      <tr>
        <th>Id</th>
        <th>Adresse mail</th>
        <th>Rôles</th>
        <th>Action</th>
      </tr>
      <tr v-for="user in users" :key="user.id">
        <td>{{ user.id }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.roles }}</td>
        <td>TODO ...</td>
      </tr>
    </table>
  </div>
</template>

<style scoped>
@media (min-width: 1024px) {
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td,
  th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }
}
</style>
