<template>
    <div >
      <h1 class="text-center my-5 text-4xl">Register</h1>
      <div class=" flex justify-center">
        <form @submit.prevent="register" class="">
          <div class="flex items-center gap-x-5">
            <label for="">Forst Name</label>
            <input v-model="first_name"  class="rounded-lg px-5 py-3 border border-grey-600" type="text" placeholder="First Name">
          </div>

          <div class="flex items-center gap-x-5 mt-5">
            <label for="">Last Name</label>
            <input v-model="last_name" class="rounded-lg px-5 py-3 border border-grey-600" type="text" placeholder="Last Name">
          </div>

          <div class="flex items-center gap-x-5 mt-5">
              <label for="">Phone</label>
              <input v-model="phone" class="rounded-lg px-5 py-3 border border-grey-600" type="text" placeholder="Phone">
          </div>
          
          <div class="flex items-center gap-x-5 mt-5">
              <label for="">Email</label>
              <input v-model="email" class="rounded-lg px-5 py-3 border border-grey-600" type="email" placeholder="Email">
          </div>
            
          <div class="flex items-center gap-x-5 mt-5">
              <label for="">Password</label>
              <input v-model="password" class="rounded-lg px-5 py-3 border border-grey-600" type="password" placeholder="Password">
          </div>

          <div class="flex items-center gap-x-5 mt-5">
              <label for="">Confirm Password</label>
              <input v-model="password_confirmation" class="rounded-lg px-5 py-3 border border-grey-600" type="password" placeholder="Confirm Password">
          </div>   
          <div class="flex justify-center mt-5">
            <button type="submit" class="text-white bg-sky-900 rounded-lg px-5 py-3 ">Register</button>
          </div>
          <a href="/auth/google" class="flex items-center gap-x-5 mt-5 justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" viewBox="-3 0 262 262" preserveAspectRatio="xMidYMid"><path d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" fill="#4285F4"/><path d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" fill="#34A853"/><path d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" fill="#FBBC05"/><path d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" fill="#EB4335"/></svg></a>

        </form>
      </div>
      <div class="text-center mt-6">
        <router-link class="text-blue-600 text-center" to="/login">Login</router-link>
    </div>
  

    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { useStore, mapActions } from 'vuex';
  
  export default {
    data() {
      return {
        first_name: '',
        last_name: '',
        phone: '',
        email: '',
        password: '',
        password_confirmation: ''
      };
    },
    setup(){
      const store = useStore()
    },

    methods: {
      ...mapActions(['setUser']),
      register() {
        axios.post('/register', {
          first_name: this.first_name,
          last_name: this.last_name,
          phone: this.phone,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        }).then(response => {
          this.setUser(response.data.user);
          this.$router.push('/questions');
        }).catch(error => {
          console.error(error);
        });
      }
    }
  };
  </script>


  