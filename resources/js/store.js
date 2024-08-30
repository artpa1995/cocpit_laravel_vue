// import { createStore } from 'vuex';
// import axios from 'axios';

// const store = createStore({
//   state: {
//     user: JSON.parse(localStorage.getItem('user')) || {}, 
//   },
//   mutations: {
//     updateUser(state, user) {
//       state.user = user;
//       localStorage.setItem('user', JSON.stringify(user)); 
//     },
//   },
//   actions: {
//     setUser(context, payload) {
//       context.commit('updateUser', payload);
//     },
//     removeUser(context) {
//       context.commit('updateUser', {});
//       localStorage.removeItem('user'); 
//     },
//   },
//   getters: {
//     getUser: (state) => state.user,
//     isAuthenticated: (state) => !!Object.keys(state.user).length, 
//   },
// });

// export default store;

import { createStore } from 'vuex';
import axios from 'axios';

const store = createStore({
  state: {
    user: JSON.parse(localStorage.getItem('user')) || {},
  },
  mutations: {
    updateUser(state, user) {
      state.user = user;
      localStorage.setItem('user', JSON.stringify(user));
    },
  },
  actions: {
    setUser(context, payload) {
      context.commit('updateUser', payload);
    },
    removeUser(context) {
      context.commit('updateUser', {});
      localStorage.removeItem('user');
    },
    async checkUser(context) {
      try {
        const response = await axios.post('/check-user');
        if (response.data.user) {
          context.commit('updateUser', response.data.user);
        } else {
          context.commit('updateUser', {});
          localStorage.removeItem('user');
        }
      } catch (error) {
        console.error('Ошибка при проверке пользователя', error);
        context.commit('updateUser', {});
        localStorage.removeItem('user');
      }
    },
	updateUser(context, user) {
		context.commit('updateUser', user);
	  },
  },
  getters: {
    getUser: (state) => state.user,
    isAuthenticated: (state) => !!Object.keys(state.user).length,
  },
});


store.dispatch('checkUser');

export default store;

