<template>
    <div>
        <h2>Welcome Users</h2>
    </div>
</template>

<script>

export default {
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
