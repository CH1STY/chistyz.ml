<template>
    <div>
        <navbar/>
        <vueper-slides  autoplay fade  >
            <vueper-slide v-for="(slide) in slides"
                :key="slide.id"
                :image="slide.image"
                :title="slide.title"
                :content="slide.content" 
                />
            <template v-slot:pause>
                <i class="icon pause_circle_outline"></i>
            </template>
        </vueper-slides>
        <section id="about" class="about">
            <div class="container">

                <div class="row">
                <div class="col-lg-6 order-1 order-lg-2 aos-init aos-animate" data-aos="fade-left">
                    <img src="asset/about.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content aos-init aos-animate" data-aos="fade-right">
                    <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
                    <p class="fst-italic">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                    magna aliqua.
                    </p>
                    <ul>
                    <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                    <li><i class="bi bi-check-circle"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                    <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                    </ul>
                    <p>
                    Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                    velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum
                    </p>
                </div>
                </div>

            </div>
        </section>
        <!--GALLERY CONTAINER -->

        <div class="container-fluid">
            <div class="card-header m-10">
                <h3 class="text-center">Our Products</h3>
            </div>            
            <gallery v-bind:isHome="true"/>
        </div>
        <!--GALLERY CONTAINER -->

        <footer>
            <p>CopyRightz By Chisty</p>
        </footer>

    </div>
</template>

<script>
    import productGallery from './Product/productGallery.vue';
    import { VueperSlides, VueperSlide } from 'vueperslides';
    import 'vueperslides/dist/vueperslides.css';
    export default{
        
        beforeCreate()
        {
           
        },
        data(){
            return{
                slides: [
                    {
                        title:'<h4 style="text-transform:uppercase;color:#D3D5DA;position:absolute;top:0;right:2px">Bridge</h4>',
                        image: 'asset/sliders/slider1.jpg',
                        
                    },
                    {
                        title:'<h4 style="text-transform:uppercase;color:#D3D5DA;position:absolute;top:0;right:2px">Monument</h4>',
                        image: 'asset/sliders/slider2.jpg',
                        
                    },
                    {
                        title:'<h4 style="text-transform:uppercase;color:#D3D5DA;position:absolute;top:0;right:2px">Snow</h4>',
                        image: 'asset/sliders/slider3.jpg',
                        
                    },
                 
                ]
            }
        },
        components:{
            VueperSlides,VueperSlide,
            gallery: productGallery,

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

.about{
    margin-top:30px;
    margin-bottom: 20px;
}

</style>