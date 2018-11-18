<template>
  <div class="container">
    <div class="row">
    <div class="col-md-6 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading login-heading">Login</div>
          <div class="panel-body">
            <form @submit.prevent="authenticate">
              <div class="form-group-row">
                <label for="email">Email :</label>
                <input type="email" v-model="form.email" class="form-control" placeholder="Alamat Email">
              </div>
              <div class="form-group-row">
                <label for="password">Password :</label>
                <input type="password" v-model="form.password" class="form-control" placeholder="Password">
              </div>
              <div class="form-group">
                <div class="login">
                 <input type="submit" class=" btn btn-primary" value="Login">
                </div>
              </div>
              <div class="form-group-row" v-if="authError">
                <p class="error">{{ authError}}</p>
              </div>
            </form>
          </div>
      </div>
    </div>
   </div>
  </div>
</template>

<script>
import {login} from '../../helpers/Auth';

export default{
  name: 'login',
  data(){
    return {
      form: {
        email: '',
        password: ''
      },
      error: null
    };
  },
  methods: {
    authenticate() {
      this.$store.dispatch('login');
      login(this.$data.form)
        .then((res) => {
          this.$store.commit("loginSuccess",res);
          this.$router.push({path: '/'});
        })
        .catch((error) => {
          this.$store.commit("loginFailed", {error});
        })
    }
  },
  computed: {
    authError () {
      return this.$store.getters.authError
    }
  }
}
</script>

<style scoped>
.login{
  margin: 15px 0 5px 0;
}
.login-heading{
  font-size: 1.5em;
  background-color: gold;
  color: #000;
  font-weight: bold;
  text-align: center;
}
.error {
  margin-top: 10px;
  text-align: center;
  color: #fff;
  background-color: red;
}
</style>
