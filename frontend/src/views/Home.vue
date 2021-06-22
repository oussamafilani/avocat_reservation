<template>
  <h2>home page</h2>
  <button v-on:click="readClient()">login</button>
  <input v-model="token" placeholder="enter token" />

  <p>{{ name }}</p>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      token: "",
    };
  },

  methods: {
    readClient: async function () {
      const res = await fetch(
        "http://localhost/avocat_reservation/backend/user/getUserInfo",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id_client: 1,
            token: this.token,
          }),
        }
      );
      const data = await res.json();
      console.log(data[0].client_info.nom_client);
      this.name = data[0].client_info.nom_client;
      return this.name;
    },
  },
};
</script>
