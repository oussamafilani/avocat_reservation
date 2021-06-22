<template>
  <div class="Booking">
    <h1>This is an Booking page</h1>
    <p>{{ name }}</p>
    <button @click="logout()">logout</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: this.$route.params.name,
    };
  },
  computed: {},
  methods: {
    logout: function () {
      sessionStorage.removeItem("token");
      this.$router.push({ name: "Home" });
    },
  },
};
</script>
