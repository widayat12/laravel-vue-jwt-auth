<template>
  <div id="main">
    <Navbar/>
    <div class="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Navbar from './Navbar.vue';
    export default {
      name:'main-app',
      components:{
        Navbar
       }
    }
</script>
