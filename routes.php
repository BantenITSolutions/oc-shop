<?php

use DShoreman\Shop\Models\Order as ShopOrder;

Route::group(['prefix' => 'shop'], function()
{
    Route::post('order/payment/process', function()
    {
        $token = post('stripeToken');
        $orderId = Session::get('orderId');

        if (!$order = ShopOrder::find($orderId)) {

            // Todo: Add some flash data and utilise the ajax stuff instead of redirect
            return Redirect::to('shop/checkout/payment/'.$orderId);
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

        Stripe::setApiKey('sk_test_NHbBmLzRSL7G06gpyLVraQ2Z');

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
