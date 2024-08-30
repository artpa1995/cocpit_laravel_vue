<template>
  <div>
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import axios from 'axios';

export default {
  computed: {
    ...mapGetters(['isAuthenticated', 'getUser']),
  },
  methods: {
    ...mapActions(['removeUser']),
    logout() {
      axios.post('/logout')
        .then(() => {
          this.removeUser(); // Убираем пользователя из store
          this.$router.push('/login'); // Перенаправляем на страницу входа
        })
        .catch(error => {
          console.error('Ошибка при выходе', error);
        });
    },
  },
};
</script>
