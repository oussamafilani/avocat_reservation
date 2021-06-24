<template>
  <SingupForm />
  <router-view />
</template>
<script>
import SingupForm from "@/components/SingupForm.vue";

export default {
  components: {
    SingupForm,
  },
};
</script>
