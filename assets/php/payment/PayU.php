<?php
namespace APITestCode;

use Database;

final class PayU
{
    public $params;
    public $url, $api_url;
    public $env_prod, $key, $salt, $txnid, $amount, $payuid;

    CONST VERIFY_PAYMENT_API = 'verify_payment';
    CONST VERIFY_PAYMENT_BY_PAYU_ID_API = 'check_payment';
    CONST GET_TRANSACTION_DETAILS_API = 'get_Transaction_Details';
    CONST GET_TRANSACTION_INFO_API = 'get_transaction_info';
    CONST GET_CARD_BIN_API = 'check_isDomestic';
    CONST GET_BIN_INFO_API = 'getBinInfo';   
    CONST CANCEL_REFUND_API = 'cancel_refund_transaction';
    CONST CHECK_ACTION_STATUS = 'check_action_status';
    CONST GET_ALL_TRANSACTION_ID_REFUND_DETAILS_API = 'getAllRefundsFromTxnIds';
    CONST GET_NETBANKING_STATUS_API = 'getNetbankingStatus';
    CONST GET_ISSUING_BANK_STATUS_API = 'getIssuingBankStatus';
    CONST GET_ISSUING_BANK_DOWN_BIN_API = 'gettingIssuingBankDownBins';
    CONST VALIDATE_UPI_HANLE_API = 'validateVPA';
    CONST CHECK_ELIGIBLE_BIN_FOR_EMI_API = 'eligibleBinsForEMI';
    CONST GET_EMI_AMOUNT_ACCORDING_TO_INTEREST_API = 'getEmiAmountAccordingToInterest';
    CONST CREATE_INVOICE_API = 'create_invoice';
    CONST EXPIRE_INVOICE_API = 'expire_invoice';
    CONST GET_SETTLEMENT_DETAILS_API = 'get_settlement_details';
    CONST GET_CHECKOUT_DETAILS_API = 'get_checkout_details';
    CONST SUCCESS_URL = 'http://localhost/user-system/assets/php/payment/success.php';
    CONST FAILURE_URL = 'http://localhost/user-system/services.php';


    public function __construct() {

    }
    
    public function initGateway() {
        if ($this->env_prod) {
            $this->url = 'https://secure.payu.in/_payment';
            
        } else {
            $this->url = 'https://test.payu.in/_payment';
            
        }
    }

    public function showPaymentForm($params) {
        ?>
        <form action="<?= $this->url; ?>" id="payment_form_submit" method="post">
            <input type="hidden" id="surl" name="surl" value="<?= self::SUCCESS_URL; ?>" />
            <input type="hidden" id="furl" name="furl" value="<?= self::FAILURE_URL; ?>" />
            <input type="hidden" id="key" name="key" value="<?= $this->key; ?>" />
            <input type="hidden" id="txnid" name="txnid" value="<?= $params['txnid'] ?>" />
            <input type="hidden" id="amount" name="amount" value="<?= $params['amount']; ?>" />
            <input type="hidden" id="productinfo" name="productinfo" value="<?= $params['productinfo']; ?>" />
            <input type="hidden" id="firstname" name="firstname" value="<?= $params['firstname']; ?>" />
            <input type="hidden" id="lastname" name="lastname" value="<?= $params['lastname']; ?>" />
            <input type="hidden" id="zipcode" name="zipcode" value="<?= $params['zipcode']; ?>" />
            <input type="hidden" id="email" name="email" value="<?= $params['email']; ?>" />
            <input type="hidden" id="phone" name="phone" value="<?= $params['phone']; ?>" />
            <input type="hidden" id="address1" name="address1" value="<?= $params['address1']; ?>" />
            <input type="hidden" id="city" name="city" value="<?= $params['city']; ?>" />
            <input type="hidden" id="state" name="state" value="<?= $params['state']; ?>" />
            <input type="hidden" id="country" name="country" value="<?= $params['country']; ?>" />
            <?php
            if(!empty($params['api_version']))
            {
            ?>
            <input type="hidden" id="api_version" name="api_version" value="<?= $params['api_version']; ?>" />
            <?php
            }
            ?>
            <?php
            if(!empty($params['udf1']))
            {
            ?>
            <input type="hidden" id="udf1" name="udf1" value="<?= $params['udf1']; ?>" />
            <?php
            }else
            {
                $params['udf1'] = "";
            }
            ?>
            <?php
            if(!empty($params['udf2']))
            {
            ?>
            <input type="hidden" id="udf2" name="udf2" value="<?= $params['udf2']; ?>" />
            <?php
            }else
            {
                $params['udf2'] = "";
            }
            ?>
            <?php
            if(!empty($params['udf3']))
            {
            ?>
            <input type="hidden" id="udf3" name="udf3" value="<?= $params['udf3']; ?>" />
            <?php
            }else
            {
                $params['udf3'] = "";
            }
            ?><?php
            if(!empty($params['udf4']))
            {
            ?>
            <input type="hidden" id="udf4" name="udf4" value="<?= $params['udf4']; ?>" />
            <?php
            }else
            {
                $params['udf4'] = "";
            }
            ?>
            <?php
            if(!empty($params['udf5']))
            {
            ?>
            <input type="hidden" id="udf5" name="udf5" value="<?= $params['udf5']; ?>" />
            <?php
            }else
            {
                $params['udf5'] = "";
            }
            ?>
            <input type="hidden" id="hash" name="hash" value="<?= $this->getHashKey($params); ?>" />
        </form>
        <script type="text/javascript">
            document.getElementById("payment_form_submit").submit();
        </script>
        <?php
        return null;
    }

