<template>
        <form class="form" @submit.prevent="register">
          <h1 class="form__title">Create An Account</h1>
          <div class="form__group">
            <label>Name</label>
            <input type="text" class="form__control" v-model="form.name">
            <small class="error__control" v-if="error.name">{{error.name}}</small>
          </div>
          <div class="form__group">
            <label>Email</label>
            <input type="email" class="form__control" v-model="form.email">
            <small class="error__control" v-if="error.email">{{error.email}}</small>
          </div>
          <div class="form__group">
            <label>Password</label>
            <input type="password" class="form__control" v-model="form.password">
            <small class="error__control" v-if="error.password">{{error.password}}</small>
          </div>
          <div class="form__group">
            <label>Confirm Password</label>
            <input type="password" class="form__control" v-model="form.password_confirmation">
          </div>
          <div class="form__group">
            <button :disabled="isProcessing" class="btn btn__primary">Register</button>
          </div>
        </form>
</template>

<script type="text/javascript">
  export defa {
    data() {
      return {
        form: {
          name: '',
          email: '',
          password: '',
          password_confirmation: ''
        },
        error: {},
        isProcessing: false
      }
    },
    methods: {
      
    }
  }
</script>
