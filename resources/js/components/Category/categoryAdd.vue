<template>
    <div class="container-fluid ">
        <navbar/>
        <h1 class="text-center h3 m-2">ADD CATEGORY</h1>

        <div class="row ">
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
                                
                                    <button v-if="!isRequested" type="submit" class="btn btn-primary">Add</button>
                                    <div v-if="isRequested" class="loader"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card mx-auto bg-dark text-white overflow-auto" style="min-height:30rem;">
                    <div class="card-body">
                        <h4 class="text-center">Category List <router-link class="h6 float-right" to="/admin/viewCat">Click Here to Manage Category</router-link> </h4>
                        <table class="table bg-dark text-white">
                            <thead>
                                <tr>
                                <th scope="col">Category ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="category in categories.data" :key="category.category_id">
                                    <td>{{category.category_id}}</td>
                                    <td>{{category.name}}</td>
                                    <td>{{category.details}}</td>                                
                                </tr>
                            </tbody>
                        </table>
                        <div class="card-footer text-center">
                            <pagination :data="categories" @pagination-change-page="getCat">
                               
                            </pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created()
        {
            this.getCat();
        },
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
            if(!User.loggedIn())
            {
                this.$router.push({name:'login'});
            }
            

            
            
        }
        ,
        data(){
            return {
                form:{
                    name: null,
                    details: null,
                },
                errors:
                {

                },
                categories:{},
                isRequested :false,
            }
        },
        methods:{
            submit()
            {
                this.isRequested = true;
                axios({
                    method: 'post',
                    url: '/api/admin/addCat',
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
                            title: `Category ${this.form.name} Added Successfully`
                        })

                        this.form.name =null;
                        this.form.details = null;
                        this.errors = {};
                        this.getCat();
                    }
                    else
                    {
                        Toast.fire({
                            icon: 'warning',
                            title: 'Invalid Entry or Access',
                        })
                    }
                    this.isRequested = false;

                })
                .catch(error=>{
                    this.errors = error.response.data.errors;
                    Toast.fire({
                        icon: 'warning',
                        title: 'Invalid Entry or Access',
                    })
                    this.isRequested = false;
                })
            },
            getCat(page = 1)
            {
                axios({
                    method: 'get',
                    url: `/api/admin/getCat?page=${page}`,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
                    }
                })
                .then(res=>
                    {
                        this.categories=res.data
                    }
                )
            }
        }
    }
</script>

<style scoped>
.pagination{
    justify-content: center;
}

.card {
    max-height: 19rem;
}

.col-sm{
    margin-bottom: 10px;
}
</style>