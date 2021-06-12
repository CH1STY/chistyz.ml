<template>
     <div class="container-fluid ">
        <navbar/>
        <profile/>
     </div>
</template>

<script>
    import profile from './User/profile.vue';
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
            profile
        }
        
    }
</script>