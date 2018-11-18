<template>
  <div class="costomer-view" v-if="customer">
    <div class="userImage">
      <img src="" alt="">
    </div>
    <div class="user-info">
      <table>
        <tr>
          <th>ID</th>
          <td>{{ customer.id }}</td>
        </tr>
        <tr>
          <th>Name</th>
          <td>{{ customer.name }}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{ customer.email}}</td>
        </tr>
        <tr>
          <th>No.phone</th>
          <td>{{ customer.no_phone }}</td>
        </tr>
        <tr>
          <th>Website</th>
          <td>{{ customer.website}}</td>
        </tr>
      </table>
      <router-link to="/customers">Back to Customers</router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'view',
  created () {
    axios.get(`/api/customers/${this.$route.params.customer_id}`, {
      headers: {
        "Authorization": `Bearer ${this.currrentUser.token}`
      }
    })
      .then((response) => {
        this.customer = response.data.customer
      })
  },
  data () {
      return {
        customer: null
      }
  },
  computed: {
    currrentUser () {
      return this.$store.getters.currrentUser
    }
  },
}
</script>

<style lang="css">
</style>
