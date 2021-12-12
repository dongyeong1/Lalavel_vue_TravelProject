<template>
  <div>
    <div class="layer"></div>
    <div class="layer">
      <!-- <div id="paypal-button-container"></div>
      -->
      <div ref="paypal"></div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["categories", "subcategories", "price"],
  data() {
    return {
      product: {
        description: "this test app",
        price: this.price / 100,
      },

      // form: new Form({
      //   email: "",
      //   title: "",
      //   url: "",
      //   shortdesc: "",
      //   desc: "",
      //   paidFor: true,
      //   category_id: 1,
      //   subcategory_id: "",
      // }),
    };
  },
  mounted() {
    // window.paypal.Buttons().render("#paypal-button-container");
    window.paypal
      .Buttons({
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [
              {
                description: this.product.description,
                amount: {
                  currency_code: "USD",
                  value: this.product.price,
                },
              },
            ],
          });
        },
        onApprove: async () => {
          alert("결제완료");
          this.$emit("paypalll");
        },
        // onApprove: async (data, actions, resp) => {
        //   const order = await actions.order.capture();
        //   this.data,
        //     // this.paidFor=true;
        //     // this.loading=false;
        //     this.submitDomain();
        // },
        // onError: (err) => {
        //   console.log(err);
        // },
      })
      .render(this.$refs.paypal);
  },
};
</script>