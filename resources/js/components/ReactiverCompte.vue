<template>
  <section class="pricing py-5">
    <div class="container">
      <p
        class="h1 text-warning"
      >Votre abonnement a expire veillez choisir votre plan pour reactiver votre veuillez !</p>
      <div class="row">
        <!-- Standard -->
        <div class="col">
          <div class="card mb-5 mb-lg-0">
            <div class="card-body">
              <h5 class="card-title text-muted text-uppercase text-center">Standard</h5>
              <h6 class="card-price text-center">
                20$
                <span class="period">pour 1 an</span>
              </h6>
              <hr>
              <ul class="fa-ul">
                <li>
                  <span class="fa-li">
                    <i class="fas fa-check"></i>
                  </span>Single User
                </li>
                <li>
                  <span class="fa-li">
                    <i class="fas fa-check"></i>
                  </span>5GB Storage
                </li>
                <li class="text-muted">
                  <span class="fa-li">
                    <i class="fas fa-times"></i>
                  </span>Unlimited Private Projects
                </li>
              </ul>
              <form method="POST" id="payment-form" v-bind:action="urlPayement">
              <input type="hidden" name="_token" :value="csrf">
              <input type="hidden" name=amount value="20">
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
              <h5 class="card-title text-muted text-uppercase text-center">Plus</h5>
              <h6 class="card-price text-center">
                60$
                <span class="period">pour 4 ans</span>
              </h6>
              <hr>
              <ul class="fa-ul">
                <li>
                  <span class="fa-li">
                    <i class="fas fa-check"></i>
                  </span>
                  <strong>5 Users</strong>
                </li>
                <li>
                  <span class="fa-li">
                    <i class="fas fa-check"></i>
                  </span>50GB Storage
                </li>
              </ul>
              <form method="POST" id="payment-form" v-bind:action="urlPayement">
              <input type="hidden" name="_token" :value="csrf">
              <input type="hidden" name=amount value="60">
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
  name: "reactiver-compte",
  props: {
    url: String
  },
  data() {
    return {
        urlPayement: this.url+"/paypal",
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    };
  },
  mounted() {
    console.log(this.url);
  },
  methods: {
  }
};
</script>
