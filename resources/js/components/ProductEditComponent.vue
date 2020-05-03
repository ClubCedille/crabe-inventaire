<template>
    <div class="containeris-fluid">
        <p class="title is-2 is-spaced">{{ t('product.update') }}</p>
        <notifications group="product" position="top center" width="400" />
        <form method="POST" id="update-product-form" :action="this.url + '/' + this.product.id">
            <input type="hidden" name="_token" :value="this.csrf"/>
            <div class="field">
                <label class="label">{{ t('product.name') }}</label>
                <div class="control">
                    <input
                        class="input"
                        type="text"
                        name="name"
                        id="name"
                        v-model="this.product.name"
                    />
                </div>
            </div>
            <div class="field">
                <label class="label">{{ t('product.description') }}</label>
                <div class="control">
                    <input
                        class="input"
                        type="text"
                        name="description"
                        id="description"
                        v-model="this.product.description"
                    />
                </div>
            </div>
            <div class="field">
                <label class="label">{{ t('product.code') }}</label>
                <div class="control">
                    <input
                        class="input"
                        type="text"
                        name="code"
                        id="code"
                        v-model="this.product.code"
                    />
                </div>
            </div>
<div class="field">
                <label class="label">{{ t('product.category') }}</label>
                <select
                    class="form-control"
                    name="category_id"
                    v-model="this.product.category_id"
                >
              <option
                v-for="category in this.categories"
                :value="category.id"
                :key="category.id"
                >{{ category.name }}</option
              >
            </select>
            </div>
            <div class="field">
                <label class="label">{{ t('product.quantity') }}</label>
                <div class="control">
                    <input
                        class="input"
                        type="text"
                        name="quantity"
                        id="quantity"
                        v-model="this.product.quantity"
                    />
                </div>
            </div>
            <div class="field">
                <label class="label">{{ t('product.price') }}</label>
                <div class="control">
                    <input
                        class="input"
                        type="text"
                        name="price"
                        id="price"
                        v-model="this.product.price"
                    />
                </div>
            </div>
            <div class="field is-grouped">
                <button class="button is-info is-rounded is-outlined control" v-on:click="submit">
                    <span class="icon is-small">
                        <font-awesome-icon icon="edit" />
                    </span>
                    {{  t('actions.edit') }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
 export default {
     name: "product-edit",
     props: {
         url: String,
         data: Object,
         categories: Array,
         message: String
     },
     data: function() {
         return {
             product: this.data,
             csrf: document
                 .querySelector('meta[name="csrf-token"]')
                 .getAttribute("content"),
             description: "",
             name: "",
             code: "",
             quantity: 0,
             price: 0,
             category_id: 0
         };
     }
 };
</script>
