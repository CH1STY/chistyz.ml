<template>
    <div>
        <navbar/>
        <h2>Welcome Users</h2>
    </div>
</template>

<script>
import navbar from './navbar.vue';

export default {
  components: { navbar },
     beforeCreate()
    {
        if(!User.loggedIn())
        {
            this.$router.push({name:'login'});
        }
    },
}
</script>

<style scoped>

</style>
