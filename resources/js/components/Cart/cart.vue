<template>
    <div>
        <navbar ref="navbar"/>
        <div v-if="!isEmpty">

            <h3 class="text-center text-uppercase text-primary">Shopping Cart</h3>
            <div class="container-fluid">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in products" :key="product.id">

                        <td >{{product.name}}</td>
                        
                        <td >
                            <input style="width:60px" type="number" max=20 v-on:change="updateCartAndMoney(product.id,$event)"  :value="product.quantity"/> 
                        </td>
                        
                        
                        <td class="text-success font-weight-bold"  :key="product.quantity">{{product.quantity*product.price}}</td>
                        <td ><button v-on:click="removeProduct(product.id)" class="btn btn btn-outline-danger">REMOVE</button></td>
                    </tr>
                    </tbody>
                </table>
                <h3 class="text-right text-success total">SUBTOTAL: {{this.totalPrice}}</h3>
            
                <div class="text-center">
                    <button v-on:click="thankYou()" class="btn btn-outline-success">Proceed To Checkout</button>

                </div>

            </div>
        </div>
        <div v-if="isEmpty">
            <h4 class="text-center text-danger">Cart is Empty!</h4> 
            <div class="text-center">
                <router-link class="text-center" :to="{name:'productSearch', query:{q:''}}"><button class="btn btn-center btn-success"> GO TO SHOP </button>    </router-link>
            </div>
            


        </div>
    </div>
    
</template>


<script>
export default {
    created()
    {
        this.getCartDetails();
        this.isCartEmpty();
    },
    data()
    {
        return{
            products:{},
            isEmpty : false,
            totalPrice: 0,
        }
    },

    methods:{
        getCartDetails()
        {
            let x ={};
            try {
                x = JSON.parse(localStorage.getItem('cart'));
            } catch (error) {
                x = {}
            }
            if(x==undefined)
            {
                this.isEmpty = true;

            }
            else if(Object.keys(x).length === 0 )
            {
                this.isEmpty = true;
            }
            else
            {
                let form = new FormData;
                form.append('cartArray',JSON.stringify(x));
                axios({
                        method: 'post',
                        data: form ,
                        url: `/api/getCartData`,
                        
                })
                .then(res=>{
                    let data = res.data;
                    let x ={};
                    for(let i=0;i<data.length;i++)
                    {
                        x[data[i][3]] = {
                            id : data[i][3],
                            name: data[i][0],
                            price: data[i][1],
                            quantity: data[i][2],
                        }
                    }

                    this.products = x;

                    this.calculateTotal();
                   
                })
                .catch(error=>{
                    this.isEmpty = true;
                })
            

            }

        },
        updateCartAndMoney(product_id,event)
        {

            if(isNaN(event.target.value))
            {
                event.target.value = 1;
                this.products[product_id].quantity = event.target.value;
                this.calculateTotal()
                this.updateQuantityOnLocalStorage(product_id, this.products[product_id].quantity);

            }
            else if(event.target.value<0)
            {
                event.target.value = 1;
                this.products[product_id].quantity = event.target.value;
                this.calculateTotal()
                this.updateQuantityOnLocalStorage(product_id, this.products[product_id].quantity);

                

            }
            else if(event.target.value>20)
            {
                event.target.value = 20;
                this.products[product_id].quantity = event.target.value;
                this.calculateTotal()
                this.updateQuantityOnLocalStorage(product_id, this.products[product_id].quantity);

            }
            else if(event.target.value==0)
            {
                Swal.fire({
                    title: `Are you Sure on Removing ${this.products[product_id].name} from Cart`,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Remove it!'
                }).then((result) => {
                    if(result.isConfirmed)
                    {
                        this.$refs.navbar.removeFromCart(product_id);
                        delete this.products[product_id];
                        this.calculateTotal()
                        this.isCartEmpty();



                    }
                    else
                    {
                        event.target.value = 1;
                        this.products[product_id].quantity = event.target.value;
                        this.calculateTotal()
                        this.updateQuantityOnLocalStorage(product_id, this.products[product_id].quantity);
                    }
                })
            }
            this.products[product_id].quantity = parseInt(event.target.value);

            this.calculateTotal()
            this.updateQuantityOnLocalStorage(product_id, this.products[product_id].quantity);




        },
        calculateTotal()
        {
            let totalPrice = 0;
            for (const product in this.products)
            {
                totalPrice += this.products[product].price * this.products[product].quantity;
            }

            this.totalPrice = totalPrice;
        },
        updateQuantityOnLocalStorage(product_id,quantity)
        {
            let x={};
            try {
            x = JSON.parse(localStorage.getItem('cart'));
            } catch (error) {
            x = {}
            }

            if(x==null)
            {
                x={}
                x[product_id] = parseInt(quantity);

            }
            else
            {
                if(!x.hasOwnProperty(product_id))
                {
                    x[product_id] = parseInt(quantity);
                }
                else
                {
                    x[product_id] = parseInt(quantity);
                   
                }
            }
            localStorage.setItem('cart',JSON.stringify(x));

        },
        removeProduct(product_id)
        {
                Swal.fire({
                    title: `Are you Sure on Removing ${this.products[product_id].name} from Cart`,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Remove it!'
                }).then((result) => {
                    if(result.isConfirmed)
                    {
                        this.$refs.navbar.removeFromCart(product_id);
                        delete this.products[product_id];
                        this.calculateTotal()
                        this.isCartEmpty();


                    }
                  
                })
        },
        isCartEmpty()
        {
            let x={};
            try {
                x = JSON.parse(localStorage.getItem('cart'));
            } catch (error) {
                x = {}
            }
            if(x==undefined || x==null || Object.keys(x).length<=0)
            {
                this.isEmpty = true;
            }
            else
            {
                this.isEmpty = false;
            }

        },
        thankYou()
        {
             Swal.fire({
                    title: 'Thank You ❤',
                    text:'Thank You Very Much For Checking This Website, The Order Proceeding System is not created as this is not a practical website. If you have any query please contact me at chistyz10@gmail.com.\n Once Again Thank Your For Tuning In ❤.',
                    icon: 'success',
             });
        }

    },
 
}
</script>Navbar

<style scoped>

    .total{
        margin: 10px;
        padding: 5px;
    }
    input[type=number] {
        background-color: #227DC7;
        border: 2px solid rgb(77, 77, 77);
        border-radius: 4px;
    }
 
   
</style>