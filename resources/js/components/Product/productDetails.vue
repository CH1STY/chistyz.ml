<template>
<div>
    <navbar ref="navbar"/>
    <div class="container-fluid">
        <pDetails v-on:addThisToCart="addToCart" v-on:removeFromCart="removeFromCart" :key=$route.params.productId />
    <footer>
            <p>CopyRightz By Chisty</p>
    </footer>
    </div>
</div>


</template>

<script>
import productPart from './productPart.vue'
export default {
    components:{
        pDetails : productPart,
    },
    methods:{
        addToCart(product_id)
        {
            this.$refs.navbar.addToCart(product_id);
        },
        removeFromCart(product_id)
        {
            this.$refs.navbar.removeFromCart(product_id);
        },
       
    }
}
</script>

<style scoped>

</style>