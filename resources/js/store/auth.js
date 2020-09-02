const state = {
  user: null
}

const getters = {
  check: state => !! state.user,
  user: state => state.user ? state.user : '',
}

const mutations = {
  setUser(state, user) {
    state.user = user;
  }
}

const actions = {
  async login(context, data) {
    await axios.post('/api/login', data).then(res => {
      context.commit('setUser', res.data.user);
    });
  },

  async logout(context) {
    await axios.post('/api/logout').then(res => {
      context.commit('setUser', null);
    });
  },

  async currentUser(context) {
    await axios.get('/api/user').then(res => {
      const user = res.data || null;
      context.commit('setUser', user);
    });
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}