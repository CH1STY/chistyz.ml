<template>
    <div class="container">
        <navbar></navbar>
        <h4 class="text-center text-uppercase text-info">PASSWORD RESET</h4>
        <div v-if="!expired">
            <p v-if="tokenValid" class="text-warning text-center">For User with Email : {{this.email}}</p>
            <div class="card w-50 bg-dark m-auto">
                <div class="card-body ">
                    
                    <form v-if="tokenValid" @submit.prevent="submit">
                        <div class="form-group">
                            <label >Password</label>
                            <input v-model="form.password" type="password" class="form-control"  placeholder="Enter New Password">
                            <small v-if="errors.password" id="emailHelp" class="form-text text-danger">{{errors.password[0]}}</small>
                        </div>
                        <div>
                            <label >Confirm Password</label>
                            <input v-model="form.password_confirmation" type="password" class="form-control"  placeholder="Confirm Password">
                            <small v-if="errors.password" id="emailHelp" class="form-text text-danger">{{errors.password[0]}}</small>
                        </div>
                        <div class="col-md-12 text-center">
                            <button  type="submit" class=" mt-5 text-center float-center btn btn-primary">CONFIRM</button>               
                        </div>
                    </form>
                    <div v-else class="text-center text-danger">
                        <h1>Invalid Request!</h1>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <h1 class="text-center text-danger text-uppercase">Token Expired!</h1>
        </div>
    </div>
</template>

<script>
    export default{
        created()
        {
            this.isTokenValid();
        },
        beforeCreate()
        {
            if(User.loggedIn())
            {
                this.$router.push({name:'dashboard'});
            }
            
        },
        data()
        {
            return{
                form:{
                    password: "",
                    password_confirmation: "",
                    token: this.$route.params.token,
                },
                errors:{},
                tokenValid : false,
                email: "",
                expired : false,
                
            }
        },
        methods:{
            isTokenValid()
            {
                axios.get(`/api/token-validation/${this.form.token}`)
                .then(res => {
                    
                    if(res.data.valid)
                    {
                       this.tokenValid = true;
                       this.email = res.data.email;
                    } 
                    else if(res.data=='expired')
                    {
                        this.expired = true;
                    } 
                    else
                    {
                        this.tokenValid = false;
                    }   
                })
                .catch(error=>{
                    this.tokenValid = false;
                })               
            
            }
            ,
            submit()
            {
                axios.post('/api/password-reset/confirm',this.form)
                .then(res => {
                    if(res.data=="Success")
                    {
                        Swal.fire(
                        'Password Resetted!',
                        `For Mail Id: ${this.email} try logging in`,
                        'success'
                        )
                        this.$router.push({name:'login'});
                        
                                                
                    } 
                })
                .catch(error=>{
                    this.errors = error.response.data.errors;
                    Toast.fire({
                        icon: 'warning',
                        title: 'Invalid Password',
                    })
                })               
            }
        }
    }

</script>

<style scoped>

</style>