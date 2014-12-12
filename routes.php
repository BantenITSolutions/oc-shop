<?php

use DShoreman\Shop\Models\Order as ShopOrder;
use DShoreman\Shop\Models\Settings;

Route::group(['prefix' => 'shop'], function()
{
    Route::post('order/payment/process', function()
    {
        $token = post('stripeToken');
        $orderId = Session::get('orderId');

        if (is_null($orderId) || !$order = ShopOrder::find($orderId)) {

            // If order ID is null, the user probably went straight to the payment page without
            // the basket's onCheckout method being fired, thus the order does not exist.
            Flash::error("Something went wrong when creating your order, please checkout again."
                         . " If the problem persists, contact the site administrator.");

            return Redirect::to('basket');
        }

        $order->email = Input::get('stripeEmail');
        $order->stripe_token = $token;

        $order->billing_name = post('stripeBillingName');
        $order->billing_street = post('stripeBillingAddressLine1');
        $order->billing_town = post('stripeBillingAddressCity');
        $order->billing_county = post('stripeBillingAddressState');
        $order->billing_postcode = post('stripeBillingAddressZip');
        $order->billing_country = post('stripeBillingAddressCountry');

        $order->shipping_name = post('stripeShippingName');
        $order->shipping_street = post('stripeShippingAddressLine1');
        $order->shipping_town = post('stripeShippingAddressCity');
        $order->shipping_county = post('stripeShippingAddressState');
        $order->shipping_postcode = post('stripeShippingAddressZip');
        $order->shipping_country = post('stripeShippingAddressCountry');

        Settings::get('stripe_active_keys') == 'live'
                 ? Stripe::setApiKey(Settings::get('stripe_live_sec_key'))
                 : Stripe::setApiKey(Settings::get('stripe_test_sec_key'));

        try {
            $charge = Stripe_Charge::create([
                'amount' => $order->total * 100,
                'currency' => 'gbp',
                'card' => $token,
            ]);

            $order->is_paid = true;
            $order->save();
        }
        catch (Stripe_CardError $e)
        {
            $error = $e->getJsonBody()['error'];
            Flash::error($error['message']);

            $order->save();

            Redirect::to('shop/checkout/payment/'.$orderId)->withInput();
        }

        return Redirect::to('shop/order/'.$orderId);
    });

});
