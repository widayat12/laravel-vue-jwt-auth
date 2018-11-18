<template>
<div class="container">
  <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">My APP SPA</div>
                <div class="card-body">
                  <h2>{{ welcome }}</h2>
                  <img src="https://static1.squarespace.com/static/52b3afb3e4b00492bb71af6c/t/52b49db2e4b060df0c31b2e4/1387568563458/IMG-Cor-Logo-WEB2.jpg" alt="">
                </div>
            </div>
        </div>
  </div>
</div>
</template>
<script>
  export default {
    name : 'home',
    computed: {
      welcome(){
        return this.$store.getters.welcome
      }
    }
  }
</script>
