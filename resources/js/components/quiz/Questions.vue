<template>
    <div >
      <h1 class="text-center my-5 text-4xl">Questions</h1>
      <div class=" flex justify-center">
        <form @submit.prevent="submit_questions" class="">
          <div class="flex items-center gap-x-5">
            <label for="">What kind of coaching best describes your work?</label>
          </div>

          <div class="flex items-center gap-x-5 mt-5">
            <label for="">What is a minimum sustainable monthly income from coaching?</label>
          </div>

          <div class="flex items-center gap-x-5 mt-5">
              <label for="">What is your monthly income goal for coaching?</label>
          </div>
          
          <div class="flex items-center gap-x-5 mt-5">
              <label for="">How many clients would you want if you were at your income goal?</label>
          </div>
            
          <div class="flex items-center gap-x-5 mt-5">
              <label for="">What best describes your relationship to your coaching practice?</label>
          </div>

          <div class="flex items-center gap-x-5 mt-5">
              <label for="">Mastery of Business Operations (W)</label>
          </div> 
          <div class="flex items-center gap-x-5 mt-5">
              <label for="">Mastery of Mechanics of Change (I)</label>
          </div> 
          <div class="flex items-center gap-x-5 mt-5">
              <label for="">Mastery of Business Growth (S)</label>
          </div> 
          <div class="flex items-center gap-x-5 mt-5">
              <label for="">Mastery of Interpersonal Effectiveness (C)</label>
          </div>   
          <div class="flex justify-center mt-5">
            <button type="submit" class="text-white bg-sky-900 rounded-lg px-5 py-3 ">Submit</button>
          </div>
        </form>
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
      submit_questions() {
        axios.post('/submit_questions', {
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


  