import { getLocalUser } from "./helpers/Auth";

const user = getLocalUser ();

export default {
  state: {
    currrentUser: user,
    isLoggedId : !!user,
    loading: false,
    auth_error: null,
    customers: [],
    recipes:[]
  },
  getters: {
    isLoading(state) {
      return state.loading;
    },
    isLoggedId(state) {
      return state.isLoggedId;
    },
    currrentUser(state) {
      return state.currrentUser;
    },
    authError(state) {
      return state.auth_error;
    },
    customers(state) {
      return state.customers;
    },
    recipes(state) {
      return state.recipes;
    }
  },
  mutations: {
    login (state) {
      state.loading = true;
      state.auth_error = null;
    },
    loginSuccess (state, payload) {
      state.auth_error = null;
      state.isLoggedId = true;
      state.loading = false;
      state.currrentUser = Object.assign({}, payload.user, {token: payload.access_token});

      localStorage.setItem("user", JSON.stringify(state.currrentUser));
    },
    loginFailed (state, payload) {
      state.loading = false;
      state.auth_error = payload.error;
    },
    logout (state) {
      localStorage.removeItem("user");
      state.isLoggedId = false;
      state.currrentUser = null;
    },
    updateCustomers (state,payload) {
      state.customers = payload;
    }
  },
  actions: {
    login (context) {
      context.commit('login')
    },
    getCustomers (context) {
      axios.get('api/customers', {
        headers: {
          "Authorization": `Bearer ${context.state.currrentUser.token}`
        }
        })
        .then((response) => {
          context.commit('updateCustomers',response.data.customers);
      });
    },
    getrecipes (context) {
      axios.get('api/recipes', {
        headers: {
          "Authorization": `Bearer ${context.state.currrentUser.token}`
        }
        })
        .then((response) => {
          context.commit('updateRecipes',response.data.recipes);
      });
    }
  }

}
