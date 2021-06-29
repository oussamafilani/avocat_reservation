<template>
  <div id="nav">
    <TheNavigation :hundler="hundler" />
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
      hundler: "Booking",
    };
  },
  methods: {
    hundlerouter: function () {
      if (!sessionStorage.getItem("token")) {
        this.hundler = "";
      }
    },
  },
  beforeMount() {
    this.hundlerouter();
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
