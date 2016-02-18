<?php
namespace modules\tasks\site\stripe;

use yii\base\Component;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\Charge;
use Stripe\Transfer;
use Stripe\Recipient;

class Payment extends Component{

    public $api_key = "sk_test_HKDA0i9zQI22bAVhVEDH2suo";

    public function __construct(array $config)
    {
        parent::__construct($config);
        require_once("/stripe/init.php");
        Stripe::setApiKey($this->api_key);

    }

    public function createCharge(){

        $token = Token::create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 1,
                "exp_year" => 2017,
                "cvc" => "314"
            )
        ));

        $charge = Charge::create(array(
                "amount" => 1000, // amount in cents, again
                "currency" => "usd",
                "card" => $token,
                "description" => "melnikovdv@gmail.com")
        );

        var_dump($charge);

    }

    public function createTransfer(){

        $token = Token::create(array(
            "card" => array(
                "number" => "5200828282828210",
                "exp_month" => 1,
                "exp_year" => 2017,
                "cvc" => "314"
            )
        ));


        $recipient = Recipient::create(array(
                "name" => "John Doe",
                "type" => "individual",
                "card" => $token,
                "email" => "payee@example.com")
        );


        $tr = Transfer::create(array(
            "amount" => 300,
            "currency" => "usd",
            "recipient" => $recipient->id,
            "description" => "Transfer for test@example.com"
        ));

        var_dump($tr); die();
    }


    public function randomstring()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 20; $i++) {
            $randstring .= $characters[rand(0, strlen($characters)-1)];
        }
        return $randstring;
    }

    public static function getError($error){

        $error_msg = json_decode($error);
        var_dump($error_msg->error->message);
        die();
    }

}