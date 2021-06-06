<template>
    <div>
        <navbar/>
        <h2 class="text-center text-uppercase h3">Welcome {{username}}</h2>
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
    data(){
        return{
            username: localStorage.getItem('user'),
        }
    }
}
</script>
    

<style scoped>

</style>
