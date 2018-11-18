import Home from './components/Home.vue';
import Login from './components/auth/login.vue';
import CustomersMain from './components/customers/Main.vue'
import CustomersLIst from './components/customers/List.vue'
import CustomersNew from './components/customers/New.vue'
import Customer from './components/customers/View.vue'

export const routes = [
  {
    path: '/',
    component: Home,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/login',
    component: Login
  },
  {
    path: '/customers',
    component: CustomersMain,
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: '/',
        component: CustomersLIst
      },
      {
        path: 'new',
        component: CustomersNew
      },
      {
        path: ':customer_id',
        component: Customer
      }
    ]
  }
];
