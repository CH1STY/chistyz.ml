<template>
    <div>
        <div class="container-sm">
            <form v-if="!isHome"  @submit.prevent="getProduct()">     
                <div class="input-group mb-3 ">
                    <input v-model="searchText"  type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Enter Product to Search">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-info"  id="inputGroup-sizing-default">Search</button>
                    </div>
                </div>                            
            </form>
        </div>
        <div v-if="isProduct" class="gallery">
           
                <div v-for="product in products.data" :key="product.product_id" class="content">
                        <img :src="`/asset/products/${product.image}`">
                        <h4 class="text-truncate">{{product.name}}</h4>
                        <p>{{product.details}}  </p>
                        <h6>${{product.price}}</h6>
                        <ul>
                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                        </ul>
                        <button class="button buy-2">View Details</button>
                </div>
            
        </div>
            <h1 v-else class="text-center">No Product Found </h1>
        <div v-if="isHome" class="card-footer" style="display:flex;justify-content:center; margin:10px;">
            <router-link :to="{name:'productSearch', query:{q:''}}">View All</router-link>
        </div>
        <div v-else class="card-footer" style="display:flex;justify-content:center; margin:10px;">
            <pagination :data="products" @pagination-change-page="getProduct">
                               
            </pagination>
        </div>

    </div>
</template>

<script>
export default {
    created()
    {
        this.searchText = this.$route.query.q;
        this.getProduct();

    },
    props:['isHome'],
    data ()
    {
        return {
            products: {},
            isProduct : false,
            searchText: "",
            ppp :20,
        }

    },
    watch:{
        $route(query){
            this.searchText=query.query.q;
            this.getProduct();

        }
    },
    methods:{
        getProduct(page=1)
            {
                if(this.isHome)
                {
                    this.ppp = 10;
                }
                else
                {
                    
                }
                axios({
                    method: 'get',
                    url: `/api/admin/product?page=${page}&search=${this.searchText || ""}&ppp=${this.ppp}`,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
                    }
                })
                .then(res=>
                    {
                        this.products=res.data
                        if(this.products.data.length>0)
                        {
                            this.isProduct = true;
                        }
                    }
                )
            }    
    }
}

</script>

<style scoped>
    h4{
      text-align: center;
      font-size: 24px;
      margin: 0;
      padding-top: 10px;
      }
      a{
      text-decoration: none;
      }
      .gallery{
      display: flex;
      flex-wrap: wrap;
      width: 100%;
      justify-content: center;
      align-items: center;
      margin: 50px 0;
      }
      .content{
      width: 24%;
      margin: 15px;
      box-sizing: border-box;
      float: left;
      text-align: center;
      border-radius:10px;
      border-top-right-radius: 10px;
      border-bottom-right-radius: 10px;
      padding-top: 10px;
      box-shadow: 0 0 10px rgba(242, 232, 232, 0.1);
      transition: .4s;
      
      }
      .content:hover{
      box-shadow: 0 0 11px rgba(33,33,33,.2);
      transform: translate(0px, -8px);
      transition: .6s;
      }
      img{
      width: 200px;
      height: 200px;
      text-align: center;
      margin: 0 auto;
      display: block;
      }
      p{
      text-align: center;
      color: #b2bec3;
      padding: 0 8px;
      }
      h6{
      font-size: 26px;
      text-align: center;
      color: #38C172;
      margin: 0;
      }
      ul{
      list-style-type: none;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0px;
      }
      li{
      padding: 5px;
      }
      .fa{
      color: #ed9613;
      font-size: 26px;
      transition: .4s;
      }
      .fa:hover{
      transform: scale(1.3);
      transition: .6s;
      }
      .button{
      text-align: center;
      font-size: 24px;
      color: #fff;
      width: 100%;
      padding: 15px;
      border:0px;
      outline: none;
      cursor: pointer;
      margin-top: 5px;
      border-bottom-right-radius: 10px;
      border-bottom-left-radius: 10px;
      }
      .buy-1{
      background-color: #2183a2;
      }
      .buy-2{
      background-color: #3b3e6e;
      }
      .buy-3{
      background-color: #0b0b0b;
      }
      @media(max-width: 1000px){
      .content{
      width: 46%;
      }
      }
      @media(max-width: 750px){
      .content{
      width: 100%;
      }
      }
</style>