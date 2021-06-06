<template>
   <div>
            <navbar/>

            <div class="card mx-auto bg-dark text-white" style="width: 80%;">
            <div class="card-body ">
                <h1 class="text-center">Registration Form</h1>
                <form @submit.prevent="register">
                    <div class="form-group">
                        <label >Username</label>
                        <input name="name" type="text" class="form-control" v-model="form.name"  aria-describedby="emailHelp" placeholder="Enter Name"/>
                        <small  class="form-text text-danger" v-if="errors.name" >{{errors.name[0]}}</small>
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input name="email" type="email" class="form-control" v-model="form.email"  aria-describedby="emailHelp" placeholder="Enter email"/>
                        <small  class="form-text text-danger" v-if="errors.email" >{{errors.email[0]}}</small>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input name="password" type="password" v-model="form.password" class="form-control"  placeholder="Password"/>
                        <small  class="form-text text-danger" v-if="errors.password" >{{errors.password[0]}}</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input name="password_confirmation " v-model="form.password_confirmation" type="password" class="form-control" placeholder="Confirm Password"/>
                        <small  class="form-text text-danger" v-if="errors.password" >{{errors.password[0]}}</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </form>
                <router-link class="text-center text-info" to="/login">Already A User? Login</router-link>
            </div>
            </div>

    </div>
</template>

<script>
    export default{
        
        data()
        {
            return{
                form:{
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null
                },
                errors:
                {

                }
                
            }
        },
        methods:{
            register()
            {
                axios.post('/api/auth/signup',this.form)
                .then(res => {
                    User.responseAfterLogin(res);
                    Toast.fire({
                        icon: 'success',
                        title: 'Registered Successfully'
                    })
                    this.$router.push({name:'dashboard'});   
                })
                .catch(error=>{
                    this.errors = error.response.data.errors;
                    Toast.fire({
                        icon: 'warning',
                        title: 'Failed Check Your Input!',
                    })
                })
            }
        }
    }

</script>

<style scoped>
</style>