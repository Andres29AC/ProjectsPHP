paypal.Buttons({
  // Sets up the transaction when a payment button is clicked
  createOrder: (data, actions) => {
      return actions.order.create({
      purchase_units: [{
          amount: {
          value: sessionPrice
          }
      }]
      });
  },
  // Finalize the transaction after payer approval
  onApprove: (data, actions) => {
      return actions.order.capture().then(function(orderData) {
    
       //window.location.href='http://127.0.0.1:8000/hotels/success';
       window.location.href= successUrl;
      });
  }
}).render('#paypal-button-container');