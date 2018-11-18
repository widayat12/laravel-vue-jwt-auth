
<template>
  <div class="new-customer">
    <form @submit.prevent="add">
        <table class="table">
          <tr> Name </tr>
          <td>
            <input type="text" class="form-control" v-model="customer.name" placeholder="customer name">
          </td>
          <tr> Email </tr>
          <td>
            <input type="email" class="form-control" v-model="customer.email" placeholder="customer email">
          </td>
          <tr> No.Telphone </tr>
          <td>
            <input type="text" class="form-control" v-model="customer.no_phone" placeholder="customer phone">
          </td>
          <tr> Website </tr>
          <td>
            <input type="text" class="form-control" v-model="customer.website" placeholder="customer website">
          </td>
          <br>
          <tr>
            <td>
              <input type="button" value="cancel" class="btn btn-warning btn-sm">
              <input type="submit" value="create" class="btn btn-primary btn-sm">
            </td>
          </tr>
        </table>
    </form>
    <div class="error" v-if="errors">
      <ul>
        <li v-for="(fieldsError, fieldName) in errors"
          :key="fieldName">
          <strong>{{ fieldName }}</strong>{{ fieldsError.join('\n') }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import validate from 'validate.js'
export default {
  name: 'new',
  data () {
    return {
      customer: {
        name: '',
        email: '',
        no_phone: '',
        website: ''
      },
      errors: null
    }
  },
  computed: {
    currrentUser () {
      return this.$store.getters.currrentUser
    }
  },
  methods: {
    add () {
      this.errors = null
      const constraints = this.getConstraints()
      const errors = validate(this.$data.customer, constraints)
      if (errors) {
        this.errors = errors
          return;
      }
      axios.post('/api/customers/new', this.$data.customer, {
        headers: {
          "Authorization": `Bearer ${this.currrentUser.token}`
        }
      })
      .then((response) => {
        this.$router.push('/customers')
      })
    },
    getConstraints () {
      return {
        name: {
          presence: true,
          length: {
            minimum: 3,
            message: 'Must be least 3 characters long'
          }
        },
        email: {
          presence: true,
          email: true
        },
        no_phone: {
          presence: true,
          numericality: true,
          length: {
            minimum:10,
            message: 'Must be least 10 charaters long'
          }
        },
        website: {
          presence: true,
          url: true
        }
      }
    }
  }
}
</script>

<style scoped>
.error {
  border-radius: 5px;
  background-color: lightcoral;
  font-size: 1em;
  margin: 15px;
  padding: 15px;
}
</style>
