<template>
  <SingInForm />
  <router-view />
</template>
<script>
import SingInForm from "@/components/SingInForm.vue";

export default {
  components: {
    SingInForm,
  },
};
</script>
