<template>
<div>
    <div class="container-fluid">
        <navbar/>
        <pGallery v-bind:isHome="false"/>

    </div>
    
</div>
</template>

<script>
import productGallery from './productGallery.vue';

export default {
    components:{
        pGallery: productGallery,
    },
    

    
}
</script>