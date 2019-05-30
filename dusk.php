<?php

// HTML...
// <profile dusk="profile-component"></profile>
// // Component Definition...
// Vue.component('profile', {
//     template: '<div>{{ user.name }}</div>',
//     data: function () {
//         return {
//             user: {
//               name: 'Taylor'
//             }
//         };
//     }
// });

public function testVue()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->assertVue('user.name', 'Taylor', '@profile-component');
    });
}
?>

<form action="your-server-side-code" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_GFTyo5v7WVZXXv5rBMiByuee"
    data-amount="999"
    data-name="YourCompany Test"
    data-description="Example charge"
    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
    data-locale="auto">
  </script>
</form>

<?php

/** @test */
public function it_asserts_that_user_can_pay_via_stripe(){
    $this->browse(function ($browser) {
        $browser->visit('/payment/page')
                ->assertSee('Pay with Card')
                ->press('Pay with Card')
                ->waitFor('iframe[name=stripe_checkout_app]')
                ->withinFrame('iframe[name=stripe_checkout_app]', function($browser){
                   $browser->pause(2000);
                   $browser->keys('input[placeholder="Email"]', 'your.email@gmail.com')
                       ->keys('input[placeholder="Card number"]', '4242 4242 4242 4242')
                       ->keys('input[placeholder="MM / YY"]', '0122')
                       ->keys('input[placeholder="CVC"]', '123')
                       ->press('button[type="submit"')
                       ->waitUntilMissing('iframe[name=stripe_checkout_app]');
            });
    });
}