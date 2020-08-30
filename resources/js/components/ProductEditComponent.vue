<template>
  <div class="containeris-fluid">
    <p class="title is-2 is-spaced">
      {{ t('product.update') }}
    </p>
    <notifications
      group="product"
      position="top center"
      width="400"
    />
    <form
      id="update-product-form"
      method="POST"
      :action="this.url + '/' + this.product.id"
    >
      <input
        type="hidden"
        name="_token"
        :value="this.csrf"
      >
      <div class="field">
        <label class="label">{{ t('product.name') }}</label>
        <div class="control">
          <input
            id="name"
            v-model="this.product.name"
            class="input"
            type="text"
            name="name"
          >
        </div>
      </div>
      <div class="field">
        <label class="label">{{ t('product.description') }}</label>
        <div class="control">
          <input
            id="description"
            v-model="this.product.description"
            class="input"
            type="text"
            name="description"
          >
        </div>
      </div>
      <div class="field">
        <label class="label">{{ t('product.code') }}</label>
        <div class="control">
          <input
            id="code"
            v-model="this.product.code"
            class="input"
            type="text"
            name="code"
          >
        </div>
      </div>
      <div class="field">
        <label class="label">{{ t('product.category') }}</label>
        <select
          v-model="this.product.category_id"
          class="form-control"
          name="category_id"
        >
          <option
            v-for="category in this.categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
      </div>
      <div class="field">
        <label class="label">{{ t('product.quantity') }}</label>
        <div class="control">
          <input
            id="quantity"
            v-model="this.product.quantity"
            class="input"
            type="text"
            name="quantity"
          >
        </div>
      </div>
      <div class="field">
        <label class="label">{{ t('product.price') }}</label>
        <div class="control">
          <input
            id="price"
            v-model="this.product.price"
            class="input"
            type="text"
            name="price"
          >
        </div>
      </div>
      <div class="field is-grouped">
        <button
          class="button is-info is-rounded is-outlined control"
          @click="submit"
        >
          <span class="icon is-small">
            <font-awesome-icon icon="edit" />
          </span>
          {{ t('actions.edit') }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'ProductEdit',
  props: {
    url: String,
    data: Object,
    categories: Array,
    message: String,
  },
  data() {
    return {
      product: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content'),
      description: '',
      name: '',
      code: '',
      quantity: 0,
      price: 0,
      category_id: 0,
    };
  },
};
</script>
