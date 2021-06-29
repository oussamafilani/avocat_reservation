<template>
  <div id="nav">
    <TheNavigation :hundler="hundler" :stateRoute="stateRoute" />
  </div>
  <router-view />
</template>

<script>
import TheNavigation from "@/components/TheNavigation.vue";

export default {
  components: {
    TheNavigation,
  },
  data() {
    return {
      hundler: "booking",
      stateRoute: true,
    };
  },

  updated() {
    if (!sessionStorage.getItem("token")) {
      this.hundler = "";
      this.stateRoute = false;
    }
  },
  beforeMount() {
    if (!sessionStorage.getItem("token")) {
      this.hundler = "";
      this.stateRoute = false;
    }
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
</style>
