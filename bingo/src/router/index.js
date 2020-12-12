import Vue from "vue";
import VueRouter from "vue-router";
import Rounds from "../views/Rounds.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Rounds,
  },
  {
    path: "/round/:id",
    name: "round",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/Round.vue"),
  },
  {
    path: "/users/",
    name: "users",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/Users.vue"),
  },
];

const router = new VueRouter({
  routes,
});

export default router;
