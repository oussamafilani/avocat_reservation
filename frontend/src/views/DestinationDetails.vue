<template>
<section class="destination"></section>
<h1>{{destination.name}}</h1>
<div class="destination-details"></div>
<img :src="require(`@/assets/${destination.image}`)" :alt="destination.name">
</template>

<script>
export default{
    data() {
        return {
            DestinationId : this.$route.params.id
        }
    },
    computed:{

    }
}
</script>