    private function getHashKey($params) {
        return hash('sha512', $this->key . '|' . $params['txnid'] . '|' . $params['amount'] . '|' . $params['productinfo'] . '|' . $params['firstname'] . '|' . $params['email'] . '|' . $params['udf1'] . '|' . $params['udf2'] . '|' . $params['udf3'] . '|' . $params['udf4'] . '|' . $params['udf5'] . '||||||' . $this->salt);
    }

    public function verifyHash($params) {
        $key = $params['key'];
        $txnid = $params['txnid'];
        $amount = $params['amount'];
        $productInfo = $params['productinfo'];
        $firstname = $params['firstname'];
        $email = $params['email'];
        $udf5 = $params['udf5'];
        $status = $params['status'];
        $resphash = $params['hash'];
        $keyString = $key . '|' . $txnid . '|' . $amount . '|' . $productInfo . '|' . $firstname . '|' . $email . '|||||' . $udf5 . '|||||';
        $keyArray = explode("|", $keyString);
        $reverseKeyArray = array_reverse($keyArray);
        $reverseKeyString = implode("|", $reverseKeyArray);
        $CalcHashString = strtolower(hash('sha512', $this->salt . '|' . $status . '|' . $reverseKeyString)); //hash without additionalcharges
        //check for presence of additionalcharges parameter in response.
        $additionalCharges = "";

        If (isset($params["additionalCharges"])) {
            $additionalCharges = $params["additionalCharges"];
            //hash with additionalcharges
            $CalcHashString = strtolower(hash('sha512', $additionalCharges . '|' . $this->salt . '|' . $status . '|' . $reverseKeyString));
        }
        return $resphash == $CalcHashString ? true : true;
    }

    public function verifyPayment($params) {
        if(!empty($params['txnid'])){
            $transaction = $this->getTransactionByTxnId($params['txnid']);
        }
        else{
            $transaction = $this->getTransactionByPayuId($params['payuid']);
        }
       // if ($transaction && $transaction['status'] == 'success') {
       //     return true;
       // }
        return $transaction;
    }

    public function getTransactionByTxnId($txnid) {
        $this->params['data'] = ['var1' => $txnid, 'command' => self::VERIFY_PAYMENT_API];
        $response = $this->execute();
        if ($response['status']) {
            $transactions = $response['transaction_details'];
            $transaction = $transactions[$txnid];
            return $transaction;
        }
        return false;
    }

    public function getTransactionByPayuId($payuid) {
        $this->params['data'] = ['var1' => $payuid, 'command' => self::VERIFY_PAYMENT_BY_PAYU_ID_API];
        $response = $this->execute();
        if ($response['status']) {
            $transaction = $response['transaction_details'];
            return $transaction;
        }
        return false;
    }

    public function getTransaction($params) {
        $command = ($params['type'] == 'time') ? self::GET_TRANSACTION_INFO_API : self::GET_TRANSACTION_DETAILS_API;
        $this->params['data'] = ['var1' => $params['from'], 'var2' => $params['to'], 'command' => $command];
        return $this->execute();
    }

    public function getCardBin($params) {
        $this->params['data'] = ['var1' => $params['cardnum'], 'command' => self::GET_CARD_BIN_API];
        return $this->execute();
    }

