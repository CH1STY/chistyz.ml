<template>
    <div>
        <navbar/>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <div class="carousel-caption d-none d-md-block">              
                </div>
                <img class="d-block w-100" src="asset/sliders/slider1.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="asset/sliders/slider2.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="asset/sliders/slider3.jpg" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>
            
            

    </div>
</template>

<script>
    export default{
        
        beforeCreate()
        {
            // axios.get('api/home-carousel')
            // .then(res=>this.slider_images= res.data)
            // .catch(error=>console.log(error))
        },
        data(){
            return{
                slider_images: [],
            }
        },
        components:{
            
        },
    }
    

</script>

<style scoped>


.neonText {
    text-transform: uppercase;
    color: rgb(0, 0, 0);
    text-shadow:
    0 0 7px #fff,
    0 0 10px #fff,
    0 0 21px #fff,
    0 0 42px #0fa,
    0 0 82px #0fa,
    0 0 92px #0fa,
    0 0 102px #0fa,
    0 0 151px #0fa;
}

</style>