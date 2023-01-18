
<script>
import axios from 'axios'
import * as Request from '../../services/request';

export default {
  data() {
    return {
      users: []
    }
  },
  mounted() {
    Request.make('get', 'user/all')
      .then((response) => {
        this.users = response;
      }
      )
  }
}
</script>



<template>
    <div class="container">
        <table>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Action</th>
            </tr>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.roles }}</td>
                <td>A venir</td>
            </tr>
      
        </table>

    </div>
</template>

<style scoped>
header {
  line-height: 1.5;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }
  table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}


}
</style>


