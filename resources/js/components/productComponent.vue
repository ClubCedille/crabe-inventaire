<template>
  <div class="containeris-fluid">
    <p class="title is-2 is-spaced">
      {{ t("product.indexPage") }}
    </p>
    <notifications
      group="product"
      position="top center"
      width="400"
    />
    <a
      class="button is-success is-rounded is-outlined is-medium"
      @click="addProduct"
    >
      <span class="icon is-small">
        <font-awesome-icon icon="plus" />
      </span>
      <span>{{ t("actions.add") }}</span>
    </a>
    <table class="table is-hoverable">
      <thead>
        <tr>
          <th>{{ t("product.name") }}</th>
          <th>{{ t("product.code") }}</th>
          <th>{{ t("product.description") }}</th>
          <th>{{ t("product.category") }}</th>
          <th>{{ t("product.quantity") }}</th>
          <th>{{ t("product.price") }}</th>
          <th>{{ t("actions.edit") }}</th>
        </tr>
      </thead>
      <tbody
        v-for="(item, index) in this.products"
        :key="index"
      >
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
                  :href="url + '/' + item.id + '/edit'"
                >
                  <span class="icon is-small">
                    <font-awesome-icon icon="edit" />
                  </span>
                  <span>{{ t("actions.edit") }}</span>
                </a>
              </p>
              <p class="control">
                <a
                  class="button is-danger is-rounded is-outlined"
                  @click="deleteProduct(item.code)"
                >
                  <span class="icon is-small">
                    <font-awesome-icon icon="trash" />
                  </span>
                  <span>{{ t("actions.delete") }}</span>
                </a>
              </p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <div
      class="modal"
      :class="{ 'is-active is-clipped': modalActive }"
    >
      <div class="modal-background" />
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">
            Add a product
          </p>
          <button
            class="delete"
            aria-label="close"
            @click="closeProductModal"
          />
        </header>
        <section class="modal-card-body">
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input
                id="name"
                v-model="name"
                class="input"
                type="text"
                name="name"
                placeholder="Name"
              >
            </div>
          </div>

          <div class="field">
            <label class="label">Description</label>
            <div class="control">
              <input
                id="description"
                v-model="description"
                class="input"
                type="text"
                name="description"
                placeholder="Description"
              >
            </div>
          </div>

          <div class="field">
            <label class="label">Code</label>
            <div class="control">
              <input
                id="code"
                v-model="code"
                class="input"
                type="text"
                name="code"
                placeholder="Code"
              >
            </div>
          </div>

          <div class="field">
            <label class="label">Quantity</label>
            <div class="control">
              <input
                id="quantity"
                v-model="quantity"
                class="input"
                type="text"
                name="quantity"
                placeholder="Quantity"
              >
            </div>
          </div>

          <div class="field">
            <label class="label">Price</label>
            <div class="control">
              <input
                id="price"
                v-model="price"
                class="input"
                type="text"
                name="price"
                placeholder="Price"
              >
            </div>
          </div>

          <div class="field">
            <label class="label">Category</label>

            <select
              v-model="category_id"
              class="form-control"
              name="category_id"
            >
              <option
                value=""
                selected
                disabled
              >
                Category
              </option>
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
          </div>
        </section>
        <footer class="modal-card-foot">
          <a
            class="button is-success is-rounded "
            @click="createProduct"
          >
            <span class="icon is-small">
              <font-awesome-icon icon="save" />
            </span>
            <span>Save</span>
          </a>
          <button
            class="button is-danger is-rounded"
            @click="closeProductModal"
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
  name: 'Product',
  props: {
    url: String,
    data: Array,
    message: String,
    categories: Array,
  },
  data() {
    return {
      products: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content'),
      modalActive: false,
      code: '',
      name: '',
      description: '',
      price: 0,
      category_id: 0,
      quantity: 0,
    };
  },
  mounted() {
    if (this.message.length != 0) {
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
    addProduct(event) {
      this.modalActive = true;
    },
    closeProductModal(event) {
      this.modalActive = false;
    },
    deleteProduct(id) {
      const currentObj = this;
      if (confirm(this.t('product.confirmation.delete'))) {
        this.axios
          .delete(`${this.url}/${id}`)
          .then((response) => {
            currentObj.updateData(this.t('product.deleted'));
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    createProduct(event) {
      const currentObj = this;
      this.axios
        .post(this.url, {
          code: currentObj.code,
          name: currentObj.name,
          description: currentObj.description,
          price: currentObj.price,
          category_id: currentObj.category_id,
          quantity: currentObj.quantity,
        })
        .then((response) => {
          currentObj.updateData(this.t('product.created'));
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updateData(message) {
      const currentObj = this;
      this.axios
        .get(`${this.url}/index`)
        .then((response) => {
          currentObj.products = response.data;
          currentObj.modalActive = false;
          currentObj.$notify({
            group: 'product',
            title: 'Notification',
            type: 'success',
            text: message,
            duration: 5000,
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    findCategoryName(category_id) {
      const currentObj = this;

      for (let i = 0; i < currentObj.categories.length; i++) {
        if (currentObj.categories[i].id == category_id) {
          return currentObj.categories[i].name;
        }
      }
    },
  },
};
</script>
