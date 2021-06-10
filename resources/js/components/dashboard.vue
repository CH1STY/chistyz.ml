<template>
     <div class="container-fluid ">
        <navbar/>
        <cityName/>
     </div>
</template>

<script>
    import cityName from './Location/cityName.vue';
    export default{
        beforeCreate()
        {
            if(!User.loggedIn())
            {
                this.$router.push({name:'login'});
            }
        },
        created(){
        
        },
        data(){
            return {

            }
        },
        components:{
            cityName,
        }
        
    }
</script>