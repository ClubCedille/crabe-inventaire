<template>
    <div class="containeris-fluid">
        <p class="title is-2 is-spaced">{{ t('category.update') }}</p>
        <notifications group="category" position="top center" width="400" />
        <form method="POST" id="update-category-form" :action="this.url + '/' + this.category.id">
            <input type="hidden" name="_token" :value="this.csrf"/>
            <div class="field">
                <label class="label">{{ t('category.name') }}</label>
                <div class="control">
                    <input
                        class="input"
                        type="text"
                        name="name"
                        id="name"
                        v-model="this.category.name"
                    />
                </div>
            </div>
            <div class="field">
                <label class="label">{{ t('category.description') }}</label>
                <div class="control">
                    <input
                        class="input"
                        type="text"
                        name="description"
                        id="description"
                        v-model="this.category.description"
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
     name: "category-edit",
     props: {
         url: String,
         data: Object,
         message: String
     },
     data: function() {
         return {
             category: this.data,
             csrf: document
                 .querySelector('meta[name="csrf-token"]')
                 .getAttribute("content"),
             description: "",
             name: ""
         };
     }
 };
</script>
