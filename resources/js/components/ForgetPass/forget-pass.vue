<template>
    <div class="container">
        <navbar></navbar>
        <h4 class="text-center text-uppercase text-info">PASSWORD FORGET</h4>
        <div class="card w-50 bg-dark m-auto">
            <div class="card-body ">
                
                <form v-if="notSubmitted" @submit.prevent="submit">
                    <div class="form-group">
                        <label >Email address</label>
                        <input v-model="form.email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <small v-if="errors.email" id="emailHelp" class="form-text text-danger">{{errors.email[0]}}</small>
                    </div>
                    <div class="col-md-12 text-center">
                        <button v-if="!pressed"  type="submit" class="text-center float-center btn btn-primary">REQUEST RESET</button>               
                    </div>
                </form>
                <div v-else>
                    <h4 class="text-success text-center">Reset Link Sent to "{{form.email}}" Please Check Your Email</h4>
                </div>
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
        data()
        {
            return{
                form:{
                    email: "",
                },
                errors:{},
                notSubmitted: true,
                pressed:false,
            }
        },
        methods:{
            submit()
            {
                this.pressed=true;
                axios.post('/api/password-reset',this.form)
                .then(res => {
                    if(res.data=="Success")
                    {
                        Toast.fire({
                            icon: 'success',
                            title: 'Reset Link Sent'
                        })
                        this.notSubmitted = false;
                        this.pressed = false;
                    }
                    else if(res.data=='wait')
                    {
                        Toast.fire({
                            icon: 'warning',
                            title: 'Wait Before Another Request'
                        })
                        this.pressed = false;
                    }
                       
                })
                .catch(error=>{
                    this.errors = error.response.data.errors;
                    Toast.fire({
                        icon: 'warning',
                        title: 'Invalid Email',
                    })
                    this.pressed = false;

                })               
            }
        }
    }

</script>

<style scoped>

</style>