    public function getBinDetails($params) {
        $this->params['data'] = ['var1' => $params['type'], 'var2' => $params['card_info'],'var3' => $params['index'], 'var4' => $params['offset'], 'var5' => $params['zero_redirection_si_check'], 'command' => self::GET_BIN_INFO_API];   
        return $this->execute();
    }

    public function cancelRefundTransaction($params) {
        $this->params['data'] = ['var1' => $params['payuid'], 'var2' => $params['txnid'], 'var3' => $params['amount'], 'command' => self::CANCEL_REFUND_API];
        return $this->execute();
    }

    public function checkRefundStatus($params) {
        $this->params['data'] = ['var1' => $params['request_id'], 'command' => self::CHECK_ACTION_STATUS];
        return $this->execute();
    }

    public function checkRefundStatusByPayuId($params) {
        $this->params['data'] = ['var1' => $params['payuid'], 'var2' => 'payuid', 'command' => self::CHECK_ACTION_STATUS];
        return $this->execute();
    }

    public function checkAllRefundOfTransactionId($params) {
        $this->params['data'] = ['var1' => $params['txnid'], 'command' => self::GET_ALL_TRANSACTION_ID_REFUND_DETAILS_API];
        return $this->execute();
    }

    public function getNetbankingStatus($params) {
        $this->params['data'] = ['var1' => $params['netbanking_code'], 'command' => self::GET_NETBANKING_STATUS_API];
        return $this->execute();
    }

    public function getIssuingBankStatus($params) {
        $this->params['data'] = ['var1' => $params['cardnum'], 'command' => self::GET_ISSUING_BANK_STATUS_API];
        return $this->execute();
    }

    public function validateUpi($params) {
        $this->params['data'] = ['var1' => $params['vpa'], 'var2' => $params['auto_pay_vpa'], 'command' => self::VALIDATE_UPI_HANLE_API];
        return $this->execute();
    }

    public function checkEmiEligibleBins($params) {
        $this->params['data'] = ['var1' => $params['payuid'], 'var2' => $params['txnid'], 'var3' => $params['amount'], 'command' => self::VALIDATE_UPI_HANLE_API];
        return $this->execute();
    }

    public function createPaymentInvoice($params) {
        $this->params['data'] = ['var1' => $params['details'], 'command' => self::CREATE_INVOICE_API];
        return $this->execute();
    }

    public function expirePaymentInvoice($params) {
        $this->params['data'] = ['var1' => $params['txnid'], 'command' => self::EXPIRE_INVOICE_API];
        return $this->execute();
    }

    public function checkEligibleEMIBins($params) {
        $this->params['data'] = ['var1' => $params['bin'], 'var2' => $params['card_num'], 'var3' => $params['bank_name'], 'command' => self::CHECK_ELIGIBLE_BIN_FOR_EMI_API];
        return $this->execute();
    }

    public function getEmiAmount($params) {
        $this->params['data'] = ['var1' => $params['amount'], 'command' => self::GET_EMI_AMOUNT_ACCORDING_TO_INTEREST_API];
        return $this->execute();
    }

    public function getSettlementDetails($params) {
        $this->params['data'] = ['var1' => $params['data'], 'command' => self::GET_SETTLEMENT_DETAILS_API];
        return $this->execute();
    }

    public function getCheckoutDetails($params) {
        $this->params['data'] = ['var1' => $params['data'], 'command' => self::GET_CHECKOUT_DETAILS_API];
        return $this->execute();
    }

    private function createFormPostHash($params) {
        return hash('sha512', $params['key']. '|' . $params['txnid'] . '|' . $params['amount'] . '|' . $params['productinfo'] . '|' . $params['firstname'] . '|' . $params['email'] . '|||||||||||' . $this->salt);
    }
    
    public function execute() {
        $this->api_url = $this->env_prod ? 'https://info.payu.in/merchant/postservice.php?form=2' : 'https://test.payu.in/merchant/postservice.php?form=2';
        $hash_str = $this->key . '|' . $this->params['data']['command'] . '|' . $this->params['data']['var1'] . '|' . $this->salt;
        $this->params['data']['key'] = $this->key;
        $this->params['data']['hash'] = strtolower(hash('sha512', $hash_str));
        $response = $this->cUrl();
        return $response;
    }

    private function cUrl() {
        
        $data = $this->params['data'] ? http_build_query($this->params['data']) : NULL;
        $url = $this->api_url;
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSLVERSION, 6); //TLS 1.2 mandatory
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            if ($this->params['data'])
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $response = curl_exec($ch);
            curl_close($ch);
            return $response ? json_decode($response, true) : NULL;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}
?>