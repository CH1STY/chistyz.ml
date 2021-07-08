<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <router-link   class="navbar-brand" to="/">CMS</router-link>
            <button class="navbar-toggler" type="button"  v-on:click="toggleOutCartVis()" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <router-link class="nav-link" to="/">Home <span class="sr-only">(current)</span></router-link>
                </li>
               
                <li v-if="isAdmin" class="nav-item dropdown">
                  <span class="nav-link dropdown-toggle" to="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Product
                  </span>
                  <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <router-link class=" text-secondary dropdown-item bg-dark" to="/admin/addProduct">Add Product</router-link>
                    <router-link class=" text-secondary dropdown-item bg-dark" to="/viewProduct">View Products</router-link>
                  </div>
                </li>
                <li v-if="isAdmin" class="nav-item dropdown">
                  <span class="nav-link dropdown-toggle" to="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Category 
                  </span>
                  <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <router-link class=" text-secondary dropdown-item bg-dark" to="/admin/addCat">Add Category</router-link>
                    <router-link class=" text-secondary dropdown-item bg-dark" to="/admin/viewCat">View Category</router-link>
                  </div>
                </li>
           
                <li v-if="isLoggedIn" class="nav-item dropdown">
                  <span class="nav-link dropdown-toggle" to="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Apps
                  </span>
                  <div v-if="isLoggedIn" class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <router-link class="nav-link" to="/todo">Todo App</router-link>
                  </div>
                </li>
              
                  <li v-if="isLoggedIn" class="nav-item">
                      <router-link class="nav-link" to="/logout">Logout</router-link>
                  </li>
                  <li v-else>
                    <router-link class="nav-link" to="/login">Login</router-link>
                  </li>
                  <li v-if="!isLoggedIn">
                    <router-link class="nav-link" to="/register">Register</router-link>
                  </li>
                  <li>
                    <router-link  class="nav-link " to="/cart"> <span :class="cart.itemCount==''? '':'highlight'" >  <i  class="fas fa-shopping-cart cart"><sup class="cartText">{{ cart.itemCount }}</sup></i> </span></router-link>
                  </li>

              </ul>
              <div class="form-inline my-2 my-lg-0">
                <router-link :to="{name:'dashboard'}"><button  class="btn btn-outline-info my-2 mr-2 my-sm-0" type="submit">Profile</button></router-link>
              </div>
              <div  class="form-inline my-2 my-lg-0">
                
                <input v-model="searchText" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <router-link  :to="{name:'productSearch', query:{q:this.searchText}}" class="btn btn-outline-success my-2 my-sm-0" >Search</router-link>

              </div>



            </div>

            <router-link class="rightSide" v-if="outCart"  to="/cart"> <span class="nav-link" :class="cart.itemCount==''? '':'highlight'" >  <i  class="fas fa-shopping-cart cart"><sup class="cartText">{{ cart.itemCount }}</sup></i> </span></router-link>


            

          </nav>
</template>

<script>
  export default{
    mounted()
    {
      if(this.isLoggedIn)
      {
        User.isAdmin()
        .then(res=>this.isAdmin=res)
      }
      this.updateCart();
    }
    ,
    data(){
      return{
        isLoggedIn: User.loggedIn(),
        isAdmin : null,
        searchText: "",
        cart: {
          itemCount : '',
        },
        outCart : true,
      }
    },
    methods:{
      /*doSearch()
      {
        this.$router.push({name:'productSearch', query:{q:this.searchText}});

      }*/

      toggleOutCartVis()
      {
        if(this.outCart==true)
        { 
          this.outCart = false;

        }
        else
        {
          this.outCart = true;
        }
      },
      
      
      removeFromCart(product_id)
      {
        let x={};
        try {
          x = JSON.parse(localStorage.getItem('cart'));
          try {
            delete x[product_id];
            localStorage.setItem('cart',JSON.stringify(x));
            this.updateCart();
          } catch (error) {
            
          }
        } catch (error) {
          x = {}
        }
      },


      addToCart(product_id)
      {
        let x={};
        try {
          x = JSON.parse(localStorage.getItem('cart'));
        } catch (error) {
          x = {}
        }

        if(x==null)
        {
          x= {}
          x[product_id] =1;
        }
        else
        {
          if(!x.hasOwnProperty(product_id))
          {
            x[product_id] = 1;
          }
          else
          {
            x[product_id]++;
            if(x[product_id]>20)
            {
              x[product_id] = 20;
            }
          }
        }
        localStorage.setItem('cart',JSON.stringify(x));
        this.updateCart();

      },
      updateCart()
      { 
        let x = {}
        try {
          x = JSON.parse(localStorage.getItem('cart'));
          let len =Object.keys(x).length
          
          if(len==0)
          {
            this.cart.itemCount = '';
          }
          else
          {
            this.cart.itemCount = len;
          }
        } 
        catch (error) {
          this.cart.itemCount = '';
        }
      }
    }
  }
   



</script>

<style scoped>
  .rightSide
  {
    display: none;
  }



  .router-link-exact-active{
      color:#38C172 !important;
      
   }  
  .router-link-exact-active .btn{
      background: #6CB2EB !important;
      color: black;
   }  

.navbar
{
  font-size:15px;
}
.cartText{
  font-family: "Roboto", sans-serif;
  color:rgb(255, 255, 255);
  font-size: 15px;
}

.highlight{
  background: #3B4778;
  border-radius: 25%;
}
  
@media only screen and (max-width: 992px) {
  .rightSide
  {
    display: block;
  }
}
  
</style>