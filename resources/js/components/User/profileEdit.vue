<template>
<div>
    <navbar/>
        <div style="margin:auto;" class="width-control">   
            <div class="card mx-auto bg-dark text-white">
                <div class="card-body">
                <form enctype="multipart/form-data" @submit.prevent="submit">
                        <div class="form-group">
                            <label >Full Name</label>
                            <input type="text"  class="form-control" v-model="form.fullname" placeholder="Enter Full Name"/>
                            <small class="form-text text-danger" v-if="errors.fullname" >{{errors.fullname[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label >Phone</label>
                            <input type="number"  class="form-control" placeholder="Enter Phone Number"  v-model="form.phone"/>
                            <small class="form-text text-danger" v-if="errors.phone" >{{errors.phone[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label >Website</label>
                            <input type="text"  class="form-control" placeholder="Enter Your Website"  v-model="form.website"/>
                            <small class="form-text text-danger" v-if="errors.website" >{{errors.website[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label >Github</label>
                            <input type="text"  class="form-control" placeholder="Enter Gitgub Link"  v-model="form.github"/>
                            <small class="form-text text-danger" v-if="errors.github" >{{errors.github[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label >Twitter</label>
                            <input type="text"  class="form-control" placeholder="Enter Twitter Link"  v-model="form.twitter"/>
                            <small class="form-text text-danger" v-if="errors.twitter" >{{errors.twitter[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label >Instagram</label>
                            <input type="text"  class="form-control" placeholder="Enter Instagram Link" v-model="form.instagram"/>
                            <small class="form-text text-danger" v-if="errors.instagram" >{{errors.instagram[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label >Facebook</label>
                            <input type="text"  class="form-control" placeholder="Enter Facebook Link"  v-model="form.facebook"/>
                            <small class="form-text text-danger" v-if="errors.facebook" >{{errors.facebook[0]}}</small>
                        </div>
                        
                        <button v-if="!isRequested" type="submit" class="btn btn-primary">Update</button>
                        <div v-if="isRequested" class="loader"></div>
                        <router-link :to="{name:'viewProduct'}" class="btn btn-secondary float-right">Go Back</router-link>
                </form>                        
                </div>
            </div>
        </div>
</div>
</template>

<script>
export default {
    mounted()
    {
        this.getUserDetails();
    },
    data()
    {
        return {
            form:{
                fullname:"",
                phone:"",
                website:"",
                github:"",
                twitter:"",
                instagram:"",
                facebook:"",
            },
            errors:{},
            preVfullname:"",
            preVphone:"",
            preVwebsite:"",
            preVgithub:"",
            preVtwitter:"",
            preVinstagram:"",
            preVfacebook:"",
            isRequested: false,
        }
    },
    methods:{
        getUserDetails()
        {
            axios({
              method: 'get',
              url: `/api/user/getUserDetails`,
              headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
              }
            })
            .then(res=>{
              this.preVfullname=this.form.fullname = res.data.userdetails.fullname;
              this.preVphone=this.form.phone = res.data.userdetails.phone;
              this.preVwebsite=this.form.website = res.data.userdetails.website;
              this.preVgithub=this.form.github = res.data.userdetails.github;
              this.preVtwitter=this.form.twitter = res.data.userdetails.twitter;
              this.preVinstagram=this.form.instagram = res.data.userdetails.instagram;
              this.preVfacebook=this.form.facebook = res.data.userdetails.facebook;
            
              
            })
        },
        submit()
        {
            this.isRequested =true;
            if(
                this.preVfullname == this.form.fullname &&
                this.preVphone == this.form.phone &&
                this.preVwebsite == this.form.website &&
                this.preVgithub == this.form.github &&
                this.preVtwitter == this.form.twitter &&
                this.preVinstagram == this.form.instagram &&
                this.preVfacebook == this.form.facebook
            )
            {
                Toast.fire({
                        icon: 'warning',
                        title: 'Nothing to Change'
                }) 
                this.isRequested =false;

            }
            else
            {
                axios({
                    method: 'post',
                    url: `/api/user/updateProfile`,
                    data: this.form,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `,
                    }
                })
                .then(res=>{
                    if(res.data=="Success")
                    {
                        Toast.fire({
                                icon: 'success',
                                title: `Profile Updated Successfully`
                        })
                        this.isRequested =false;

                        this.$router.push({name:'dashboard'});
                    }
                })
                .catch(errors=>
                {
                    this.errors= errors.response.data.errors;
                    this.isRequested =false;

                })
            }
        }
    }
}
</script>

<style scoped>

    .width-control{
        width: 60%;
    }
    input{
        font-weight: bold;
    }

    @media screen and (max-width: 700px) {
        .width-control{
            width: 80%;
        }
    }

</style>