<template>
    <div>
        <div class="header">
            <h1>Our Products</h1>
        </div>
        <br>
       <div class="card-columns">
           <div v-for="product in products.data" :key="product.identifier" class="card list">
               <router-link to="/product/{product.identifier}"><img class="card-img-top" :src="product.picture" alt=""></router-link>
               <div class="card-body">
                   <h3 class="card-title">{{product.title}}  <span class="pull-right" style="font-size:18px; color:red">In Stock: {{product.stock}}</span></h3>
               </div>
           </div>
       </div>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            products:[],
            errors:[],
        };
    },


    mounted(){
         this.getProducts();
    },

    methods: {
       getProducts: function(){
           axios.get('/product')
           .then(res => {
              this.products = res.data;
           })
           .catch(err => {
               alert(err);
           })
       }
    }
}
</script>
