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

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }
    public function index()
    {
        return view('paypal/paywithpaypal');
    }
    public function transactionPayement(Request $request)
    {
        $listOfProducts = array();
        $total = 0.00;
        
        $user = Auth::user();
        $cart = $user->cart;
    
        $userIdData['user_id'] = Auth::id();
        $this->log = new Log($userIdData);
        $this->appTransaction = new AppTransaction($userIdData);
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');  

        $products = [];
        $uniqueIds = [];
        foreach($cart->products as $product){

            if(!array_key_exists($product->id,$uniqueIds)){
                $uniqueIds[$product->id] = 1;
                array_push($products ,$product);
            }else{
                $uniqueIds[$product->id] = $uniqueIds[$product->id] + 1;
            }
        }
    
        $newProducts = [];
        foreach($products as $product){
            $product["count"] = $uniqueIds[$product->id];
            array_push($newProducts ,$product);
        }
 
        foreach ($newProducts as $product) {

            if(((int)$product->quantity - (int)$product->count ) > 0){
                $total += (float)$product->price*(int)$product->count;
                $item_1 = new Item();
    
                $item_1->setName($product->name) 
                    ->setCurrency(self::CURRENCY)
                    ->setQuantity($product->count)
                    ->setPrice($product->price); 
    
                array_push($listOfProducts,$item_1);
            }else{
               return Redirect::to('/home')->with('error', "the quantity of this pruduct ".$product->name."is not availble," .(int)$product->quantity."  are left");
           }
           
        }

        $item_list = new ItemList();
        $item_list->setItems($listOfProducts);

        $amount = new Amount();
        $amount->setCurrency(self::CURRENCY)
            ->setTotal($total);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription("achat de pieces");

        // TODO put the right redirect url for each transaction type
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('statustransaction')) 
            ->setCancelUrl(URL::to('cart'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        
        

        try {

            $payment->create($this->_api_context);
           
        } catch (\PayPal\Exception\PPConnectionException $ex) {

            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                $this->log->status = 'failed';
                $this->log->message = $payment->getFailureReason();
                $this->log->paymentId = $payment->getId();
                $this->log->token = $payment->getToken();
                $this->log->code=  $ex->getCode();
                $this->log->save();

                $this->appTransaction->status = 'failed';
                $this->appTransaction->save();
                // TODO put the right redirect url for each transaction type
                return Redirect::to('/home')->with('error', __('transaction.unknown'));;

            } else {

                \Session::put('error', 'Some error occur, sorry for inconvenient');
                $this->log->status = 'failed';
                $this->log->message = $payment->getFailureReason() ;;
                $this->log->paymentId = $payment->getId();
                $this->log->token = $payment->getToken();
                $this->log->code=  $ex->getCode();
                $this->log->save();

                $this->appTransaction->status = 'failed';
                $this->appTransaction->save();
                // TODO put the right redirect url for each transaction type
                return Redirect::to('/home')->with('error', __('transaction.unknown'));;

            }

        }
    
        foreach ($payment->getLinks() as $link) {

            if ($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();
                break;

            }

        }

        /** add payment ID to session **/
        \Session::put('paypal_payment_id', $payment->getId());

        
        if (isset($redirect_url)) {
            // save the transaction to database
            $this->appTransaction->paymentId = $payment->getId();
            $this->appTransaction->token = $payment->getToken();
            $this->appTransaction->total = $total;
            $this->appTransaction->products = $newProducts;
            $this->appTransaction->status = 'waiting on client authorization';
            $this->appTransaction->save();

            $this->log->status = $payment->getState();
                $this->log->message = (empty($payment->getFailureReason())? "redirecting to paypakl succeded":$payment->getFailureReason());
                $this->log->paymentId = $payment->getId();
                $this->log->token = $payment->getToken();
                $this->log->save();
            /** redirect to paypal **/
            return Redirect::away($redirect_url)->with('error', $payment->getId());

        }

        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/home')->with('error', __('transaction.unknown'));
    }


    public static function captureOrder(Request $request)
    {
        
        return response()->json($request);
        $capturedRequest = new OrdersCaptureRequest($request->result->id);

        $client = PayPalClient::client();
        $response = $client->execute($capturedRequest);
        if ($debug)
        {
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Links:\n";
            foreach($response->result->links as $link)
            {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }
            print "Capture Ids:\n";
            foreach($response->result->purchase_units as $purchase_unit)
            {
                foreach($purchase_unit->payments->captures as $capture)
                {    
                    print "\t{$capture->id}";
                }
            }
            // To toggle printing the whole response body comment/uncomment below line
            echo json_encode($response->result, JSON_PRETTY_PRINT), "\n";
        }

        return $response;
    }

    /**
     * 
     */
    public function createOrderAccountActivation(Request $request)
    {   
        $validatedData = $request->validate([
            'products' => 'array|required',
            'description' => 'string|required',
        ]);

        $products = $validatedData["products"];
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
            array_push($items,$item);
        }

        $request = new OrdersCreateRequest();
        $request->headers["prefer"] = "return=representation";
        $request->body = self::buildRequestBody($products, $description, $items, $total);

        try{
            $client = PayPalClient::client();
            $order = $client->execute($request);
            $statusCode = $order->statusCode;
        }
        catch(HttpException $exception){
            $message = json_decode($exception->getMessage(), true);
            $statusCode = $exception->statusCode;
            //TODO save logs to db
        }

        
        if($statusCode == 201){
            $redirect_url = $this->getauthorizeUrl($order);

            if (!empty($redirect_url)) {
                $this->saveOrderTransaction($order, $total, [$product]);
                return Redirect::away($redirect_url);
            }
        }

        return response()->json([$message,$request->body]);
    }

    /**
     * save order transaction to db 
     */
    private function saveOrderTransaction($order, $total, $products){
   
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
    private function getauthorizeUrl($response){

        foreach($response->result->links as $link)
        {
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
        $application_context['brand_name'] = 'Crabe ETS';
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

    public function payAccountActivation(Request $request)
    {
        $listOfProducts = array();
        $total = 0.00;
        $userIdData['user_id'] = Auth::id();
        $this->log = new Log($userIdData);
        $this->appTransaction = new AppTransaction($userIdData);
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $validatedData = $request->validate([
            'products' => 'array|required',
            'description' => 'string|required',
        ]);
        
        $products = $validatedData["products"];
        $description = $validatedData["description"];

        foreach ($products as &$productValue) {

            $product = Product::find($productValue['id']);
            $product["count"] = 1;
            $total += (float)$product->price*(int)$productValue['quantity'];
            $item_1 = new Item();

            $item_1->setName($product->name) 
                ->setCurrency(self::CURRENCY)
                ->setQuantity($productValue['quantity'])
                ->setPrice($product->price); 

            array_push($listOfProducts,$item_1);
        }

        $products = [$product];

        $item_list = new ItemList();
        $item_list->setItems($listOfProducts);

        $amount = new Amount();
        $amount->setCurrency(self::CURRENCY)
            ->setTotal($total);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($description);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('statusactivation')) 
            ->setCancelUrl(URL::to('activer'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
      

        try {

            $payment->create($this->_api_context);
           
        } catch (\PayPal\Exception\PPConnectionException $ex) {

            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                $this->log->status = 'failed';
                $this->log->message = $payment->getFailureReason();
                $this->log->paymentId = $payment->getId();
                $this->log->token = $payment->getToken();
                $this->log->code=  $ex->getCode();
                $this->log->save();

                $this->appTransaction->status = 'failed';
                $this->appTransaction->save();
                // TODO put the right redirect url for each transaction type
                return Redirect::to('/home')->with('error', __('transaction.unknown'));;

            } else {

                \Session::put('error', 'Some error occur, sorry for inconvenient');
                $this->log->status = 'failed';
                $this->log->message = $payment->getFailureReason() ;;
                $this->log->paymentId = $payment->getId();
                $this->log->token = $payment->getToken();
                $this->log->code=  $ex->getCode();
                $this->log->save();

                $this->appTransaction->status = 'failed';
                $this->appTransaction->save();
                // TODO put the right redirect url for each transaction type
                return Redirect::to('/home')->with('error', __('transaction.unknown'));;

            }

        }
  
        foreach ($payment->getLinks() as $link) {

            if ($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();
                break;

            }

        }

        /** add payment ID to session **/
        \Session::put('paypal_payment_id', $payment->getId());

        
        if (isset($redirect_url)) {
            // save the transaction to database
            $this->appTransaction->paymentId = $payment->getId();
            $this->appTransaction->token = $payment->getToken();
            $this->appTransaction->total = $total;
            $this->appTransaction->products = $products;
            $this->appTransaction->status = 'waiting on client authorization';
            $this->appTransaction->save();

            $this->log->status = $payment->getState();
                $this->log->message = (empty($payment->getFailureReason())? "redirecting to paypakl succeded":$payment->getFailureReason());
                $this->log->paymentId = $payment->getId();
                $this->log->token = $payment->getToken();
                $this->log->save();
            /** redirect to paypal **/
            return Redirect::away($redirect_url)->with('error', $payment->getId());

        }

        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/home')->with('error', __('transaction.unknown'));

    }

    /**
     * process payment trasaction after client authorization
    */
    public function getTransactionStatus(){

        $userIdData['user_id'] = Auth::id();

        /** Get the payment ID and clear it from session **/
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        //process errors
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            $this->processErrorPayment($userIdData,'home', 'transaction failed or canceled , please try again');
            return Redirect::to('home')->with('error', 'transaction failed or canceled , please try again');
        }

        /**Execute the payment **/
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {

            $this->updateProductQuantity($userIdData,$result);
            return Redirect::to('home')->with('message', 'transaction succeded a receipt will be sent to you by email');

        }

        $this->processErrorPayment($userIdData,'activer', __('transaction.unknown'));
        return Redirect::to('home')->with('error', __('transaction.unknown'));


    }
    /**
     * process the account activation payment 
     */
    public function getPaymentStatusActivation()
    {
        $userIdData['user_id'] = Auth::id();

        /** Get the payment ID and clear it from session **/
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        //process errors
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            $this->processErrorPayment($userIdData,'activer', 'transaction failed or canceled , please try again');
            return Redirect::to('activer')->with('error', 'transaction failed or canceled , please try again');
        }

        /**Execute the payment **/
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {

            $this->activateSubscription($userIdData,$result);
            return Redirect::to('home')->with('message', 'transaction succeded a receipt will be sent to you by email');

        }

        $this->processErrorPayment($userIdData,'activer', __('transaction.unknown'));
        return Redirect::to('activer')->with('error', __('transaction.unknown'));

    }

    /**
     * update the quantity of products availble after client transaction
    */
    public function updateProductQuantity($currentUserId,$result){

        $user = Auth::user();
        $cart = $user->cart;


        $transactionAmount = $result->getTransactions()[0]->getAmount()->getTotal();
        $log = new Log($currentUserId);

        \Session::put('success', 'Payment success');
        $log->status = $result->getId();
        $log->message = 'transaction suscceded';
        $log->paymentId = $result->getId();
        $log->token = Input::get('token');
        $log->total = $transactionAmount;
        $log->save();
        $products = [];
        $appTransaction = AppTransaction::where('token',Input::get('token'))->firstOrFail();

        foreach ($appTransaction->products as $productValue) {

            $product = Product::findOrFail($productValue['id']);
            array_push($products,$product);
            if((int)$product->quantity - (int)$productValue['count'] > 0){
              $product->removeQuantity($productValue['count']);
            }else{
                $appTransaction->status = __('transaction.quantity').__('transaction.quantity2');
                $appTransaction->save();
                return Redirect::to('/home')->with('error', __('transaction.quantity').$product->name.__('transaction.quantity2'));
            }
        }
        $appTransaction->status = 'success';
        $appTransaction->save();
        $cart->clear();

        /**
         * Send receipt to user
        */
        Mail::to($user)->send(new Receipt($user->firstName,$appTransaction->products,$appTransaction->total,$appTransaction->created_at));
    }
    /**
     * handle activation payement success
     */
    public function activateSubscription($currentUserId,$result){

        $user = Auth::user();
        $log = new Log($currentUserId);
        $subscriptionAmount = $result->getTransactions()[0]->getAmount()->getTotal();
        $log = new Log($currentUserId);

        \Session::put('success', 'Payment success');
        $log->status = $result->getId();
        $log->message = 'transaction suscceded';
        $log->paymentId = $result->getId();
        $log->token = Input::get('token');
        $log->total = $subscriptionAmount;
        $log->save();
   
        $appTransaction = AppTransaction::where('token',Input::get('token'))->firstOrFail();
        $appTransaction->status = 'success';
        $appTransaction->save();

        if(intval($subscriptionAmount)=== 20){
            $user->subscribeOneYear();
        }else if(intval($subscriptionAmount)=== 60){
            $user->subscribeFourYears();
        }

        /**
         * Send receipt to user
        */
        Mail::to($user)->send(new Receipt($user->firstName,$appTransaction->products,$appTransaction->total,$appTransaction->created_at));

    }


      /**
     * handle error in the payement execution
     */
    public function processErrorPayment($currentUserId,$message){
       
        $log = new Log($currentUserId);

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            \Session::put('error', $message);
            $log->status = 'failed';
            $log->message = 'transaction canceled';
            $log->paymentId = Input::get('PayerID');
            $log->token = Input::get('token');
            $log->save();
        }

    }

}