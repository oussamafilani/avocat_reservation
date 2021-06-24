<template>
  <BookingForm />
  <router-view />
</template>
<script>
import BookingForm from "@/components/BookingForm.vue";

export default {
  components: {
    BookingForm,
  },
};
</script>
