<template>
  <v-card hover outlined>
    <v-card-text>
      <p class="mt-6 mb-0 title success--text">{{ product.name }}</p>
      <p class="pink--text body-1">{{ product.price.toLocaleString() }}$</p>
      <p class="pink--text body-1">Code: {{ product.code }}</p>
      <p>Description: {{ product.description }}</p>
      <p v-if="product.quantity <= 0" style="color:red;">NOT AVAILABLE</p>
      <button v-if="product.quantity > 0" v-on:click="addTocart" class="button is-success is-rounded" >Add to cart</button>
      <button v-else-if="product.quantity <= 0"  class="button is-success is-rounded" disabled>Add to cart</button>
    </v-card-text>
  </v-card>
</template>
<script >
 export default {
  name: "product",
  props: {
    url: String,
    data: Object,
    cartid:Number
  },
  data: function() {
    return {
      product: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },
  methods: {
    addTocart: function(event) {
          let currentObj = this;
          this.axios
              .post(this.url+"/cart/"+currentObj.cartid, {
                productId: currentObj.product.id,
              })
              .then((response) => {
                  console.log(response)
              })
              .catch(function(error) {
                console.log(error);
              });
    }
  }
 };
</script>