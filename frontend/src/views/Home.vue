<template>
  <h2>home page</h2>
  <input v-model="token" placeholder="enter token" />
  <button @click="readClient()">login</button>
  <p>{{ name }}</p>

  <input v-model="nom_client" placeholder="nom client" />
  <input v-model="prenom_client" placeholder="prenom client" />
  <input v-model="profession" placeholder="profession" />
  <input v-model="age_client" placeholder="age client" />
  <input v-model="cin" placeholder="cin" />
  <button @click="createClient()">create</button>
  <p>{{ newToken }}</p>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      token: "",
      nom_client: "",
      prenom_client: "",
      profession: "",
      age_client: "",
      cin: "",
      newToken: "",
    };
  },

  methods: {
    readClient: async function () {
      let res = await fetch(
        "http://localhost/avocat_reservation/backend/user/getSingleClient",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            token: this.token,
          }),
        }
      );
      let data = await res.json();
      console.log(data);
      this.name = data[0].nom_client;
      this.$router.push({ name: "booking", params: { name: this.name } });

      return this.name;
    },
    createClient: async function () {
      let res = await fetch(
        "http://localhost/avocat_reservation/backend/user/createUser",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            nom_client: this.nom_client,
            prenom_client: this.prenom_client,
            profession: this.profession,
            age_client: this.age_client,
            cin: this.cin,
          }),
        }
      );
      let data = await res.json();
      console.log(data);
      this.newToken = data.message;
    },
  },
};
</script>
