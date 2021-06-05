<template>
    <h1>logout out successfully!</h1>
</template>

<script>
    export default{
        created()
        {
            if(User.loggedIn())
            {
                User.logout();
                this.$router.push({name:'login'});
                Toast.fire({
                    icon: 'success',
                    title: 'Logged out successfully'
                })
            }
            else
            {
                this.$router.push({name:'login'});
            }
        }
    }
</script>