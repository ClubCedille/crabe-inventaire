<template>
   <div>
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">{{product.name}}</h5>
      <small class="text-muted">{{product.price}}$</small>
    </div>
    <p class="mb-1">{{product.description}}</p>
    <small class="text-muted">{{product.code}}</small>
     <div class="d-flex w-100 justify-content-between">
        <small class="text-muted">Quantite: {{product.count}}</small>
     </div>
    <div class="d-flex w-100 justify-content-between">
        <button v-on:click="removeFromCart" class="button is-danger" >Remove</button>
     </div>
      <div class="d-flex w-100 justify-content-between">
        <button v-on:click="addQuantity" class="button is-primary" >+</button>
        <button v-on:click="removeQuantity" class="button is-danger" >-</button>
     </div>
   </div>
</template>
<script >
 export default {
  name: "cart-item",
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
  watch: {
    data: function() {
        this.product = this.data
    },
  },
  methods: {
    removeFromCart: function(event) {
          let currentObj = this;
          this.axios
              .delete(this.url+"/"+currentObj.cartid+"/"+currentObj.product.id)
              .then((response) => {
                  this.$emit('updateparent', response.data)
              })
              .catch(function(error) {
                console.log(error);
              });
    },
    addQuantity: function(event) {
        let currentObj = this;
        this.axios
              .post(this.url+"/"+currentObj.cartid, {
                productId: currentObj.product.id,
              })
              .then((response) => {
                  currentObj.product = response.data;
                  this.$emit('updatetotal')
              })
              .catch(function(error) {
                console.log(error);
              });
    },
    removeQuantity: function(event) {
        let currentObj = this;
        this.axios
            .delete(this.url+"/"+currentObj.cartid+"/product/"+currentObj.product.id)
            .then((response) => {
                currentObj.product = response.data;
                this.$emit('updatetotal')
            })
            .catch(function(error) {
              console.log(error);
            });
    }
  }
 };
</script>