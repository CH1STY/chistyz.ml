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
                <li v-if="isLoggedIn" class="nav-item">
                  <router-link class="nav-link" to="/dashboard">Dashboard</router-link>
                </li>
                <li v-if="isLoggedIn" class="nav-item dropdown">
                  <span class="nav-link dropdown-toggle" to="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Product Management
                  </span>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <router-link class="dropdown-item" to="/admin/addProduct">Add Product</router-link>
                    <router-link class="dropdown-item" to="/admin/viewProduct">View Products</router-link>
                    <div class="dropdown-divider"></div>
                    <router-link class="dropdown-item" to="/admin/deleteProduct">Delete Produtc</router-link>
                  </div>
                </li>
                
                  <li v-if="isLoggedIn" class="nav-item" >
                      <router-link class="nav-link" to="/admin/addNewCat">Add New Category</router-link>
                  </li>
                  <li v-if="isLoggedIn" class="nav-item">
                      <router-link class="nav-link" to="/logout">Logout</router-link>
                  </li>
                  <li v-else>
                    <router-link   class="nav-link" to="/login">Login</router-link>
                  </li>
              </ul>
              <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
            </div>
          </nav>
</template>

<script>
  export default{
    data(){
      return{
        isLoggedIn: User.loggedIn(),
      }
    },
  }
   



</script>

<style scoped>
  .router-link-exact-active{
      color:white !important;
   }  
</style>