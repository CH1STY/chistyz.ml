<template>
    <div >
            <navbar></navbar>
            <div class="card mx-auto bg-dark text-white width-control" >
            <div class="card-body">
                <h1>Login </h1>
                <form @submit.prevent="login">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" autocomplete="email" class="form-control"  name="email" v-model="form.email"  placeholder="Enter email"/>
                        <small id="emailHelp" class="form-text text-danger" v-if="errors.email" >{{errors.email[0]}}</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" name="password">Password</label>
                        <input type="password" autocomplete="current-password"   v-model="form.password" class="form-control" placeholder="Password"/>
                        <small class="form-text text-danger" v-if="errors.password" >{{errors.password[0]}}</small>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1"/>
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                
                    <br/>
                <router-link class="text-center mt-5 text-danger " :to="{name:'forget_pass'}">Forget Your Password?</router-link>
                <br>
                <router-link class="text-center mt-5 text-info " to="register">Not A User?Click Here to SignUP</router-link>
            </div>
            </div>

    </div>
</template>

<script>

    export default{
        components:{
           
        },
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
                },
                errors:
                {

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
                .catch(error=>{
                    this.errors = error.response.data.errors;
                    Toast.fire({
                        icon: 'warning',
                        title: 'Invalid Email or Password',
                    })
                    window.console.clear();
                })
            },
            
        }

    }
</script>

<style scoped>
h1{
    text-transform: uppercase;
    text-align: center;
}

.width-control{
    width: 50%;
}

@media screen and (max-width: 600px) {
  .width-control {
    width: 75%;
  }
}


</style>