<template>
  <div>
    <h1 class="title is-1">
      Rapport
    </h1>
    <nav class="level">
      <!-- Left side -->
      <div class="level-left">
        <div class="level-item">
          <p class="subtitle is-5">
            <strong>Report of inventary</strong>
          </p>
        </div>
      </div>

      <!-- Right side -->
      <div class="level-right">
        <button
          class="button is-medium is-danger is-rounded"
          @click="generateInventaryReport"
        >
          Generate
        </button>
      </div>
    </nav>
    <nav class="level">
      <!-- Left side -->
      <div class="level-left">
        <div class="level-item">
          <p class="subtitle is-5">
            <strong>Report of transaction by date interval</strong>
          </p>
        </div>
      </div>

      <!-- Right side -->
      <div class="level-right">
        <p class="level-item">
          <v-date-picker v-model="rangeTransactions" mode="range" />
        </p>
        <p class="level-item">
          <button
            v-if="
              this.rangeTransactions.start.getTime() ===
                this.rangeTransactions.end.getTime()
            "
            disabled
            class="button is-medium is-danger is-rounded"
          >
            Generate
          </button>
          <button
            v-if="
              this.rangeTransactions.start.getTime() !=
                this.rangeTransactions.end.getTime()
            "
            class="button is-medium is-danger is-rounded"
            @click="generateTransactionsReport"
          >
            Generate
          </button>
        </p>
      </div>
    </nav>
    <h2 class="subtitle is-2">
      Pieces non disponible ou bientot non disponible
    </h2>
    <table class="table is-hoverable">
      <thead>
        <tr>
          <th>Product name</th>
          <th>Code</th>
          <th>Quantity</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody v-for="(item, index) in this.products" :key="index">
        <tr>
          <th>{{ item.name }}</th>
          <td>{{ item.code }}</td>
          <td>{{ item.quantity }}</td>
          <td v-if="item.quantity === 0">
            non disponible
            <div
              class="circle"
              style="height: 30px;  width: 30px;background-color: red;border-radius: 50%;"
            />
          </td>
          <td v-if="item.quantity > 0">
            bientot non disponible
            <div
              class="circle"
              style="height: 30px;  width: 30px;background-color: orange;border-radius: 50%;"
            />
            <div class="circle" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  name: 'Report',
  props: {
    data: Array,
    url: String
  },
  data() {
    return {
      products: this.data,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content'),
      rangeTransactions: {
        start: new Date(),
        end: new Date(),
      },
    };
  },
  methods: {
    generateInventaryReport() {
      this.axios
        .get(`${this.url}/report/products/pdf`, { responseType: 'blob' })
        .then((response) => {
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', `rapport_inventaire_${new Date()}.pdf`);
          document.body.appendChild(link);
          link.click();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    generateTransactionsReport() {
      this.axios
        .get(
          `${this.url}/report/transactions/pdf/${
            this.formatDate(this.rangeTransactions.start)
          }/${this.formatDate(this.rangeTransactions.end)}`,
          { responseType: 'blob' },
        )
        .then((response) => {
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', `rapport_transactions_${new Date()}.pdf`);
          document.body.appendChild(link);
          link.click();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    formatDate(date) {
      const d = new Date(date);
      let month = `${d.getMonth() + 1}`;
      let day = `${d.getDate()}`;
      const year = d.getFullYear();

      if (month.length < 2) month = `0${month}`;
      if (day.length < 2) day = `0${day}`;

      return [year, month, day].join('-');
    },
  },
};
</script>
