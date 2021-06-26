<template>
  <p>{{ newToken }}</p>

  <router-link to="/">Singin</router-link>

  <div class="log-form">
    <div class="group log-input">
      <input v-model="nom_client" type="text" placeholder="nom client" />
    </div>
    <div class="group log-input">
      <input v-model="prenom_client" type="text" placeholder="prenom client" />
    </div>
    <div class="group log-input">
      <input v-model="profession" type="text" placeholder="profession" />
    </div>
    <div class="group log-input">
      <input v-model="age_client" type="text" placeholder="age client" />
    </div>
    <div class="group log-input">
      <input v-model="cin" type="text" placeholder="cin" />
    </div>

    <span class="check left-align">
      <input type="checkbox" />
      <label>Remember Me</label>
    </span>
    <router-link class="right-align" to="/">Singin</router-link>
    <br /><br />

    <div class="container-log-btn">
      <button @click="createClient()" name="btn_submit" class="log-form-btn">
        <span>Singup</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  components: {},
  props: ["name"],

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
      this.$router.push({ name: "Home", params: { token: this.newToken } });
    },
  },
  beforeMount() {
    if (sessionStorage.getItem("token")) {
      this.$router.push({ name: "Booking" });
    }
  },
};
</script>


<style scoped>
* {
  box-sizing: border-box;
}

body {
  background: #eee;
  -webkit-font-smoothing: antialiased;
}

hgroup {
  text-align: center;
  margin-top: 4em;
}

span {
  font-size: 0.95em;
  font-weight: 600;
  letter-spacing: 0.3em;
  line-height: 24px;
  text-transform: uppercase;
}

/*------------------------------------------------------------------
[ Login Form ]*/

.log-form {
  width: 500px;
  margin: 4em auto;
  padding: 3em 2em 2em 2em;
  background: #fafafa;
  border: 1px solid #ebebeb;
  box-shadow: rgba(0, 0, 0, 0.14902) 0px 1px 1px 0px,
    rgba(0, 0, 0, 0.09804) 0px 1px 2px 0px;
}

.group {
  position: relative;
  margin-bottom: 45px;
}

.log-input {
  font-size: 18px;
  padding: 10px 10px 10px 5px;
  -webkit-appearance: none;
  display: block;
  background: #fafafa;
  color: #636363;
  width: 100%;
  border: none;
  border-radius: 0;
  border-bottom: 1px solid #757575;
}

.log-input:focus {
  outline: none;
}

.log-form a {
  font-size: 9px;
  font-weight: 600;
  letter-spacing: 0.3em;
  line-height: 24px;
  text-transform: uppercase;
  color: #aaaaaa;
}

.left-align {
  float: left;
  text-align: left;
}

.right-align {
  float: right;
  text-align: right;
}

/*------------------------------------------------------------------
[ Button same code as contact form ]*/

.container-log-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding-top: 50px;
}

.log-form-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 20px;
  min-width: 250px;
  height: 50px;
  background-color: transparent;
  border-radius: 7px;
  cursor: pointer;

  font-size: 16px;
  color: #000;
  line-height: 1.2;
  text-transform: uppercase;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
  position: relative;
  z-index: 1;
}

.log-form-btn::before {
  content: "";
  display: block;
  position: absolute;
  z-index: -1;
  width: 100%;
  height: 100%;
  top: 0;
  left: 50%;
  -webkit-transform: translateX(-50%);
  -moz-transform: translateX(-50%);
  -ms-transform: translateX(-50%);
  -o-transform: translateX(-50%);
  transform: translateX(-50%);
  border-radius: 7px;
  background-color: #b8b8c0;
  pointer-events: none;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.log-form-btn:hover:before {
  background-color: #acacac;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"],
textarea,
select {
  border: none;
  border-radius: none;
  background: transparent;
  font-family: "Montserrat";
  font-size: 12px;
  font-weight: 400;
  letter-spacing: 0.2em;
  line-height: 24px;
  height: 42px;
  padding-left: 20px;
  padding-right: 20px;
  text-transform: none;
  width: 100%;
}

input[type="checkbox"]:not(:checked) + label,
input[type="checkbox"]:checked + label {
  color: #aaaaaa;
  cursor: pointer;
  font-size: 9px;
  font-weight: 600;
  letter-spacing: 0.3em;
  padding-left: 10px;
  padding-top: 6px;
  position: relative;
  text-transform: uppercase;
}
</style>