<template>
  <div class="mw-100">
    <table class="table">
      <thead>
        <tr>
          <th class="text-left">
            Date
          </th>
          <th class="text-left">
            total
          </th>
          <th class="text-left" />
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in receipts"
          :key="item.transaction_id"
        >
          <td>{{ item.created_at }}</td>
          <td>{{ item.total }}$</td>
          <td>
            <button
              class="button is-rounded is-outlined is-success"
              @click="download(item.transaction_id,item.created_at)"
            >
              Download
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script >
export default {
  name: 'Receipts',
  props: {
    url: String,
    data: Array,
  },
  data() {
    return {
      receipts: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content'),
    };
  },
  methods: {
    download(id, date) {
      const currentObj = this;
      this.axios
        .get(`${this.url}/receipts/pdf/${id}`, { responseType: 'blob' })
        .then((response) => {
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', `receipt_${date}.pdf`);
          document.body.appendChild(link);
          link.click();
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
