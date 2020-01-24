<template>
<div >
  <div class="list-group">
     
    <a  :key="idx" v-for="(item ,idx) in products" class="list-group-item list-group-item-action flex-column align-items-start">
        <cart-item class="my-5" @updateparent="updateparent" :key="idx" :url="url" :data="item" :cartid="cart['id']"></cart-item>
    </a>
 </div>
 <form method="POST"  v-bind:action="transactionurl">
    <button  value="payer cart" type="submit" class="btn btn-warning btn-lg" style="background-color: gold;"><img :src="icon" alt="paypal checkout"> checkout</button>
    <input type="hidden" name="_token" :value="csrf">
  </form>
  </div>
</template>
<script >
 export default {
  name: "cart",
  props: {
    url: String,
    data: Array,
    cart: Object,
    icon: String,
    transactionurl: String
  },
  data: function() {
    return {
      products: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },
  methods: {
    updateparent(productsFromChild) {
        this.products = productsFromChild
    }
  }
 };
</script>