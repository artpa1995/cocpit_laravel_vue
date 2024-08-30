<template>
    <div>
      <Header></Header>
      <h2>Profile</h2>
      <navbar />
      <div class="flex space-x-5 ">
        <div class="w-1/3 flex justify-end">
          <img :src="this.new_avatar" alt="Avatar" style="width: 120px; height: 120px;" @click="openFileInput">
          <input type="file" ref="avatarInput" style="display: none" @change="handleAvatarChange">
        </div>
        <div class="w-2/3 flex justify-start">
          <form @submit.prevent="updateProfile" >
            <div class="flex items-center mt-5 justify-start">
              <label for="email">Email</label>
              <div class="rounded-lg px-5 py-3 border border-grey-600">{{ getUser.email }}</div>
            </div>
            <div class="flex items-center mt-5">
              <label for="first_name">First Name</label>
              <input class="rounded-lg px-5 py-3 border border-grey-600" type="text" v-model="first_name" id="first_name">
            </div>
            <div class="flex items-center mt-5">
              <label for="last_name">Last Name</label>
              <input class="rounded-lg px-5 py-3 border border-grey-600" type="text" v-model="last_name" id="last_name">
            </div>
            <div class="flex items-center mt-5">
              <label for="phone">Phone</label>
              <input class="rounded-lg px-5 py-3 border border-grey-600" type="text" v-model="phone" id="phone">
            </div>
            <div class="flex items-center mt-5">
              <label for="password">Password</label>
              <input class="rounded-lg px-5 py-3 border border-grey-600" type="password" v-model="password" id="password">
            </div>
            <div class="flex items-center mt-5">
              <label for="confirm_password">Confirm Password</label>
              <input class="rounded-lg px-5 py-3 border border-grey-600" type="password" v-model="confirm_password" id="confirm_password">
            </div>
            
            <button type="submit" class="text-white bg-sky-900 rounded-lg px-5 py-3">Update Profile</button>
          </form>
        </div>
      </div>
      <Footer></Footer>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import navbar from './Navbar.vue';
  import Header from './layout/header.vue';
  import Footer from './layout/footer.vue';
  import { mapGetters, mapActions } from 'vuex';
  
  export default {
    components: {
      navbar,
      navbar,
    Header,
    Footer,
    },
    data() {
      return {
        first_name: '',
        last_name: '',
        phone: '',
        password: '',
        confirm_password: '',
        avatar: null, 
        new_avatar : null
      };
    },
    computed: {
      ...mapGetters(['getUser']),
    },
    methods: {
      ...mapActions(['updateUser']),
      openFileInput() {
      this.$refs.avatarInput.click();
    },
  
    handleAvatarChange(event) {
      this.avatar = event.target.files[0];
      this.new_avatar = URL.createObjectURL(this.avatar)
      const formData = new FormData();
      formData.append('avatar', this.avatar);

      axios.post('/update-profile-avatar', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(response => {
          this.updateUser(response.data.user);
          alert('Profile updated successfully');
        })
        .catch(error => {
          console.error('Error updating profile', error);
        });
    },
      updateProfile() {

        if (this.password && this.password !== this.confirm_password) {
          alert("Passwords do not match!");
          return;
        }
  
        const formData = {
                'first_name' : this.first_name || '',
                'phone' : this.phone || '',
                'last_name' : this.last_name || '',
                'password' : this.password || '',
                'confirm_password' : this.confirm_password || '',
        };

        axios.post('/update-profile', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(response => {
          this.updateUser(response.data.user);
          alert('Profile updated successfully');
        })
        .catch(error => {
            if (error.response) {
                alert(` ${error.response.data.message}`);
            } else if (error.request) {
                alert('No response received from server');
            } else {
                alert(`Error: ${error.message}`);
            }
            console.error('Error updating profile', error);
        });
      }
    },
    created() {
      if (this.getUser) {
        this.first_name = this.getUser.first_name;
        this.last_name = this.getUser.last_name;
        this.phone = this.getUser.phone;
        this.password = this.getUser.password;
        this.avatar = this.getUser.avatar;
        this.new_avatar = this.getUser.avatar;
      }
    }
  };
  </script>
  