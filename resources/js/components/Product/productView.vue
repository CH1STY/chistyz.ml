<template>
    <div class="container-fluid ">
        <navbar></navbar>
        <div class="card mx-auto bg-dark text-white overflow-auto">
                    <div class="card-body">
                        <h4 class="text-center text-uppercase">product List</h4>
                        <p class="text-warning text-center">This is an non responsive page due to too much data issue!</p>
                        
                        <div class="card-header">
                            <form @submit.prevent="getProduct()">     
                                <div class="input-group mb-3 ">
                                    <input v-model="searchText"  type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Enter Product to Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info"  id="inputGroup-sizing-default">Search</button>
                                    </div>
                                </div>                            
                            </form>
                        </div>
                        <table class="table table-dark text-white">
                            <thead>
                                <tr>
                                <th>Product ID</th>
                                <th></th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Details</th>
                                <th>Categories</th>
                                <th v-if="isAdmin">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products.data" :key="product.product_id">
                                    <td>{{product.product_id}}</td>
                                    <td>
                                        <img :src="`/asset/products/v40x40${product.image}`" width="40px" height="40px" :alt="product.product_id">
                                    </td>
                                    <td>{{product.name}}</td>
                                    <td>{{product.price}}</td>
                                    <td>{{product.stock}}</td>
                                    <td :class="(product.status=='available')?'text-success':'text-warning'">{{product.status}}</td>
                                    <td>{{product.details}}</td>
                                    <td>
                                        <p style="display:inline" v-for="category in product.categories" :key="category.category_id">`{{category.name}}` </p>
                                    </td>
                                    <td v-if="isAdmin">
                                        <router-link :to="{ name: 'editProduct', params: {productId:`${product.product_id}`}  }">
                                        <button  class="btn btn-primary">EDIT</button> 
                                        </router-link>                                
                                        <button  class="btn btn-danger" v-on:click="deleteProduct(product.product_id)">DELETE</button>
                                    </td>                            
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer" style="display:flex;justify-content:center;">
                        <pagination :data="products" @pagination-change-page="getProduct">
                               
                        </pagination>
                    </div>
                </div>
    </div>
</template>

<script>
    export default{
        mounted()
        {
            this.getProduct();
            
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
        data()
        {
            return {
                products:{},
                isAdmin : false,
                searchText: " ",
            }
        },
        methods:
        {
            getProduct(page=1)
            {
                axios({
                    method: 'get',
                    url: `/api/admin/product?page=${page}&search=${this.searchText}`,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
                    }
                })
                .then(res=>
                    {
                        this.products=res.data
                    }
                )               
            },
            deleteProduct(product_id)
            {
                console.log(product_id);
                Swal.fire({
                title: `Are you Sure on Deleting Product with Id ${product_id} ?`,
                text: "This Action Can not be Reverted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    
                    axios({
                        method: 'delete',
                        url : `/api/admin/product/${product_id}`,
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')} `
                        }
                    })
                    .then(res=>
                    {
                        if(res.data=='deleted')
                        {
                            this.getProduct()
                            Swal.fire(
                            'Deleted!',
                            `Product with Product ID: ${product_id} deleted`,
                            'success'
                            )
                        }
                    })

                }
                })                            
            }
            
        }
    }
</script>