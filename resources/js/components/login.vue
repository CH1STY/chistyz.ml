<template>
    <div >
            <div class="card mx-auto" style="width: 80%;">
            <div class="card-body">
                <h1>Login Form</h1>
                <form @submit.prevent="login">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control"  name="email" v-model="form.email"  placeholder="Enter email"/>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" name="password">Password</label>
                        <input type="password"   v-model="form.password" class="form-control" placeholder="Password"/>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"/>
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <router-link class="text-center text-info" to="register">Not A User?Click Here to SignUP</router-link>
            </div>
            </div>

    </div>
</template>

<script>
    export default{
        
        beforeCreate()
        {
            if(User.loggedIn())
            {
                this.$router.push({name:'dashboard'});
            }
        },
        data(){
            return {
                form:{
                    email: null,
                    password: null,
                }
            }
        },
        methods:{
            login(){
                axios.post('/api/auth/login',this.form)
                .then(res => {
                    User.responseAfterLogin(res);
                    Toast.fire({
                        icon: 'success',
                        title: 'Logged In Successfully'
                    })
                    this.$router.push({name:'dashboard'});   
                })
                .catch(error=> {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Invalid Email or Password'
                    })
                })
            }
        }

    }
</script>

<style scoped>
h1{
    text-transform: uppercase;
    text-align: center;
}
</style>