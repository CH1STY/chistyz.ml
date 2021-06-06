<template>
    <div>
        <navbar></navbar>
        <h4 v-if="!isFailed" class="text-center text-uppercase">EDIT CATEGORY {{catId}} </h4>
        <div v-if="!isFailed" class="row" style="margin:auto; width:60%;">
            <div class="col-sm">
                <div class="card mx-auto bg-dark text-white">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                                    <div class="form-group">
                                        <label >Category Name</label>
                                        <input type="text"  class="form-control"  name="name" v-model="form.name"  placeholder="Enter Category Name"/>
                                        <small class="form-text text-danger" v-if="errors.name" >{{errors.name[0]}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label >Category Details</label>
                                        <input type="text"  class="form-control"  name="details" v-model="form.details"  placeholder="Enter Category Details"/>
                                        <small  class="form-text text-danger" v-if="errors.details" >{{errors.details[0]}}</small>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <router-link :to="{name:'viewCat'}" class="btn btn-secondary float-right">Go Back</router-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <h4 v-else class="text-danger text-center text-uppercase">Invalid Category Id</h4> 
    </div>
</template>

<script>
    export default{
        mounted()
        {   
            this.getCatDetails();
        }
        ,
        beforeCreate()
        {
            //USER IS ADMIN OR NOT VALIDATION
            User.isAdmin()
            .then(res=>{
                if(!res)
                {
                    this.$router.push({name:'login'});
                }
            });
            //--------------
        },
        data(){
            return {
                form:{
                    name: null,
                    details: null,
                },
                prevName:null,
                prevDetails:null,
                errors:
                {

                },
                catId :this.$route.params.catId,
                isFailed:false,
            }
        },
        methods:{
            getCatId()
            {
               this.catId =this.$route.params.catId;
            },
            getCatDetails()
            {
                axios({
                    method: 'get',
                    url: `/api/admin/editCat/${this.$route.params.catId}`,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
                    }
                })
                .then(res=>
                {
                    if(res.data!='failed')
                    {
                        this.form.name = this.prevName =res.data.name;
                        this.form.details = this.prevDetails =res.data.details;
                    }
                    else
                    {
                        this.isFailed = true;
                    }
                }) 
            },
            submit()
            {
                if(this.prevName == this.form.name && this.prevDetails == this.form.details)
                {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Nothing to Change'
                    })                    
                }
                else
                {
                    axios({
                        method: 'post',
                        url: `/api/admin/editCat/${this.$route.params.catId}`,
                        data: this.form,
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')} `
                        }
                    })
                    .then(res => {
                        if(res.data=='Success')
                        {
                            Toast.fire({
                                icon: 'success',
                                title: `Category ${this.form.name} Updated Successfully`
                            })

                            this.$router.push({name:'viewCat'});
                            
                        }
                        else
                        {
                            Toast.fire({
                                icon: 'warning',
                                title: 'Invalid Entry or Access',
                            })
                            
                        } 
                    })
                    .catch(error=>{
                        this.errors = error.response.data.errors;
                        Toast.fire({
                            icon: 'warning',
                            title: 'Invalid',
                        })

                      
                    })                    
                }
            }
        },
        watch:{
            $route: 'getCatId'
        }
    }
</script>


<style scoped>

</style>