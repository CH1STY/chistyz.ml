<template>
    <div>
        <div class="card-header mt-20"> <h1>More Products</h1> </div>
        <div v-if="isProduct" class="gallery">
                <div v-for="product in products" :key="product.product_id" class="content">
                    <productCard :image=product.image :name=product.name :price=product.price :product_id=product.product_id />
                </div>
        </div>
    </div>
</template>

<script>
import productSingle from './productSingle.vue';
export default {
    components:{
        productCard : productSingle,
    },
    beforeMount()
    {
        this.getProduct();

    },
    data()
    {
      return{
          products : {},
          isProduct : false,
      }
    },
    methods:{
        getProduct()
        {
               axios({
                    method: 'get',
                    url: `/api/random-product/${this.$route.params.productId}`,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
                    }
                })
                .then(res=>
                    {
                        this.products=res.data
                     
                        if(this.products.length>0)
                        {
                            this.isProduct = true;
                        }
                    }
                )
        }
    },


         
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