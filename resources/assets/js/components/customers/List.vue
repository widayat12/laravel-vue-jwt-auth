<template>
  <div>
    <div class="header">
      <h2>Customers</h2>
    </div>
    <div class="btn-wrapper">
      <router-link to="/customers/new" class="btn btn-primary btn-sm">New</router-link>
    </div>
    <table class="table">
      <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Website</th>
        <th>Action</th>
      </thead>
      <tbody>
        <template v-if="!customers.length">
          <tr>
            <td>Data tidak tersedia</td>
          </tr>
        </template>
        <template v-else>
          <tr v-for="customer in customers" :key="customer.id">
            <td>{{ customer.name }}</td>
            <td>{{ customer.email}}</td>
            <td>{{ customer.no_phone}}</td>
            <td>{{ customer.website}}</td>
            <td>
              <router-link :to="`/customers/${ customer.id }`">View</router-link>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'list',
  mounted () {
    this.$store.dispatch('getCustomers');
  },
  computed: {
    customers () {
      return this.$store.getters.customers;
    }
  }
}
</script>

<style scoped>
.header {
  color: gold;
  font-weight: bold;
}
.btn-wrapper {
  text-align: right;
  margin-bottom: 20px;
}
</style>
