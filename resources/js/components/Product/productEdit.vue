<template>
    <div class="container-fluid ">
        <navbar></navbar>
        <h4 v-if="!isFailed" class="text-center text-uppercase">EDIT PRODUCT ID: {{productId}} </h4>
        <div v-if="!isFailed"  style="margin:auto; width:80%;">   
            <div class="card mx-auto bg-dark text-white">
                <div class="card-body">
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
                            <label >Stock</label>
                            <input type="number" min="0"  class="form-control"  name="stock" v-model="form.stock"  placeholder="Enter Initial Stock"/>
                            <small class="form-text text-danger" v-if="errors.stock" >{{errors.stock[0]}}</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Status</label>
                            <select class="form-control" v-model="form.status" aria-label="Default select example">
                            <option >Open this select menu</option>
                            <option value="coming_soon">Coming Soon</option>
                            <option value="available">Available </option>
                            <option value="out of stock">Out Of Stock</option>
                            <option value="pre-order">Preorder</option>
                            </select>
                            <small class="form-text text-danger" v-if="errors.status" >{{errors.status[0]}}</small>
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
                            <img style="display:block; margin:10px 0; width:80px; height: 80px; border:1px solid white;" :src="imageData" />
                            <input ref="fileupload" type="file" accept="image/*" @change="changeImage($event)" class="form-control-file">
                            <small class="form-text text-danger" v-if="errors.image" >{{errors.image[0]}}</small>
                        </div>                           
                        <div class="m-10" style="display:flex;justify-content:center; margin-bottom:10px">
                            <button v-if="!isRequested" type="submit" class="btn btn-primary">Update</button>
                            <div v-if="isRequested" class="loader"></div>
                        </div>
                            <router-link :to="{name:'viewProduct'}" class="btn btn-secondary float-right">Go Back</router-link>
                </form>                        
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
            this.getProductDetails();
            this.fetchCat();
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
            if(!User.loggedIn())
            {
                this.$router.push({name:'login'});
            }
        },
        data(){
            return {
                form:{
                    name: "",
                    details: "",
                    price:"",
                    stock:"",
                    status:"",
                    image:"",
                    categories:[],
                },
                prevName:null,
                prevDetails:null,
                prevStatus:null,
                prevPrice:null,
                prevStock:null,
                prevCategories:null,
                prevImage:null,
                imageData:null,
                errors:
                {

                },
                productId :this.$route.params.productId,
                isFailed:false,
                categories:{},
                isRequested:false,
            }
        },
        methods:{
            getProductId()
            {
               this.productId =this.$route.params.productId;
            },
            getProductDetails()
            {
                axios({
                    method: 'get',
                    url: `/api/admin/product/${this.$route.params.productId}`,
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
                        this.form.status = this.prevStatus =res.data.status;
                        this.form.stock = this.prevStock =res.data.stock;
                        this.form.price = this.prevPrice =res.data.price;
                        this.form.image = this.prevImage =res.data.image;
                        this.imageData = `/asset/products/v200x200${this.form.image}`;
                        //this.form.categories = this.prevCategories =res.data.categories;
                        for(let i=0;i<res.data.categories.length;i++)
                        {
                            this.form.categories.push(res.data.categories[i].category_id);
                        }
                        this.prevCategories = this.form.categories;

                    }
                    else
                    {
                        this.isFailed = true;
                    }
                }) 
            },
            submit()
            {
                this.isRequested = true;
                let condition = (
                                    this.prevName == this.form.name && 
                                    this.prevDetails == this.form.details &&
                                    this.prevStatus == this.form.status &&
                                    this.prevPrice == this.form.price &&
                                    this.prevStock == this.form.stock &&
                                    this.prevCategories == this.form.categories &&
                                    this.prevImage == this.form.image
                                );
                if(condition)
                {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Nothing to Change'
                    }) 
                    this.isRequested = false;
                             
                }
                else
                {
                    let newFormData = new FormData();
                    newFormData.append('name',this.form.name);
                    newFormData.append('details',this.form.details);
                    newFormData.append('price',this.form.price);
                    newFormData.append('stock',this.form.stock);
                    if(this.prevImage!=this.form.image)
                    {
                        newFormData.append('image',this.form.image);
                    }
                    newFormData.append('status',this.form.status);
                    for (let i=0;i<this.form.categories.length;i++)
                    {
                        newFormData.append('categories[]',this.form.categories[i]);
                    }
                    newFormData.append('_method','PATCH');
                    axios({
                        method: 'post',
                        url: `/api/admin/product/${this.$route.params.productId}`,
                        data: newFormData,
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')} `,
                            'Content-Type': 'application/x-www-form-urlencoded',

                        }
                    })
                    .then(res => {
                        if(res.data=='Success')
                        {
                            Toast.fire({
                                icon: 'success',
                                title: `Product ${this.form.name} Updated Successfully`
                            })

                            this.$router.push({name:'viewProduct'});
                            
                        }
                        else if(res.data.errors.name[0]=="The name has already been taken.")
                        {
                            this.errors = res.data.errors;
                            Toast.fire({
                                icon: 'warning',
                                title: 'Invalid Entry or Access',
                            })
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
                            title: 'Invalid',
                        })

                        this.isRequested = false;
                    })                    
                }
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
                let reader = new FileReader();
                reader.onload = event =>{
                    this.imageData = event.target.result;
                };
                reader.readAsDataURL(this.form.image);
            }
        },
        watch:{
            $route: 'getProductId'
        }
    }
</script>


<style scoped>

</style>