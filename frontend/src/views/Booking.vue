<template>
  <div class="Booking">
    <h1>This is an Booking page</h1>
    <p>{{ name }}</p>
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
};
</script>
