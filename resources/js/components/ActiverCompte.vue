<template>
  <section class="pricing py-5">
    <div class="container">
      <p
        id="activer-title"
        class="h1 text-warning"
      >
        veuillez choisir un plan pour activer votre abonnement !
      </p>
      <div class="row">
        <!-- Standard -->
        <div class="col">
          <div class="card mb-5 mb-lg-0">
            <div class="card-body">
              <h5 class="card-title text-muted text-uppercase text-center">
                Standard
              </h5>
              <h6 class="card-price text-center">
                20$
                <span class="period">pour 1 an</span>
              </h6>
              <hr>
              <ul class="fa-ul" />
              <form
                id="payment-form"
                method="POST"
                :action="urlPayement"
              >
                <!-- Hidden input -->
                <input
                  type="hidden"
                  name="productsAll[1][quantity]"
                  value="1"
                >
                <input
                  type="hidden"
                  name="productsAll[1][id]"
                  value="1"
                >
                <input
                  type="hidden"
                  name="description"
                  value="activation de l'abonnement crabe"
                >
                <input
                  type="hidden"
                  name="_token"
                  :value="csrf"
                >
                <p>
                  <input
                    type="submit"
                    value="S'abonner"
                    class="btn btn-block btn-primary text-uppercase"
                  >
                </p>
              </form>
            </div>
          </div>
        </div>
        <!-- Plus  -->
        <div class="col">
          <div class="card mb-5 mb-lg-0">
            <div class="card-body">
              <h5 class="card-title text-muted text-uppercase text-center">
                Plus
              </h5>
              <h6 class="card-price text-center">
                60$
                <span class="period">pour 4 ans</span>
              </h6>
              <hr>
              <ul class="fa-ul" />
              <form
                id="payment-form"
                method="POST"
                :action="urlPayement"
              >
                <input
                  type="hidden"
                  name="productsAll[1][quantity]"
                  value="1"
                >
                <input
                  type="hidden"
                  name="productsAll[1][id]"
                  value="2"
                >
                <input
                  type="hidden"
                  name="description"
                  value="activation de l'abonnement crabe"
                >
                <input
                  type="hidden"
                  name="_token"
                  :value="csrf"
                >
                <p>
                  <input
                    type="submit"
                    value="S'abonner"
                    class="btn btn-block btn-primary text-uppercase"
                  >
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Activer',
  props: {
    url: String,
  },
  data() {
    return {
      urlPayement: `${this.url}/payaccount`,
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    };
  },
  mounted() {
  },
  methods: {
  },
};
</script>
