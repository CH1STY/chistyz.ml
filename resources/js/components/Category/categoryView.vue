<template>
    <div class="container-fluid ">
        <navbar></navbar>
        <div class="card mx-auto bg-dark text-white overflow-auto">
                    <div class="card-body">
                        <h4 class="text-center">Category List</h4>
                        <table class="table table-dark text-white">
                            <thead>
                                <tr>
                                <th>Category ID</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th v-if="isAdmin">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="category in categories.data" :key="category.category_id">
                                    <td>{{category.category_id}}</td>
                                    <td>{{category.name}}</td>
                                    <td>{{category.details}}</td>
                                    <td v-if="isAdmin">
                                        <router-link :to="{ name: 'editCat', params: {catId:`${category.category_id}`}  }">
                                        <button  class="btn btn-primary">EDIT</button> 
                                        </router-link>                                
                                        <button  class="btn btn-danger" v-on:click="deleteCat(category.category_id)">DELETE</button>
                                    </td>                            
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="categories" @pagination-change-page="getCat">
                               
                        </pagination>
                    </div>
                </div>
    </div>
</template>

<script>
    export default{
        mounted()
        {
            this.getCat();
            
            User.isAdmin().
            then(res=>this.isAdmin=res)
        },
        beforeCreate()
        {
            if(!User.loggedIn())
            {
                this.$router.push({name:'login'});
            }
        },
        data(){
            return{
                categories:{},
                isAdmin:false,
            }
        },
        methods:
        {
            getCat(page=1)
            {
                axios({
                    method: 'get',
                    url: `/api/admin/getCat?page=${page}`,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
                    }
                })
                .then(res=>this.categories=res.data)
            },
            deleteCat(category_id)
            {
                Swal.fire({
                title: `Are you Sure on Deleting Category with Id ${category_id} ?`,
                text: "All Products Related to this Category will also be deleted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    
                    axios({
                        method: 'get',
                        url : `/api/admin/deleteCat/${category_id}`,
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')} `
                        }
                    })
                    .then(res=>
                    {
                        this.getCat()
                    })

                    Swal.fire(
                    'Deleted!',
                    `Category with Category ID: ${category_id} deleted`,
                    'success'
                    )
                }
                })             
                
            }
        }
    }
</script>

<style scoped>
.table{
    table-layout:fixed;
}
.pagination{
    justify-content: center;
}
</style>