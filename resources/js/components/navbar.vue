<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <router-link   class="navbar-brand" to="/">CMS</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <router-link class="nav-link" to="/">Home <span class="sr-only">(current)</span></router-link>
                </li>
               
                <li v-if="isAdmin" class="nav-item dropdown">
                  <span class="nav-link dropdown-toggle" to="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Product Management
                  </span>
                  <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <router-link class=" text-secondary dropdown-item bg-dark" to="/admin/addProduct">Add Product</router-link>
                    <router-link class=" text-secondary dropdown-item bg-dark" to="/viewProduct">View Products</router-link>
                  </div>
                </li>
                <li v-if="isAdmin" class="nav-item dropdown">
                  <span class="nav-link dropdown-toggle" to="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Category Management
                  </span>
                  <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <router-link class=" text-secondary dropdown-item bg-dark" to="/admin/addCat">Add Category</router-link>
                    <router-link class=" text-secondary dropdown-item bg-dark" to="/admin/viewCat">View Category</router-link>
                  </div>
                </li>
                <li class="nav-item">
                    <router-link v-if="isLoggedIn && !isAdmin" class="nav-link" to="/admin/viewCat">View Category</router-link>
                </li>
                <li class="nav-item">
                    <router-link v-if="isLoggedIn && !isAdmin" class="nav-link" to="/viewProduct">View Product</router-link>
                </li>
                  
                  <li v-if="isLoggedIn">
                    <router-link class="nav-link" to="/todo">Todo App</router-link>
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
              </ul>
              <div class="form-inline my-2 my-lg-0">
                <router-link :to="{name:'dashboard'}"><button  class="btn btn-outline-info my-2 mr-2 my-sm-0" type="submit">Profile</button></router-link>
              </div>
              <div class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </div>
            </div>
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
    }
    ,
    data(){
      return{
        isLoggedIn: User.loggedIn(),
        isAdmin : null,
      }
    },
  }
   



</script>

<style scoped>
  .router-link-exact-active{
      color:#38C172 !important;
      
   }  
  .router-link-exact-active .btn{
      background: #6CB2EB !important;
      color: black;
   }  

  
  
</style>