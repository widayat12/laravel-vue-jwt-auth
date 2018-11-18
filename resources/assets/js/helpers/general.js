export function initialize (store, router) {
  router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const currrentUser = store.state.currrentUser;

    if(requiresAuth && !currrentUser){
      next('/login');
    }else if(to.path == '/login' && currrentUser){
      next('/');
    } else {
      next();
    }
  });
  axios.interceptors.response.use(null, (error) => {
    if(error.response.status == 401) {
       store.commit('logout');
       router.commit('/login');
    }
    return Promise.reject(error);
  })
}
