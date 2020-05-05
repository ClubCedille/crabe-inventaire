<template>
  <div>
    <v-row>
      <v-col :key="idx" md="4" sm="6" v-for="(item ,idx) in products" xs="12">
        <item  class="my-5" :key="idx" :url="url" :data="item" :cartid="cart['id']"></item>
      </v-col>
    </v-row>
  </div>
</template>
<script >
 export default {
  name: "product",
  props: {
    url: String,
    data: Array,
    cart:Object 
  },
  data: function() {
    return {
      products: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },
 };
</script>