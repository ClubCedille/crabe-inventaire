<template>
  <div class="containeris-fluid">
    <p class="title is-2 is-spaced">{{ t('product.indexPage') }}</p>
    <notifications group="product" position="top center" width="400" />
    <a
      class="button is-success is-rounded is-outlined is-medium"
      v-on:click="addProduct"
    >
      <span class="icon is-small">
        <font-awesome-icon icon="plus" />
      </span>
      <span>{{ t('actions.add') }}</span>
    </a>
    <table class="table is-hoverable">
      <thead>
        <tr>
          <th>{{ t('product.name') }}</th>
          <th>{{ t('product.code') }}</th>
          <th>{{ t('product.description') }}</th>
          <th>{{ t('product.quantity') }}</th>
          <th>{{ t('product.price') }}</th>
          <th>{{ t('product.category') }}</th>
          <th>{{ t('actions.edit') }}</th>
        </tr>
      </thead>
      <tbody v-for="(item, index) in this.products" :key="index">
        <tr>
          <th>{{ item.name }}</th>
          <td>{{ item.code }}</td>
          <td>{{ item.description }}</td>
          <td>{{ findCategoryName(item.category_id) }}</td>
          <td>{{ item.quantity }}</td>
          <td>{{ item.price }}</td>
          <td>
            <div class="field is-grouped">
              <p class="control">
                <a
                  class="button is-info is-rounded is-outlined"
                  v-bind:href="url + '/' + item.id + '/edit'"
                >
                  <span class="icon is-small">
                    <font-awesome-icon icon="edit" />
                  </span>
                  <span>{{ t('actions.edit') }}</span>
                </a>
              </p>
              <p class="control">
                <a
                  class="button is-danger is-rounded is-outlined"
                  v-on:click="deleteProduct(item.code)"
                >
                  <span class="icon is-small">
                    <font-awesome-icon icon="trash" />
                  </span>
                  <span>Delete</span>
                </a>
              </p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="modal" v-bind:class="{ 'is-active is-clipped': modalActive }">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Add a product</p>
          <button
            class="delete"
            aria-label="close"
            v-on:click="closeProductModal"
          ></button>
        </header>
        <section class="modal-card-body">
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input
                class="input"
                type="text"
                name="name"
                placeholder="Name"
                id="name"
                v-model="name"
              />
            </div>
          </div>

          <div class="field">
            <label class="label">Description</label>
            <div class="control">
              <input
                class="input"
                type="text"
                name="description"
                id="description"
                placeholder="Description"
                v-model="description"
              />
            </div>
          </div>

          <div class="field">
            <label class="label">Code</label>
            <div class="control">
              <input
                class="input"
                type="text"
                name="code"
                id="code"
                placeholder="Code"
                v-model="code"
              />
            </div>
          </div>

          <div class="field">
            <label class="label">Quantity</label>
            <div class="control">
              <input
                class="input"
                type="text"
                name="quantity"
                id="quantity"
                placeholder="Quantity"
                v-model="quantity"
              />
            </div>
          </div>

          <div class="field">
            <label class="label">Price</label>
            <div class="control">
              <input
                class="input"
                type="text"
                name="price"
                id="price"
                placeholder="Price"
                v-model="price"
              />
            </div>
          </div>

          <div class="field">
            <label class="label">Category</label>

            <select
              class="form-control"
              name="category_id"
              v-model="category_id"
            >
              <option value="" selected disabled>Category</option>
              <option
                v-for="category in categories"
                :value="category.id"
                :key="category.id"
                >{{ category.name }}</option
              >
            </select>

            <!--<div class="form-control">
                 <input class="input" type="text" name="category_id" id="category_id" placeholder="Category_Id"  v-model="category_id">
                 </div>-->
          </div>
        </section>
        <footer class="modal-card-foot">
          <a class="button is-success is-rounded " v-on:click="createProduct">
            <span class="icon is-small">
              <font-awesome-icon icon="save" />
            </span>
            <span>Save</span>
          </a>
          <button
            class="button is-danger is-rounded"
            v-on:click="closeProductModal"
          >
            Cancel
          </button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "product",
  props: {
    url: String,
    data: Array,
    message: String,
    categories: Array
  },
  data: function() {
    return {
      products: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      modalActive: false,
      code: "",
      name: "",
      description: "",
      price: 0,
      category_id: 0,
      quantity: 0
    };
  },
  mounted() {
    if(this.message.length != 0 ){
         this.$notify({
         group: 'product',
         title: 'Notification',
         type: 'success',
         text: 'Product updated !',
         duration: 5000,
         });

         }
  },
  methods: {
    addProduct: function(event) {
      this.modalActive = true;
    },
    closeProductModal: function(event) {
      this.modalActive = false;
    },
    deleteProduct: function(id) {
      let currentObj = this;
      if (confirm("are your sure to delete this product?")) {
        this.axios
          .delete(this.url + "/" + id)
          .then(function(response) {
            currentObj.updateData("Hello user! Product was deleted!");
          })
          .catch(function(error) {
            console.log(error);
          });
      }
    },
    createProduct: function(event) {
      let currentObj = this;
      this.axios
        .post(this.url, {
          code: currentObj.code,
          name: currentObj.name,
          description: currentObj.description,
          price: currentObj.price,
          category_id: currentObj.category_id,
          quantity: currentObj.quantity
        })
        .then(function(response) {
          currentObj.updateData("Hello user! A new product was created!");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    updateData: function(message) {
      let currentObj = this;
      this.axios
        .get(this.url + "/index")
        .then(function(response) {
          currentObj.products = response.data;
          console.log(this.url);
          currentObj.modalActive = false;
          currentObj.$notify({
            group: "product",
            title: "Notification",
            type: "success",
            text: message,
            duration: 5000
          });
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    findCategoryName: function(category_id) {
      let currentObj = this;

      for (var i = 0; i < currentObj.categories.length; i++) {
        if (currentObj.categories[i].id == category_id) {
          return currentObj.categories[i].name;
        }
      }
    }
  }
};
</script>
