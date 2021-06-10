<template>
    <div class="container-fluid ">
        <navbar/>
        <h1 class="text-center h3 m-2">Add Product</h1>

        <div v-if="isAdmin" class="row ">
            <div class="col-sm">
                <form enctype="multipart/form-data" @submit.prevent="submit">
                            <div class="form-group">
                                <label >Product Name</label>
                                <input type="text"  class="form-control"  name="name" v-model="form.name"  placeholder="Enter Product Name"/>
                                <small class="form-text text-danger" v-if="errors.name" >{{errors.name[0]}}</small>
                            </div>
                            <div class="form-group">
                                <label >Product Details</label>
                                <textarea v-model="form.details" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                <small  class="form-text text-danger" v-if="errors.details" >{{errors.details[0]}}</small>
                            </div>
                            <div class="form-group">
                                <label >Price</label>
                                <input type="number" min="0"  class="form-control"  name="price" v-model="form.price"  placeholder="Enter Product Price"/>
                                <small class="form-text text-danger" v-if="errors.price" >{{errors.price[0]}}</small>
                            </div>
                            <div class="form-group">
                                <label >Initial Stock</label>
                                <input type="number" min="0"  class="form-control"  name="stock" v-model="form.stock"  placeholder="Enter Initial Stock"/>
                                <small class="form-text text-danger" v-if="errors.stock" >{{errors.stock[0]}}</small>
                            </div>
                           
                            
                            
                            <div class="row-auto">
                                <div class="card mx-auto bg-dark text-white overflow-auto">
                                    <div class="card-body">
                                        <div class="card-header"><h5 class="text-center text-uppercase">Select Categories (Min:1 Max:3)</h5></div>
                                        <div style="display:inline;" v-for="category in categories"  :key="category.category_id" class="col-lg-6 form-check marginBottom">
                                        
                                                <input class="form-check-input" type="checkbox"  :value="category.category_id" v-model="form.categories">
                                                <label class="form-check-label" >{{category.name}}</label>
                                        
                                        </div>
                                        <div v-if="errors.categories" class="card-footer">
                                            <p class="text-danger">{{errors.categories[0]}}</p>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="form-group imageBox">
                                <label for="exampleFormControlFile1">Insert Product Photo</label>
                                <input ref="fileupload" type="file" accept="image/*" @change="changeImage($event)" class="form-control-file">
                                <small class="form-text text-danger" v-if="errors.image" >{{errors.image[0]}}</small>
                            </div>                           
                            <div class="m-10" style="display:flex;justify-content:center; margin-bottom:10px">
                                <button v-if="!isRequested" type="submit" class="btn btn-primary">Add Product</button>
                                <div v-if="isRequested" class="loader"></div>
                            </div>
                </form>  
            </div>
            <div class="col-sm">
                <div class="card mx-auto bg-dark text-white overflow-auto" style="min-height:30rem;">
                    <div class="card-body">
                        <h4 class="text-center">Product List <router-link class="h6 float-right" to="/admin/viewProduct">Click Here to Manage Product</router-link> </h4>
                        <table class="table bg-dark text-white">
                            <thead>
                                <tr>
                                <th scope="col">Product ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products.data" :key="product.product_id">
                                    <td>{{product.product_id}}</td>
                                    <td>{{product.name}}</td>
                                    <td>{{product.price}}</td>                                
                                    <td>{{product.stock}}</td>                                
                                </tr>
                            </tbody>
                        </table>
                        <div class="card-footer text-center">
                            <pagination :data="products" @pagination-change-page="getProduct">
                               
                            </pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </div>
</template>

<script>
    export default {
        created()
        {
            this.getProduct();
            this.fetchCat();
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
                else
                {
                    this.isAdmin = true;
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
                    name: "",
                    details: "",
                    price: "",
                    stock: "",
                    categories :[],
                    image: "",
                   
                },
                errors:
                {

                },
                products:{},
                categories : {},
                isRequested: false,
                isAdmin : false,
            }
        },
        methods:{
            submit()
            {
                this.isRequested = true;
                let formData = new FormData();
                formData.append('name',this.form.name);
                formData.append('details',this.form.details);
                formData.append('price',this.form.price);
                formData.append('stock',this.form.stock);
                formData.append('image',this.form.image);
                for (let i=0;i<this.form.categories.length;i++)
                {
                    formData.append('categories[]',this.form.categories[i]);
                }
                axios({
                    method: 'post',
                    url: '/api/admin/product',
                    data: formData,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `,
                        
                    }
                })
                .then(res => {
                    if(res.data=='Success')
                    {
                        Toast.fire({
                            icon: 'success',
                            title: `Product ${this.form.name} Added Successfully`
                        })

                        this.$refs.fileupload.value=null
                        this.form.name ="";
                        this.form.details = "";
                        this.form.price = "";
                        this.form.stock = "";
                        this.form.categories= [];
                        this.errors = {};
                        this.form.image = "";
                        this.$refs.fileupload.value=null;
                        this.getProduct();
                    }
                    else
                    {
                        Toast.fire({
                            icon: 'warning',
                            title: 'Invalid Request',
                        })
                    } 
                    this.isRequested = false;
                })
                .catch(error=>{
                    this.errors = error.response.data.errors;
                    Toast.fire({
                        icon: 'warning',
                        title: 'Invalid Input',
                    })
                    this.isRequested = false;
                })
                
            },
            getProduct(page = 1)
            {
                axios({
                    method: 'get',
                    url: `/api/admin/product?page=${page}`,
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
            fetchCat()
            {
                axios({
                    method: 'get',
                    url: `/api/admin/category/fetchCat`,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
                    }
                })
                .then(res=>
                    {
                        this.categories = res.data;
                    }
                )
            },
            changeImage(event)
            {
                this.form.image = event.target.files[0];
                 
                
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

.marginBottom{
    margin-bottom: 10px;
    margin-right: 4px;
}
.btn{
    margin-top:20px;
}

.imageBox{
    margin: 10px;
}



</style>

<style>
.loader {
    border: 5px solid #f3f3f3;
    -webkit-animation: spin 1s linear infinite;
    animation: spin 1s linear infinite;
    border-top: 5px solid #555;
    border-radius: 50%;
    width: 50px;
    height: 50px;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>