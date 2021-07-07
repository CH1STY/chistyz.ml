<template>
    <div class="container-fluid">
		<div class="card bg-dark text-white">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						
						<div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1"><img height="350px" :src='product.imageData' /></div>
						</div>
						
						
					</div>
					<div class="details col-md-6">
						<h3 class="product-title">{{product.name}}</h3>
						<div class="rating">
							<div class="stars">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
							</div>
							<span class="review-no">{{product.numReviews}} reviews</span>
						</div>
						<p class="product-description">{{product.details}}</p>
						<h4 class="price">current price: <span>{{product.price}} BDT</span></h4>
						<p class="vote"><strong>{{Math.floor(Math.random()*15) + 80}}%</strong> of buyers enjoyed this product! <strong>( {{Math.floor((Math.random()*20)+15)}} votes)</strong></p>
						<h5 class="category_list">Categories:
              <span v-for="category in product.categories" :key="category"> 
                <router-link :to="{name:'productSearch', query:{q:`${category}`}}">
                  {{category}}
                </router-link>
              </span>
            </h5>
            <div class="action">
							<button v-on:click="changeVis"  class="add-to-cart mt-2 btn btn-default" type="button">Add to cart</button>
							<button v-on:click="removeFromCart" v-if="inCart"  class="add-to-cart btn btn-default remove mt-2 mr-2" type="button">Remove From Cart</button>
              <router-link to='/cart'>
							  <button v-if="inCart" class="add-to-cart btn btn-default bg-diff mt-2 mr-2px" type="button">Go to cart</button>

              </router-link>
              
						</div>
          
					
           
						
					</div>
				</div>
			</div>
		</div>
    <pRandom :key=$route.params.productId />

	</div>
</template>

<script>
import productRandom from './productRandom.vue';

export default {
  components:{
        pRandom : productRandom,
  },
    beforeMount(){
        this.getDetails();
    },
    data(){
      return {
        pid :this.$route.params.productId,
        product:{
          product_id : '',
          name : '',
          details : '',
          status  : '',  
          stock : '',    
          price   : '',
          image  : '',
          categories : [],
          imageData : '',
          numReviews : Math.floor(Math.random() * 100) + 23,
        },
        inCart: false,
        
      }
        
    },
    methods:{
        checkIfIncart()
        {
          try {
            let x = {}
            x = JSON.parse(localStorage.getItem('cart'));
            if(x[this.product.product_id] != null)
            {
              this.inCart = true;
            }
            else
            {
              this.inCart = false;
            }
            
          } catch (error) {
            this.inCart = false;
          }
           
         
           
          
        },

        removeFromCart()
        {
          Toast.fire({
                          icon: 'error',
                          title: `Product "${this.product.name}" removed from cart`
                      }) 
          this.$emit('removeFromCart',this.product.product_id);
          this.inCart = false;
        },
        changeVis()
        {
          if(!this.inCart)
          {
            Toast.fire({
                          icon: 'success',
                          title: `Product ${this.product.name} added to cart`
                      }) 
            this.inCart = true;

          }
          else if(this.inCart)
          {
            Toast.fire({
                          icon: 'success',
                          title: `Product "${this.product.name}" quantity Increased in cart`
                      }) 
          }
          this.$emit('addThisToCart',this.product.product_id);
        },
        getDetails()
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
                        this.product.product_id      =  res.data.product_id;
                        this.product.name            =  res.data.name;
                        this.product.details         =  res.data.details;
                        this.product.status          =  res.data.status;
                        this.product.stock           =  res.data.stock;
                        this.product.price           =  res.data.price;
                        this.product.image           =  res.data.image;
                        this.product.imageData       = `/asset/products/${this.product.image}`;
                        //this.form.categories = this.prevCategories =res.data.categories;
                        for(let i=0;i<res.data.categories.length;i++)
                        {
                            this.product.categories.push(res.data.categories[i].name);
                        }
                      
                      this.checkIfIncart();

                    }
                    else
                    {
                        this.isFailed = true;
                    }
                })            
        }
    },


}
</script>

<style scoped>

.remove
{
  background: red !important;
}

.category_list span:not(:last-child)::after{
  content: " , ";
}

/*****************globals*************/
body {
  overflow-x: hidden; }

img {
  max-width: 100%; }

.bg-diff{
  background: transparent !important;
  border: 2px solid snow !important;
}

.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }
  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px; } }

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 15px; }
  .preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%; }
    .preview-thumbnail.nav-tabs li img {
      max-width: 100%;
      display: block; }
    .preview-thumbnail.nav-tabs li a {
      padding: 0;
      margin: 0; }
    .preview-thumbnail.nav-tabs li:last-of-type {
      margin-right: 0; }

.tab-content {
  overflow: hidden; }
  .tab-content img {
    width: 100%;
    -webkit-animation-name: opacity;
            animation-name: opacity;
    -webkit-animation-duration: .3s;
            animation-duration: .3s; }

.card {
  margin-top: 50px;
  background: #eee;
  padding: 3em;
  line-height: 1.5em; }

@media screen and (min-width: 997px) {
  .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex; } }

.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }

.colors {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.product-title, .price, .sizes, .colors {
  text-transform: UPPERCASE;
  font-weight: bold; }

.checked, .price span {
  color: #ff9f1a; }

.product-title, .rating, .product-description, .price, .vote, .sizes {
  margin-bottom: 15px; }

.product-title {
  margin-top: 0; }

.size {
  margin-right: 10px; }
  .size:first-of-type {
    margin-left: 40px; }

.color {
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;
  height: 2em;
  width: 2em;
  border-radius: 2px; }
  .color:first-of-type {
    margin-left: 20px; }

.add-to-cart, .like {
  background: #ff9f1a;
  padding: 1.2em 1.5em;
  border: none;
  text-transform: UPPERCASE;
  font-weight: bold;
  color: #fff;
  -webkit-transition: background .3s ease;
          transition: background .3s ease; }
  .add-to-cart:hover, .like:hover {
    background: #b36800;
    color: #fff; }

.not-available {
  text-align: center;
  line-height: 2em; }
  .not-available:before {
    content: "\f00d";
    color: #fff; }

.orange {
  background: #ff9f1a; }

.green {
  background: #85ad00; }

.blue {
  background: #0076ad; }

.tooltip-inner {
  padding: 1.3em; }

@-webkit-keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

@keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

</style>