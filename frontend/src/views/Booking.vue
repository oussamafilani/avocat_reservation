<template>
  <div class="Booking">
    <h1>This is an Booking page</h1>
    <p>{{ name }}</p>
    <button @click="logout()">logout</button>
    <br />

    <div class="log-form">
      <div class="group log-input">
        <input
          @change="getAvailableTime()"
          type="date"
          v-model="date"
          placeholder="date"
        />
      </div>
      <div class="group log-input">
        <select v-model="id_creneaux">
          <option value="">Please select time</option>
          <option v-for="item in AvailableTime" :key="item">
            {{ item.d_hour }}
          </option>
        </select>
      </div>
      {{ id_creneaux }}
      <div class="group log-input">
        <textarea v-model="sujet" placeholder="sujet"></textarea>
      </div>

      <br />

      <div class="container-log-btn">
        <button
          @click="createAppointment()"
          name="btn_submit"
          class="log-form-btn"
        >
          <span>Book</span>
        </button>
      </div>
    </div>
  </div>
  <!-- date/sujet/creneu/delete/updatee -->
  <!-- Start Appointment table -->
  <table style="overflow-x: auto">
    <caption>
      Liste des Appointment
    </caption>
    <thead>
      <tr>
        <th>Date</th>
        <th>Sujet</th>
        <th>Creneau</th>

        <th>Modifier</th>
        <th>Supprimer</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in Appointment" :key="item">
        <td>{{ item.date }}</td>
        <td>{{ item.sujet }}</td>
        <td>{{ item.id_creneaux }}</td>

        <td data-column="Modifier">
          <button name="modifier">
            <i class="fas fa-edit table-edit-icon"></i>
          </button>
        </td>
        <td data-column="Supprimer">
          <button
            name="supprimer"
            @click="deleteAppointment(item.id_appointment)"
          >
            <i class="fas fa-trash table-trash-icon"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- end  Appointment table -->
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      name: this.$route.params.name,
      date: "",
      id_creneaux: "",
      sujet: "",
      AvailableTime: "",
      Appointment: "",
    };
  },
  computed: {},
  methods: {
    getAvailableTime: async function () {
      try {
        let res = await axios.post(
          "http://localhost/avocat_reservation/backend/appointment/availableTimes",
          {
            token: sessionStorage.getItem("token"),
            date: this.date,
          }
        );

        console.log(res.data);
        this.AvailableTime = res.data;
      } catch (e) {
        console.log(e);
      }
    },
    createAppointment: async function () {
      let res = await fetch(
        "http://localhost/avocat_reservation/backend/appointment/createAppointment",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            token: sessionStorage.getItem("token"),
            date: this.date,
            id_creneaux: this.id_creneaux,
            sujet: this.sujet,
          }),
        }
      );
      let data = await res.json();
      console.log(data);
      this.getClientAppointment();
      // this.name = data[0].nom_client;
      // return this.name;
    },
    getClientAppointment: async function () {
      let res = await fetch(
        "http://localhost/avocat_reservation/backend/appointment/getClientAppointment",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            token: sessionStorage.getItem("token"),
          }),
        }
      );
      let data = await res.json();
      console.log(data);
      this.Appointment = data;
    },
    deleteAppointment: async function (idrdv) {
      let Api =
        "http://localhost/avocat_reservation/backend/appointment/deleteAppointment";
      const params = {
        method: "POST",
        headers: { "Content-type": "application/json" },
        body: JSON.stringify({
          token: sessionStorage.getItem("token"),
          id_appointment: idrdv,
        }),
      };
      let res = await fetch(Api, params);
      let data = await res.json();
      console.log(data);
      this.getClientAppointment();
    },
    logout: function () {
      sessionStorage.removeItem("token");
      this.$router.push({ name: "Home" });
    },
  },
  beforeMount() {
    this.getClientAppointment();
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
  background: transparent;
  border: none;
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

/* table style */

table {
  width: 60%;
  border-collapse: collapse;
  margin: 50px auto;
}

table caption {
  font-size: 1.5em;
  margin: 0.5em 0 0.75em;
}

/* Zebra striping */
tr:nth-of-type(odd) {
  background: #eee;
}

th {
  background: var(--first-color);
  color: #000;
  font-weight: bold;
  background: #b8b8c0;
}

td,
th {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: left;
  font-size: 16px;
}

tr,
td {
  text-align: center;
}

.table-edit-icon {
  cursor: pointer;
}

.table-trash-icon {
  cursor: pointer;
}
</style>