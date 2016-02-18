<?php
/**
 * File Paypal.php.
 *
 * @author Andrey Klimenko <andrey.iemail@gmail.com>
 * @see https://github.com/paypal/rest-api-sdk-php/blob/master/sample/
 * @see https://developer.paypal.com/webapps/developer/applications/accounts
 */

namespace ak;

use modules\tasks\models\TaskUserLog;
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use yii\helpers\VarDumper;
use PayPal\Api\PaymentExecution;
use modules\tasks\models\PaypalPayments;
use modules\tasks\models\DelegateTask;


use yii\base\Component;
use PayPal\Auth\OAuthTokenCredential;

function D($object, $exit = false)
{
    VarDumper::dump($object, 20, 1);
    echo '<br />';

    if ($exit) {
        exit();
    }

    return null;
}

/**
 * Class Paypal.
 *
 * @package ak
 * @author Andrey Klimenko <andrey.iemail@gmail.com>
 */
class Paypal extends Component
{
    //region API settings
    public $clientId;
    public $clientSecret;
    public $isProduction = false;
    public $currency = 'USD';

    private $version = '3.0';
    //endregion

    private $_token = null;
    /** @var ApiContext */
    private $_apiContext = null;

    protected $errors = [];

    public function init()
    {
        $this->clientId     = 'AeAQSEzvflz8ymiU9QC1awrfpQXszDXwrVIgRPk7E7-RDaL-O0dLhSrAnwLJ5XmnF6bJRNs2I034XcHF';
        $this->clientSecret = 'EPgWBd3sfwZCgxgeCKWInrXn_09uomJdjCvkclD-TTnTl-HzqxB4u1hhkQbEI9luAFEBcRJgnbhirn4c';
    }

    public function authorize()
    {
        $credentials = new OAuthTokenCredential($this->clientId, $this->clientSecret);
        if (is_null($this->_token)) {
            $credentials->getAccessToken(['mode' => 'sandbox']);
        }
        $this->_apiContext = new ApiContext($credentials);
    }

    public function payDemo()
    {
        $this->authorize();

        $card = new CreditCard();
        $card->setType("visa");
        $card->setNumber("4446283280247004");
        $card->setExpireMonth("11");
        $card->setExpireYear("2018");
        $card->setFirstName("Joe");
        $card->setLastName("Shopper");


        $fundingInstrument = new FundingInstrument();
        $fundingInstrument->setCreditCard($card);

        $payer = new Payer();
        $payer->setPaymentMethod("PAYPAL");
        //$payer->setFundingInstruments(array($fundingInstrument));

        $amount = new Amount();
        $amount->setCurrency("USD");
        $amount->setTotal("12");

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription("creating a direct payment with credit card");

        $payment = new Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));

        $payment->create($this->_apiContext);
    }

    public function createPay($post){

        $this->authorize();
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $amount = new Amount();
        $amount->setCurrency('USD');
        $amount->setTotal($post['sum']);
       /* $item1 = new Item();
        $item1->setName('Продажа товара/услуги')->setCurrency('RUB')->setQuantity(1)->setPrice('10');
// Ид товара/услуги на вашей стороне
        $item1->setSku('1000');
        $itemList = new ItemList();
        $itemList->setItems(array($item1));*/
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Payment for '.$post['name']);
        //$transaction->setItemList($itemList);
        $payment = new Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));
        $payment->setRedirectUrls(array(
            "return_url" => 'http://'.$_SERVER['SERVER_NAME'].'/tasks/paypal/approvepay',
            "cancel_url" => 'http://'.$_SERVER['SERVER_NAME'].'/tasks/paypal/index'
        ));
        $payment->create($this->_apiContext);
        $payment->getId();
        $links = $payment->getLinks();

        $dbpayment = new PaypalPayments();
        $dbpayment->delegate_task_id = $post['id'];
        $dbpayment->payment_id = $payment->getId();
        $dbpayment->save();

        foreach ($links as $link) {
            if ($link->getMethod() == 'REDIRECT') {
                header('location:'.$link->getHref());
                return;
            }
        }
    }

    public function approvePay($get){
       $apiContext = new ApiContext(new OAuthTokenCredential(
            $this->clientId, $this->clientSecret));
        $apiContext->setConfig([ 'mode' => 'sandbox']);
        $payment = Payment::get($get['paymentId'], $apiContext);
        $paymentExecution= new PaymentExecution();
        $paymentExecution->setPayerId($get['PayerID']);
        $check = $payment->execute($paymentExecution, $apiContext);
        if($check->state == 'approved'){
            $paym = PaypalPayments::find()->where(['payment_id' => $check->id])->one();
            $task = DelegateTask::find()->where(['id' => $paym->delegate_task_id])->one();
            $task->status = DelegateTask::$status_payment;
            if($task->save()){
                TaskUserLog::sendLog($task->task_user_id, TaskUserLog::$log_payment);
                header('Location: /tasks/paypal/paypalok');
            }
        }
        die();
    }

    public function createPayout($post){

        $this->authorize();

        $payouts = new \PayPal\Api\Payout();

        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");

        $senderItem = new \PayPal\Api\PayoutItem();
        $senderItem->setRecipientType('Email')
            ->setNote('Thanks for your patronage!')
            //->setReceiver($post['login'])
            ->setReceiver($post['login'])
            ->setSenderItemId("2014031400023")
            ->setAmount(new \PayPal\Api\Currency('{
                        "value":"'.$post["sum"].'",
                        "currency":"USD"
                    }'));
        $payouts->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem);

        try {
            $output = $payouts->createSynchronous($this->_apiContext);
        } catch (Exception $ex) {
            var_dump($ex);
            exit(1);
        }
       //var_dump($output);
        return $output;
    }
} 