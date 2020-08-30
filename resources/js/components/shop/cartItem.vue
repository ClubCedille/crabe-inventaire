<template>
  <div>
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">
        {{ product.name }}
      </h5>
      <small class="text-muted">{{ product.price }}$</small>
    </div>
    <p class="mb-1">
      {{ product.description }}
    </p>
    <small class="text-muted">{{ product.code }}</small>
    <div class="d-flex w-100 justify-content-between">
      <small class="text-muted">Quantite: {{ product.count }}</small>
    </div>
    <div class="d-flex w-100 justify-content-between">
      <button
        class="button is-danger"
        @click="removeFromCart"
      >
        Remove
      </button>
    </div>
    <div class="d-flex w-100 justify-content-between">
      <button
        class="button is-primary"
        @click="addQuantity"
      >
        +
      </button>
      <button
        class="button is-danger"
        @click="removeQuantity"
      >
        -
      </button>
    </div>
  </div>
</template>
<script >
export default {
  name: 'CartItem',
  props: {
    url: String,
    data: Object,
    cartid: Number,
  },
  data() {
    return {
      product: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content'),
    };
  },
  watch: {
    data() {
      this.product = this.data;
    },
  },
  methods: {
    removeFromCart() {
      const currentObj = this;
      this.axios
        .delete(`${this.url}/${currentObj.cartid}/${currentObj.product.id}`)
        .then((response) => {
          this.$emit('updateparent', response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    addQuantity() {
      const currentObj = this;
      this.axios
        .post(`${this.url}/${currentObj.cartid}`, {
          productId: currentObj.product.id,
        })
        .then((response) => {
          currentObj.product = response.data;
          this.$emit('updatetotal');
        })
        .catch((error) => {
          console.log(error);
        });
    },
    removeQuantity() {
      const currentObj = this;
      this.axios
        .delete(`${this.url}/${currentObj.cartid}/product/${currentObj.product.id}`)
        .then((response) => {
          currentObj.product = response.data;
          this.$emit('updatetotal');
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
