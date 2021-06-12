<template>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog  modal-md  modal-dialog-centered" role="document">
            <div class="modal-content bg-dark ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Profile Picture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="submit">
                <div class="modal-body">
                    <img :src="image" width="100px" height="100px" alt="" srcset="">
                    <input type="file" accept="image/*" name="image" @change="changeImage" id="">
                    <small v-if="errors.image" class="form-text text-danger text-center">{{errors.image[0]}}</small>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button v-if="!isRequested" type="submit" class="btn btn-primary">Save changes</button>
                    <div v-if="isRequested" class="loader"></div>
                    
                </div>
            </form>
            </div>
        </div>
    </div>    
</template>

<script>
    export default{
        data()
        {
            return{
                form:{
                    image: ""
                },
                image:"dummy.png",
                errors:{
                    image:[],
                },
                isRequested : false,
            }
        },
        methods:{
            submit()
            {
                this.isRequested=true;
                if(this.form.image=="")
                {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Nothing to Change'
                    }) 
                    this.isRequested=false;

                }
                else
                {
                    let newFormData = new FormData();
                    newFormData.append('image',this.form.image);
                    axios({
                        method: 'post',
                        url: `/api/user/updateProfilePic`,
                        data: newFormData,
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')} `,
                            'Content-Type': 'application/x-www-form-urlencoded',

                        }
                    })
                    .then(res=>{
                        if(res.data =="Success")
                        {
                            Toast.fire({
                                icon: 'success',
                                title: 'Profile Picture Updated'
                            })                              
                            $('#exampleModalCenter').modal('hide');
                            this.$emit('picUpdated')    
                            this.isRequested=false;
                        }
                        else
                        {
                            Toast.fire({
                                icon: 'warning',
                                title: 'Error Occured'
                            })
                            this.isRequested=false;

                        }
                    })
                    .catch(error=>
                    {
                        this.errors = error.response.data.errors;
                        this.isRequested=false;

                    });
                }
            },
            changeImage(event)
            {
                this.form.image = event.target.files[0];
                let reader = new FileReader();
                reader.onload = event =>{
                    this.image = event.target.result;
                };
                reader.readAsDataURL(this.form.image);
                this.errors.image= [];
            }
           
        }
        
    }
</script>

<style scoped>

</style>