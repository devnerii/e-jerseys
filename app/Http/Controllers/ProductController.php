<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use App\Models\HomePage;
use App\Models\Order;
use App\Models\Product;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public function index($slug)
    {
        $produto = Product::where('slug', $slug)->first();

        if ($produto) {
            $homePage = HomePage::where('id', $produto->home_page_id)->firstOrFail();
        } else {
            $homePage = HomePage::firstOrFail();
        }

        return view('product', [
            'produto' => $produto,
            'slug' => $slug,
            'homePage' => $homePage,
        ]);
    }

    public function all($slug, Request $request)
    {
        $homePage = HomePage::firstOrFail();

        $categorySlug = $request->query('category') ?? $slug;
        $sort_by = $request->query('sort_by');
        $search = $request->query('q');
        $category = null;

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
        }

        $produtosQuery = $homePage->products()
            ->where('is_active', true);

        info($category);

        if ($category) {
            $produtosQuery = $produtosQuery->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id);
            });
        }

        if ($search) {
            $categorySearch = Category::where('name', 'like', "%$search%")->pluck('id');
            $produtosQuery = $produtosQuery->where(function ($query) use ($search, $categorySearch) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereIn('id', function ($query) use ($categorySearch) {
                        $query->select('product_id')
                            ->from('category_product')
                            ->whereIn('category_id', $categorySearch);
                    });
            });
        }

        if ($sort_by) {
            [$sort_field, $sort_direction] = explode('_', $sort_by);
            $produtosQuery = $produtosQuery->orderBy($sort_field, $sort_direction);
        }

        $produtos = $produtosQuery->paginate(16)->withQueryString();

        $categorias = Category::where('is_active', 1)->get();

        return view('products', [
            'produtos' => $produtos,
            'categorias' => $categorias,
            'categoria' => $category,
            'sort_by' => $sort_by,
            'slug' => $slug,
            'homePage' => $homePage,
        ]);
    }

    public function cartAdd(Request $request)
    {
        $id = $request->get('id');
        $variant = $request->get('variant');
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        $cartTotal = session()->get('cart-total', 0.00);
        $hash = crc32(json_encode($variant)."$product->id");
        if (isset($cart[$id.'_'.$hash])) {
            $cart[$id.'_'.$hash]['quantity']++;
        } else {
            $cart[$id.'_'.$hash] = [
                'id' => $id,
                'name' => $product->name,
                'slug' => $product->slug,
                'hash' => $hash,
                'image' => array_reverse($product->images)[0],
                'quantity' => 1,
                'price' => $product->price,
                'variant' => $variant,
            ];
        }

        $cartTotal = 0.00;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        session()->put('cart', $cart);
        session()->put('cart-total', $cartTotal);

        return redirect()->back()->with('showCartAdd', true);
    }

    public function cartRemove($id, $hash)
    {
        $cart = session()->get('cart', []);

        $cartTotal = session()->get('cart-total', 0.00);
        if (isset($cart[$id.'_'.$hash])) {
            unset($cart[$id.'_'.$hash]);
        }

        $cartTotal = 0.00;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        session()->put('cart', $cart);
        session()->put('cart-total', $cartTotal);

        return redirect()->back()->with('showCartAdd', true);
    }

    public function cartUpdateMinus($id, $hash)
    {
        $cart = session()->get('cart', []);

        $cartTotal = session()->get('cart-total', 0.00);
        if (isset($cart[$id.'_'.$hash])) {
            $cart[$id.'_'.$hash]['quantity']--;
            if ($cart[$id.'_'.$hash]['quantity'] <= 0) {
                unset($cart[$id.'_'.$hash]);
            }
        }

        $cartTotal = 0.00;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        session()->put('cart', $cart);
        session()->put('cart-total', $cartTotal);

        return redirect()->back()->with('showCartAdd', true);
    }

    public function cartUpdatePlus($id, $hash)
    {
        $cart = session()->get('cart', []);

        $cartTotal = session()->get('cart-total', 0.00);
        if (isset($cart[$id.'_'.$hash])) {
            $cart[$id.'_'.$hash]['quantity']++;
        }

        $cartTotal = 0.00;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        session()->put('cart', $cart);
        session()->put('cart-total', $cartTotal);

        return redirect()->back()->with('showCartAdd', true);
    }

    public function cartUpdateValue($id, $hash, $value)
    {
        $cart = session()->get('cart', []);

        $cartTotal = session()->get('cart-total', 0.00);
        if (isset($cart[$id.'_'.$hash])) {
            $cart[$id.'_'.$hash]['quantity'] = $value;
            if ($cart[$id.'_'.$hash]['quantity'] <= 0) {
                unset($cart[$id.'_'.$hash]);
            }
        }

        $cartTotal = 0.00;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        session()->put('cart', $cart);
        session()->put('cart-total', $cartTotal);

        return redirect()->back()->with('showCartAdd', true);
    }

    public function checkout(Request $request)
    {

        if (! Auth::check()) {
            $redirect = session()->get('redirect', '');
            $redirect = 'checkout';
            session()->put('redirect', $redirect);

            return redirect()->route('login');
        }

        if ($request->method() == 'POST') {

            $addressType = $request->get('address_type');
            if ($addressType == 'registerd') {
                $addressId = $request->get('address_id');

                $address = Address::where('id', $addressId)->first()->toArray();
                if ($address == null) {
                    return redirect('checkout')->with('error', 'Endereço não encontrado');
                }

                session()->put('address_selected', $address);
            } else {
                $postal_code = $request->get('postal_code');
                $address = $request->get('address');
                $complement = $request->get('complement');
                $city = $request->get('city');
                $acronym_state = $request->get('acronym_state');
                $state = State::where('acronym_state', $acronym_state)->first();
                $country = $request->get('country');
                $newAddress = new Address;
                $newAddressData = [
                    'user_id' => Auth::user()->id,
                    'address' => $address,
                    'complement' => $complement,
                    'city' => $city,
                    'state' => $state->state,
                    'acronym_state' => $acronym_state,
                    'country' => $country,
                    'postal_code' => $postal_code,
                ];
                $newAddress->fill($newAddressData);
                $newAddress->save();

                if ($newAddress == null) {
                    return redirect('checkout')->with('error', 'Endereço não encontrado');
                }

                session()->put('address_selected', $newAddress->toArray());
            }
            $shipmentFee = $request->get('shipment_fee', 0.0);
            session()->put('shipment_fee', $shipmentFee);
        }

        $checkoutStep = session()->get('checkout-step', 1);
        if ($request->query('next')) {
            $checkoutStep++;
            session()->put('checkout-step', $checkoutStep);

            if ($checkoutStep == 3) {

                $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();

                $line_items = [];
                $order_items = [];
                $total = 0.00;
                foreach (session()->get('cart') as $item) {
                    $product = Product::find($item['id']);
                    $total += $product->price * $item['quantity'];
                    $line_items[] = [
                        'price_data' => [
                            'currency' => 'brl',
                            'product_data' => [
                                'name' => $product->name,
                                'metadata' => [
                                    'variants' => json_encode($item['variant']),
                                ],
                            ],
                            'unit_amount' => $product->price * 100,
                        ],
                        'quantity' => $item['quantity'],
                    ];
                    $order_items[] = [
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'variants' => $item['variant'],
                        'unit_price' => $product->price,
                        'total_price' => $product->price * $item['quantity'],
                    ];
                }

                \Stripe\Stripe::setApiKey($settings->more_configs['stripe_private_key']);
                $shipmentFee = $request->get('shipment_fee', 0.0);

                $checkout_session = \Stripe\Checkout\Session::create([
                    'line_items' => $line_items,
                    'mode' => 'payment',
                    'shipping_options' => [
                        [
                            'shipping_rate_data' => [
                                'display_name' => 'Envio padrão',
                                'fixed_amount' => [
                                    'currency' => 'brl',
                                    'amount' => $shipmentFee * 100,
                                ],
                                'type' => 'fixed_amount',
                            ],
                        ],
                    ],
                    'customer_email' => Auth::user()->email,
                    'success_url' => route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('checkout.cancel', [], true).'?session_id={CHECKOUT_SESSION_ID}',
                ]);

                $order = new Order;
                $order->fill([
                    'user_id' => Auth::user()->id,
                    'subtotal' => $total,
                    'payment_status' => 'new',
                    'payment_id' => $checkout_session->id,
                    'shipment_fee' => $shipmentFee,
                    'status' => 'new',
                    'address' => session()->get('address_selected')['address'],
                    'complement' => session()->get('address_selected')['complement'],
                    'city' => session()->get('address_selected')['city'],
                    'state' => session()->get('address_selected')['state'],
                    'acronym_state' => session()->get('address_selected')['acronym_state'],
                    'country' => session()->get('address_selected')['country'],
                    'postal_code' => session()->get('address_selected')['postal_code'],
                ]);

                if ($order->save()) {
                    $order->items()->createMany($order_items);
                }

                session()->forget('checkout-step');

                return redirect($checkout_session->url);
            }

            return redirect('checkout');
        }
        if ($request->query('prev')) {
            $checkoutStep--;
            $checkoutStep = max(1, $checkoutStep);
            session()->put('checkout-step', $checkoutStep);

            return redirect('checkout');
        }
        if ($checkoutStep <= 1 || $checkoutStep > 3) {
            $checkoutStep = 1;
            session()->put('checkout-step', $checkoutStep);

        }

        return view('checkout', [
            'checkoutStep' => $checkoutStep,
        ]);
    }

    public function success(Request $request)
    {
        $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();
        \Stripe\Stripe::setApiKey($settings->more_configs['stripe_private_key']);
        try {
            $checkout_session = \Stripe\Checkout\Session::retrieve($request->query('session_id'));
            $order = Order::where('payment_id', $checkout_session->id)->first();
            if (! $order) {
                throw new NotFoundHttpException;
            }
            if ($order->payment_status == 'unpaid' || $order->payment_status == 'new') {
                $order->payment_status = 'paid';
                $order->save();
            }

            session()->forget('cart');
            session()->forget('cart-total');
            session()->forget('address_selected');
            session()->forget('checkout-step');
        } catch (\Exception) {
            throw new NotFoundHttpException;
        }

        return view('checkout-success');
    }

    public function cancel(Request $request)
    {
        $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();
        \Stripe\Stripe::setApiKey($settings->more_configs['stripe_private_key']);
        try {
            $checkout_session = \Stripe\Checkout\Session::retrieve($request->query('session_id'));
            $order = Order::where('payment_id', $checkout_session->id)->first();
            if (! $order) {
                throw new NotFoundHttpException;
            }
            if ($order->payment_status == 'unpaid' || $order->payment_status == 'paid' || $order->payment_status == 'new') {
                $order->payment_status = 'cancelled';
                $order->save();
            }

            session()->forget('cart');
            session()->forget('cart-total');
            session()->forget('address_selected');
            session()->forget('checkout-step');
        } catch (\Exception) {
            throw new NotFoundHttpException;
        }

        return view('checkout-cancel');
    }

    public function webhook(Request $request)
    {
        $settings = \Joaopaulolndev\FilamentGeneralSettings\Models\GeneralSetting::first();
        $stripe = new \Stripe\StripeClient($settings->more_configs['stripe_private_key']);
        $payload = $request->getContent();
        $endpoint_secret = $settings->more_configs['stripe_webhook_secret_key'];
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

        switch ($event->type) {
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;

                $checkout_session = $stripe->checkout->sessions->all(['payment_intent' => $paymentIntent->id]);
                $order = Order::where('payment_id', $checkout_session->data[0]->id)->first();
                if (! $order) {
                    throw new \Exception('Order not found');
                }
                $order->payment_status = 'unpaid';
                $order->save();
                break;
            case 'checkout.session.completed':
                $paymentIntent = $event->data->object;
                $order = Order::where('payment_id', $paymentIntent->id)->first();
                if (! $order) {
                    throw new \Exception('Order not found');
                }
                $order->payment_status = 'paid';
                $order->save();
                break;

            default:
                echo 'Received unknown event type '.$event->type;
        }

        return response('', 200);
    }
}
