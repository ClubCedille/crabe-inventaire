<template>
  <div class="containeris-fluid">
    <p class="title is-2 is-spaced">{{ t('category.index')  }}</p>
    <notifications group="category" position="top center" width="400" />
    <a
      class="button is-success is-rounded is-outlined is-medium"
      v-on:click="addCategory"
    >
       <span class="icon is-small">
        <font-awesome-icon icon="plus" />
      </span>
      <span>{{ t("actions.add") }}</span>
    </a>
    <table class="table is-hoverable">
      <thead>
        <tr>
          <th>{{ t('category.name') }}</th>
          <th>{{ t('category.description') }}</th>
          <th>{{ t('category.edit') }}</th>
        </tr>
      </thead>
      <tbody v-for="(item, index) in this.categories" :key="index">
        <tr>
          <th>{{ item.name }}</th>
          <td>{{ item.description }}</td>
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
                  v-on:click="deleteCategory(item.id)"
                >
                  <span class="icon is-small">
                    <font-awesome-icon icon="trash" />
                  </span>
                  <span>{{ t('actions.delete') }}</span>
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
          <p class="modal-card-title">Create a category</p>
          <button
            class="delete"
            aria-label="close"
            v-on:click="closeCategoryModal"
          ></button>
        </header>
        <section class="modal-card-body">
        </section>
        <div class="field">
          <label class="label">{{ t('category.name') }}</label>
          <div class="control">
            <input
              class="input"
              type="text"
              name="name"
              :placeholder="t('category.placeholder.name')"
              id="name"
              v-model="name"
            />
          </div>
        </div>

        <div class="field">
          <label class="label">{{ t('category.description') }}</label>
          <div class="control">
            <input class="input" type="text" name="description"
              id="description"
              :placeholder="t('category.placeholder.description')"
              v-model="description" />
          </div>
        </div
        </section>
        <footer class="modal-card-foot">
          <a class="button is-success is-rounded " v-on:click="createCategory">
            <span class="icon is-small">
              <font-awesome-icon icon="save" />
            </span>
            <span>Save</span>
          </a>
          <button
            class="button is-danger is-rounded"
            v-on:click="closeCategoryModal"
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
    name: "category",
    props: {
      url: String,
      data: Array,
      message: String
    },
    data: function() {
      return {
        categories: this.data,
        csrf: document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
        modalActive: false,
        description: "",
        name: ""
      };
    },
    mounted() {
      if (this.message.length != 0) {
        this.$notify({
          group: "category",
          title: "Notification",
          type: "success",
          text: "success",
          duration: 5000
        });
      }
    },
    methods: {
      addCategory: function(event) {
        this.modalActive = true;
      },
      closeCategoryModal: function(event) {
        this.modalActive = false;
      },
      deleteCategory: function(id) {
        let currentObj = this;
        if (confirm(this.t('category.confirmation.delete'))) {
          this.axios
              .delete(this.url + "/" + id)
              .then((response) => {
                currentObj.updateData(this.t('category.deleted'));
              })
              .catch(function(error) {
                console.log(error);
              });
        }
      },
      createCategory: function(event) {
        let currentObj = this;
        this.axios
            .post(this.url, {
              name: currentObj.name,
              description: currentObj.description
            })
            .then((response) => {
                currentObj.updateData(this.t('category.created'));
            })
            .catch(function(error) {
              console.log(error);
            });
      },
      updateData: function(message) {
        let currentObj = this;
        this.axios
            .get(this.url + "/index")
            .then((response) => {
              currentObj.categories = response.data;
              currentObj.modalActive = false;
              currentObj.$notify({
                group: "category",
                title: "Notification",
                type: "success",
                text: message,
                duration: 5000
              });
            })
            .catch(function(error) {
              console.log(error);
            });
      }
    }
  };
</script>
