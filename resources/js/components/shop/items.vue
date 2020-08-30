<template>
  <div>
    <v-row>
      <v-col
        v-for="(item ,idx) in products"
        :key="idx"
        md="4"
        sm="6"
        xs="12"
      >
        <item
          :key="idx"
          class="my-5"
          :url="url"
          :data="item"
          :cartid="cart['id']"
        />
      </v-col>
    </v-row>
  </div>
</template>
<script >
export default {
  name: 'Product',
  props: {
    url: String,
    data: Array,
    cart: Object,
  },
  data() {
    return {
      products: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content'),
    };
  },
};
</script>
