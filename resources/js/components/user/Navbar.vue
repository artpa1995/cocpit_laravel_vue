<template>
    <div>
      <nav>
        <router-link class="text-blue-600" to="/">Home</router-link>
        <router-link class="text-blue-600" to="/profile">Profile</router-link>
        <button class="text-red-600 border border-red-600 rounded-lg px-5 px-3" @click="user_logout">Logout</button>
      </nav>
    </div>
</template>

<script>
  import Helpers from '../../helpers/index';
  export default{
    setup(){
      const { logout } = Helpers()
      const user_logout = async() => {
        await logout()
      }
      return{
        user_logout
      }
    }
  }
</script>