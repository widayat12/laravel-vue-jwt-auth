<template>
  <div class="home">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <router-link to="/"><a class="navbar-brand">My App SPA</a></router-link>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportContent">
                <ul class="nav navbar-nav navbar-right ml-auto">
                    <!-- Authentication Links -->
                          <template v-if="!currrentUser">
                            <li><router-link to="/login" class="nav-link">Login</router-link></li>
                            <li><router-link to="/register" class="nav-link">register</router-link></li>
                          </template>
                          <template v-else>
                            <li><router-link to="/" class="nav-link">Home</router-link></li>
                            <li><router-link to="/recipes" class="nav-link"><a>Recepis</a></router-link></li>
                            <li><router-link to="/customers" class="nav-link"><a>Customers</a></router-link></li>
                            <li class="nav-item dropdown">
                                <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                  {{ currrentUser.name }}<span class="caret"></span>
                                </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a href="#" @click.prevent="logout" class="dropdown-item">Logout</a>
                              </div>
                            </li>
                          </template>

                </ul>
            </div>
        </div>
    </nav>
  </div>
</template>
<script>
  export default {
    name: 'app-navbar',
    methods: {
      logout(){
        this.$store.commit('logout');
        this.$router.push('./login');
      }
    },
    computed:{
      currrentUser(){
        return this.$store.getters.currrentUser
      }
    }
  }
</script>
