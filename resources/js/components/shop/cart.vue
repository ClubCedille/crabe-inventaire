<template>
  <div class="card">
    <div class="card-content">
      <p v-if="products.length <= 0" class="title">
        empty
      </p>
      <div class="list-group">
        <a
          :key="idx"
          v-for="(item, idx) in products"
          class="list-group-item list-group-item-action flex-column align-items-start mt-2"
        >
          <cart-item
            class="my-5"
            @updateparent="updateparent"
            @updatetotal="updatetotal"
            :key="idx"
            :url="url"
            :data="item"
            :cartid="cart['id']"
          ></cart-item>
        </a>
      </div>
    </div>
    <footer class="card-footer">

      
      <form method="POST" v-bind:action="transactionurl">
       <p class="card-footer-item">
      <span>
         <button
          v-if="products.length > 0"
          value="payer cart"
          type="submit"
          class="btn btn-warning btn-lg"
          style="background-color: gold;"
        >
          <img :src="icon" alt="paypal checkout" /> or Credit Card checkout
        </button>
        <button
          disabled
          v-if="products.length <= 0"
          value="payer cart"
          class="disabled btn btn-warning btn-lg"
          style="background-color: gold;"
        >
          <img :src="icon" alt="paypal checkout" /> or Credit Card checkout
        </button>
      </span>
    </p>
        <input type="hidden" name="_token" :value="csrf" />
      </form>

      <p class="card-footer-item">
        <span class="title"> Total : {{ total }} $ </span>
      </p>
    </footer>
  </div>
</template>
<script>
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
      total: 0,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    };
  },
  methods: {
    updateparent(productsFromChild) {
      this.products = productsFromChild;
      this.updatetotalInner(productsFromChild);
    },
    updatetotalInner(data) {
      let total = 0;
      data.forEach(product => (total += product.price * product.count));
      this.total = total;
      this.products = data;
    },
    updatetotal() {
      let currentObj = this;
      this.axios
        .get(this.url + "/all")
        .then(response => {
          currentObj.updatetotalInner(response.data)
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  created: function() {
    this.$nextTick(this.updatetotalInner(this.products));
  }
};
</script>
