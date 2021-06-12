<template>
    <div class="">
    <div class="main-body">
          <pModal  v-on:picUpdated="getUserData"/>
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card bg-dark">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <div class="imageContainer">
                      <img :src="profilePic" alt="Admin" class="rounded-circle img" width="150">
                      <button  data-toggle="modal" data-target="#exampleModalCenter" class="floatBtn text-uppercase">Update Image</button>
                    </div>
                    <div class="mt-3">
                      <h4>{{fullName.split(" ")[0]}}</h4>
                      <p class="text-muted font-size-sm"><i class="fas fa-map-marker-alt text-success"/> <cityName/></p>
                      <router-link :to="{name:'editProfile'}">
                        <button class="btn btn-primary">Edit Information</button>
                      </router-link>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card bg-dark mt-3">
                <ul class="list-group  list-group-flush">
                  <li class="list-group-item bg-dark d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Website</h6>
                    <a :href="'https://'+website" v-if="website" id="mywebsiteSpan" class="text-secondary">{{website}}</a>
                    <span v-else id="mywebsiteSpan" class="text-secondary">Not Yet Added</span>
                  </li>
                  <li  class="list-group-item bg-dark d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>Github</h6>
                    <span v-if="github" id="mywebsiteSpan" class="text-secondary">{{github}}</span>
                    <span v-else id="mywebsiteSpan" class="text-secondary">Not Yet Added</span>
                  </li>
                  <li class="list-group-item bg-dark d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Twitter</h6>
                    <span v-if="twitter" id="mywebsiteSpan" class="text-secondary">{{twitter}}</span>
                    <span v-else id="mywebsiteSpan" class="text-secondary">Not Yet Added</span>
                  </li>
                  <li class="list-group-item bg-dark d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
                    <span v-if="instagram" id="mywebsiteSpan" class="text-secondary">{{instagram}}</span>
                    <span v-else id="mywebsiteSpan" class="text-secondary">Not Yet Added</span>
                  </li>
                  <li class="list-group-item bg-dark d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
                    <span v-if="facebook" id="mywebsiteSpan" class="text-secondary">{{facebook}}</span>
                    <span v-else id="mywebsiteSpan" class="text-secondary">Not Yet Added</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card bg-dark mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Fullname</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{fullName}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{email}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <span v-if="phone">{{phone}}</span>
                      <span v-else>Not Yet Added</span>
                    </div>
                  </div>
                 
                  
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <i class="fas fa-map-marker-alt text-success"></i> <cityName/>
                    </div>
                  </div>
                  <hr>
                  
                </div>
              </div>

              


            </div>
          </div>

        </div>
    </div>
</template>

<script>
  import profileUpdateModal from './profileUpdateModal.vue';
  import cityName from '../Location/cityName.vue';

    export default{
      beforeMount()
      {
         this.getUserData();
         
      },
      components:{
          pModal : profileUpdateModal,
          cityName : cityName,
        },
        data()
        {
          return{
            userId : "",
            profilePic :"",
            name: "",
            fullName: "",
            email : "",
            phone : "",
            website: "",
            github: "",
            twitter: "",
            instagram: "",
            facebook: "",
          }
        },
        methods:{
          getUserData()
          {
            axios({
              method: 'get',
              url: `/api/user/getUserDetails`,
              headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
              }
            })
            .then(res=>{
              this.profilePic = res.data.userdetails.image;
              this.name = res.data.name;
              this.fullName = res.data.userdetails.fullname;
              this.email = res.data.email;
              this.phone = res.data.userdetails.phone;
              this.website = res.data.userdetails.website;
              this.website = res.data.userdetails.website;
              this.github = res.data.userdetails.github;
              this.twitter = res.data.userdetails.twitter;
              this.instagram = res.data.userdetails.instagram;
              this.facebook = res.data.userdetails.facebook;
            
              
            })
          }
        },  
    }
</script>

<style scoped>
.imageContainer {
  position: relative;
  width:50%;
}
.imageContainer .img {
  width: 100%;
  height: auto;
}


.imageContainer .floatBtn {
  position: absolute;
  top: 95%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  background-color: #555;
  color: white;
  font-size: 12px;
  padding: 6px 12px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  display: none;
}

.imageContainer .floatBtn:hover {
  background-color: #227DC7;

}

.imageContainer:hover .floatBtn {
  display: block;
}

a:hover{
  color:white !important;
}

</style>

