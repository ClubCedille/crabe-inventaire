<template>
  <div class="containeris-fluid">
    <p class="title is-2 is-spaced">
      {{ t('category.update') }}
    </p>
    <notifications
      group="category"
      position="top center"
      width="400"
    />
    <form
      id="update-category-form"
      method="POST"
      :action="this.url + '/' + this.category.id"
    >
      <input
        type="hidden"
        name="_token"
        :value="this.csrf"
      >
      <div class="field">
        <label class="label">{{ t('category.name') }}</label>
        <div class="control">
          <input
            id="name"
            v-model="this.category.name"
            class="input"
            type="text"
            name="name"
          >
        </div>
      </div>
      <div class="field">
        <label class="label">{{ t('category.description') }}</label>
        <div class="control">
          <input
            id="description"
            v-model="this.category.description"
            class="input"
            type="text"
            name="description"
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
  name: 'CategoryEdit',
  props: {
    url: String,
    data: Object,
    message: String,
  },
  data() {
    return {
      category: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content'),
      description: '',
      name: '',
    };
  },
};
</script>
