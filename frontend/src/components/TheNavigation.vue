<template >
  <div id="nav">
    <router-link to="/">Home</router-link>
    <!-- <router-link v-if="stateRoute" to="/booking">{{ hundler }}</router-link> -->
    <router-link v-if="state" to="/booking">Booking</router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
      state: true,
    };
  },
  props: {
    hundler: String,
    stateRoute: Boolean,
  },
  beforeMount() {
    if (sessionStorage.getItem("token") === null) {
      this.state = false;
    }
  },
};
</script>

<style scoped>
#nav {
  display: flex;
  justify-content: center;
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
  padding: 0 10px;
}

#nav a.router-link-exact-active {
  /* color: #42b983; */
  color: #ab26ab;
}
</style>