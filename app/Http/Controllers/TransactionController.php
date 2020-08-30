<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use App\AppTransaction;
use App\Log;
use App\Mail\Receipt;
use Mail;
use Illuminate\Support\Facades\Auth;
use App\Product;

/**
 * paypal v2
 */
use App\Http\Controllers\Paypal\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class TransactionController extends Controller
{
    private $_api_context;
    private $log;
    private $appTransaction;
    private const CURRENCY = "CAD";
    private const LOCALE_CODE = "fr-CA";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    public function index()
    {
        return view('paypal/paywithpaypal');
    }

    /**
    * Paypal transaction handler for the Cart component
    */
    public function createPaypalCartOrder(Request $request)
    {
        /**
         *
         * build items
         */
        $buildResult = $this->BuildItemList();
    
        /**
         * Create order request to paypal
         */
        $request = new OrdersCreateRequest();
        $request->headers["prefer"] = "return=representation";
        $description = "C.R.A.B.E cart payement";
        $request->body = self::buildRequestBodyCart($buildResult[0], $description, $buildResult[1], $buildResult[2]);
        
        try {
            $client = PayPalClient::client();
            $order = $client->execute($request);
            $statusCode = $order->statusCode;
        } catch (HttpException $exception) {
            \Session::put('error', 'error while processing paypal cart order');
            $message = json_decode($exception->getMessage(), true);
            $statusCode = $exception->statusCode;
            $this->processErrorPayment('error while processing paypal cart order', 
                        $message, null, $statusCode, null);
        }

        if ($statusCode == 201) {
            $redirect_url = $this->getauthorizeUrl($order);

            if (!empty($redirect_url)) {
                $this->saveOrderTransaction($order, $buildResult[2], $buildResult[0]);
                return Redirect::away($redirect_url);
            }
        }

        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/home')->with('error', __('transaction.unknown'));
    }
        /**
    * Paypal transaction handler for the Account activation component
    */
    public function createOrderAccountActivation(Request $request)
    {
        $validatedData = $request->validate([
            'productsAll' => 'array|required',
            'description' => 'string|required',
        ]);

        $products = $validatedData["productsAll"];
        $description = $validatedData["description"];
        
        /**
         *
         * build items
         */
        $items = array();
        $total = 0.00;
        foreach ($products as &$productValue) {
            $product = Product::find($productValue['id']);
            $product["count"] = 1;
            $total += (float)$product->price*(int)$productValue['quantity'];

            $item = array();
            $item['name'] = $product->name;
            $item['unit_amount'] = array('currency_code' => Self::CURRENCY, 'value' => $product->price);
            $item['description'] = $description;
            $item['quantity'] = (int)$productValue['quantity'];
            array_push($items, $item);
        }

        $request = new OrdersCreateRequest();
        $request->headers["prefer"] = "return=representation";
        $request->body = self::buildRequestBody($products, $description, $items, $total);

        try {
            $client = PayPalClient::client();
            $order = $client->execute($request);
            $statusCode = $order->statusCode;
        } catch (HttpException $exception) {
            \Session::put('error', 'error while processing paypal account activation order');
            $message = json_decode($exception->getMessage(), true);
            $statusCode = $exception->statusCode;
            $this->processErrorPayment('error while processing paypal account activation order', 
                        $message, null, $statusCode, null);
        }

        
        if ($statusCode == 201) {
            $redirect_url = $this->getauthorizeUrl($order);

            if (!empty($redirect_url)) {
                $this->saveOrderTransaction($order, $total, [$product]);
                return Redirect::away($redirect_url);
            }
        }

        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/home')->with('error', __('transaction.unknown'));
    }


    public function capturePaypalCartOrder(Request $request)
    {
     
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            $this->processErrorPayment('PayerID or token not found for cart order capture', 
                        null, Input::get('PayerID'), null, Input::get('token'));
            return Redirect::to('activer')->with('error', 'transaction failed or canceled , please try again');
        }

        $capturedRequest = new OrdersCaptureRequest(Input::get('token'));

        try {
            $client = PayPalClient::client();
            $orderCapture = $client->execute($capturedRequest);
            $statusCode = $orderCapture->statusCode;
        } catch (HttpException $exception) {
            $message = json_decode($exception->getMessage(), true);
            $statusCode = $exception->statusCode;
            \Session::put('error', 'Some error occur, sorry for inconvenience');
            $this->processErrorPayment('error while processing paypal cart order capture', 
                        $message, Input::get('PayerID'), $statusCode, Input::get('token'));
        }
        if ($statusCode == 201 && $orderCapture->result->status == 'COMPLETED') {
            $this->updateProductQuantity($orderCapture->result);
            return Redirect::to('home')->with('message', 'transaction succeded a receipt will be sent to you by email');
        }

        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('activer')->with('error', __('transaction.unknown'));
    }


    public function captureAccountActivationOrder(Request $request)
    {
        $userIdData['user_id'] = Auth::id();

    
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            $this->processErrorPayment('PayerID or token not found account activation order capture', 
                        null, Input::get('PayerID'), null, Input::get('token'));
            return Redirect::to('activer')->with('error', 'transaction failed or canceled , please try again');
        }

        $capturedRequest = new OrdersCaptureRequest(Input::get('token'));

        try {
            $client = PayPalClient::client();
            $orderCapture = $client->execute($capturedRequest);
            $statusCode = $orderCapture->statusCode;
        } catch (HttpException $exception) {
            $message = json_decode($exception->getMessage(), true);
            $statusCode = $exception->statusCode;
            \Session::put('error', 'Some error occur, sorry for inconvenience');
            $this->processErrorPayment('error while processing account activation order capture', 
                        $message, Input::get('PayerID'), $statusCode, Input::get('token'));
        }
        if ($statusCode == 201 && $orderCapture->result->status == 'COMPLETED') {
            $this->activateSubscription($orderCapture->result);
            return Redirect::to('home')->with('message', 'transaction succeded a receipt will be sent to you by email');
        }

        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('activer')->with('error', __('transaction.unknown'));
    }

    /**
        * Setting up the JSON request body for creating the Order. The Intent in the
        * request body should be set as "CAPTURE" for capture intent flow.
        * this is used for the account activation
    */
    private static function buildRequestBodyCart($products, $description, $items, $total)
    {
        $application_context = array();

        $application_context['return_url'] = URL::to('statustransaction');
        $application_context['cancel_url'] = URL::to('cart');
        $application_context['brand_name'] = env('APP_NAME', '');
        $application_context['locale'] = Self::LOCALE_CODE;
        $application_context['user_action'] = 'PAY_NOW';
        
        $purchase_units = array(array(
            'description' => $description,
            'amount' => array(
                'currency_code' => Self::CURRENCY,
                'value' => $total,
                'breakdown' => array('item_total'=> array(
                    'currency_code' => Self::CURRENCY,
                    'value' => $total))
                ),
                'items' => $items
            ),
            
        );

        return array(
            'intent' => 'CAPTURE',
            'application_context' => $application_context,
            'purchase_units' => $purchase_units
        );
    }
    /**
     * build products as items to send for the transaction 
     */
    private function BuildItemList()
    {
        $items = array();
        $total = 0.00;
        $user = Auth::user();
        $cart = $user->cart;
        $products = [];
        $uniqueIds = [];

        
        foreach ($cart->products as $product) {
            if (!array_key_exists($product->id, $uniqueIds)) {
                $uniqueIds[$product->id] = 1;
                array_push($products, $product);
            } else {
                $uniqueIds[$product->id] = $uniqueIds[$product->id] + 1;
            }
        }
    
        $newProducts = [];
        foreach ($products as $product) {
            $product["count"] = $uniqueIds[$product->id];
            array_push($newProducts, $product);
        }
 
        foreach ($newProducts as $product) {
            if (((int)$product->quantity - (int)$product->count) > 0) {
                $total += (float)$product->price*(int)$product->count;
                $item = array();
                $item['name'] = $product->name;
                $item['unit_amount'] = array('currency_code' => Self::CURRENCY, 'value' => $product->price);
                $item['description'] = $product->description;
                $item['quantity'] = (int)$product->count;
                array_push($items, $item);
            } else {
                return Redirect::to('/home')->with('error', "the quantity of this pruduct ".$product->name."is not availble," .(int)$product->quantity."  are left");
            }
        }

        return array($newProducts, $items, $total);
    }

    /**
     * save order transaction to db
     */
    private function saveOrderTransaction($order, $total, $products)
    {
        $this->appTransaction = new AppTransaction();
        $this->appTransaction->user_id = Auth::id();
        $this->appTransaction->statusCode = $order->statusCode;
        $this->appTransaction->status = $order->result->status;
        $this->appTransaction->orderId = $order->result->id;
        $this->appTransaction->intent = $order->result->intent;
        $this->appTransaction->total = $total;
        $this->appTransaction->products = $products;
        $this->appTransaction->save();
    }
    
    /**
     * find the paypal authorize url to redirect the client
     * and return it
     */
    private function getauthorizeUrl($response)
    {
        foreach ($response->result->links as $link) {
            if ($link->rel == 'approve') {
                $redirect_url = $link->href;
                break;
            }
        }
        if (isset($redirect_url)) {
            return $redirect_url;
        }

        return null;
    }

    /**
     * Setting up the JSON request body for creating the Order. The Intent in the
     * request body should be set as "CAPTURE" for capture intent flow.
     * this is used for the account activation
     */
    private static function buildRequestBody($products, $description, $items, $total)
    {
        $application_context = array();

        $application_context['return_url'] = URL::to('statusactivation');
        $application_context['cancel_url'] = URL::to('activer');
        $application_context['brand_name'] = env('APP_NAME', '');
        $application_context['locale'] = Self::LOCALE_CODE;
        $application_context['user_action'] = 'PAY_NOW';
        
        $purchase_units = array(array(
            'description' =>'activation de compte crabe',
            'amount' => array(
                'currency_code' => Self::CURRENCY,
                'value' => $total,
                'breakdown' => array('item_total'=> array(
                    'currency_code' => Self::CURRENCY,
                    'value' => $total))
                ),
                'items' => $items
            ),
            
        );

        return array(
            'intent' => 'CAPTURE',
            'application_context' => $application_context,
            'purchase_units' => $purchase_units
        );
    }
    
    /**
     * update the quantity of products availble after client transaction
    */
    public function updateProductQuantity($result)
    {
        $user = Auth::user();
        $cart = $user->cart;
        $products = [];
        $appTransaction = AppTransaction::where('orderId', $result->id)->firstOrFail();

        foreach ($appTransaction->products as $productValue) {
            $product = Product::findOrFail($productValue['id']);
            array_push($products, $product);
            if ((int)$product->quantity - (int)$productValue['count'] > 0) {
                $product->removeQuantity($productValue['count']);
            } else {
                $appTransaction->status = __('transaction.quantity').__('transaction.quantity2');
                $appTransaction->save();
                return Redirect::to('/home')->with('error', __('transaction.quantity').$product->name.__('transaction.quantity2'));
            }
        }
       
        /**
         * update transaction
         */
        $appTransaction->status = $result->status;
        $appTransaction->payer_id = $result->payer->payer_id;
        $appTransaction->capture_id = $result->purchase_units[0]->payments->captures[0]->id;
        $appTransaction->net_amount = $result->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->net_amount->value;
        $appTransaction->paypal_fee = $result->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value;
        $appTransaction->save();
        $cart->clear();

        \Session::put('success', 'Payment success');

        /**
         * Send receipt to user
        */
        Mail::to($user)->send(new Receipt($user->firstName, $appTransaction->products, $appTransaction->total, $appTransaction->created_at));
    }
    /**
     * handle activation payement success
     */
    public function activateSubscription($result)
    {
        $user = Auth::user();
        $subscriptionAmount = $result->purchase_units[0]->payments->captures[0]->amount->value;


        $appTransaction = AppTransaction::where('orderId', $result->id)->firstOrFail();
        $appTransaction->status = $result->status;
        $appTransaction->payer_id = $result->payer->payer_id;
        $appTransaction->capture_id = $result->purchase_units[0]->payments->captures[0]->id;
        $appTransaction->net_amount = $result->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->net_amount->value;
        $appTransaction->paypal_fee = $result->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value;
        $appTransaction->save();

        $productSubscribe1 = Product::find(1);
        $productSubscribe2 = Product::find(2);

        if (intval($subscriptionAmount) === intval($productSubscribe1->price)) {
            $user->subscribeOneYear();
        } elseif (intval($subscriptionAmount) === intval($productSubscribe2->price)) {
            $user->subscribeFourYears();
        }

        \Session::put('success', 'Payment success');

        /**
         * Send receipt to user
        */
        Mail::to($user)->send(new Receipt($user->firstName, $appTransaction->products, $appTransaction->total, $appTransaction->created_at));
    }


    /**
     * handle error in the payement execution
     */
    public function processErrorPayment($location, $message = null, $payer_id = null, $statusCode = null, $orderId = null)
    {
        $log = new Log();
        $log->user_id = Auth::id();
        $log->location = $location;
        $log->message = $message;
        $log->payer_id = $payer_id;
        $log->orderId = $orderId;
        $log->statusCode = $statusCode;
        $log->save();
        \Session::put('error', $location);
    }
}
