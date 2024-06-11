<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;
use Stripe\Climate\Order as ClimateOrder;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function checkout(Request $request, $id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $order = order::findOrFail($id);
        if ($order->paid) {
            return redirect()->back();
        }
        $lineItems = [];
        foreach ($order->products as $orderProduct) {
            $lineItem = [
                'price_data' => [
                    'currency' => 'EGP',
                    'product_data' => [
                        'name' => $orderProduct->product->name,
                    ],
                    'unit_amount' => $orderProduct->product->price * 100,
                ],
                'quantity' => $orderProduct->quantity,
            ];
            $lineItems[] = $lineItem;
        }
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_creation' => 'always',
            'success_url' => route('checkout.success') . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel') . "?session_id={CHECKOUT_SESSION_ID}",
        ]);
        $order->session_id = $checkout_session->id;
        $order->save();
        return redirect($checkout_session->url);
    }

    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);
        // dd($request->session_id);
        // $customer = $stripe->customers->retrieve($session->customer);
        if ($session) {
            $order = order::where('session_id', $request->session_id)->first();
            $order->paid = 1;
            $order->save();
            return redirect(route('order.show', $order->id));
        } else {
            return redirect('/');
        }
    }
    public function cancel(Request $request)
    {
        $order = order::where('session_id', $request->session_id)->first();
        return redirect(route('order.show', $order->id));
    }
    public function webhook(Request $request)
    {

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $order = order::where('session_id', $session->id)->first();
                $order->paid = 1;
                $order->save();
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('');
    }
}