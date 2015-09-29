<?php namespace NM\Payme; 

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use NM\Payme\Collection\Iterator;
use NM\Payme\Domain\Customer;
use NM\Payme\Domain\Item;
use NM\Payme\Domain\Payment;
use NM\Payme\Collection\LineItems;

/**
 * Class Payme
 * @package NM\Payme
 *
 * Payme aims to make using Argus'/Mobius API clean and simple. Easily accept payments and send to Mobius for
 * processing. All that's required is your merchant username, password, id, and siteId.
 *
 * TODO: Validate in package?
 * TODO: Switch responses to objects?
 * TODO: Add any extra methods supported by argus
 *
 */

class Payme {

    protected $uri = 'https://svc.arguspayments.com/';
    protected $endpoint;
    protected $user = 'USERNAME@EMAIL';
    protected $password = 'PASSWORD';
    protected $siteId = 111111;
    protected $merchantId = 111111;
    protected $currency = 'USD';

    protected $paymentDescriptor = 'Online Purchase';
    protected $externalPaymentId;
    protected $externalOrderId;

    protected $existingCustomer;
    protected $existingPayment;

    protected $action;
    protected $version = '3.2';
    protected $format = 'JSON';
    private $_customer;
    private $_payment;
    private $_client;
    private $_items;
    private $_response;
    private $_params;
    private $_errors = [];

    public function __construct(
        $merchant_id = null,
        $username = null,
        $password = null,
        $site_id = null
    )
    {
        $this->_client = new Client([
          'base_uri' => $this->uri
        ]);

        $this->merchantId = $merchant_id ? $merchant_id : $this->merchantId;
        $this->user = $username ? $username : $this->user;
        $this->password = $password ? $password : $this->password;
        $this->siteId = $site_id ? $site_id : $this->siteId;
        $this->_params = [
            'req_username'              => $this->user,
            'req_password'              => $this->password,
            'request_action'            => $this->action,
            'request_api_version'       => $this->version,
            'request_response_format'   => $this->format,
            'site_id'                   => $this->siteId,
            'merch_acct_id'             => $this->merchantId
        ];

        $this->_items = new LineItems;
    }

    /**
     * Authenticate with Mobius/Argus
     * @return object|string
     */
    public function authenticate()
    {
          $this->setAction('TESTAUTH');
          $this->endpoint = 'payment/pmt_service.cfm';
          return $this->request('POST', $this->endpoint, [
              'form_params' => [
                  'req_username' => $this->user,
                  'req_password' => $this->password,
                  'site_id' => $this->siteId,
                  'request_action' => $this->action,
                  'request_response_format' => $this->format,
                  'request_api_version' => $this->version,
              ]
          ]);
    }

    // set customer
    // set payment details
    // set line items

    /**
     * Create a new customer object for instance
     * @param null $first_name
     * @param null $last_name
     * @param null $email
     * @param null $username
     * @param null $password
     * @param null $ip
     * @param null $billing_address
     * @param null $billing_city
     * @param null $billing_state
     * @param null $billing_country
     * @param null $billing_zip
     * @param null $telephone
     * @param null $dob
     * @param null $drivers_license_number
     * @param null $dln_state
     * @param null $ssn_l4
     * @param null $shipping_address
     * @param null $shipping_city
     * @param null $shipping_state
     * @param null $shipping_country
     * @param null $shipping_zip
     * @return $this
     */
    public function setCustomer(
        $first_name = null,
        $last_name = null,
        $email = null,
        $username = null,
        $password = null,
        $ip = null,

        $billing_address = null,
        $billing_city = null,
        $billing_state = null,
        $billing_country = null,
        $billing_zip = null,
        $telephone = null,
        $dob = null,
        $drivers_license_number = null,
        $dln_state = null,
        $ssn_l4 = null,

        $shipping_address = null,
        $shipping_city = null,
        $shipping_state = null,
        $shipping_country = null,
        $shipping_zip = null
    )
    {
        $this->_customer = new Customer;
        $this->_customer->setFirstName($first_name);
        $this->_customer->setLastName($last_name);
        $this->_customer->setEmail($email);
        $this->_customer->setUsername($username);
        $this->_customer->setPassword($password);
        $this->_customer->setIp($ip);
        $this->_customer->setBillingAddress($billing_address);
        $this->_customer->setBillingCity($billing_city);
        $this->_customer->setBillingState($billing_state);
        $this->_customer->setBillingCountry($billing_country);
        $this->_customer->setBillingZip($billing_zip);
        $this->_customer->setTelephone($telephone);
        $this->_customer->setDob($dob);
        $this->_customer->setDriversLicenseNumber($drivers_license_number);
        $this->_customer->setDlnState($dln_state);
        $this->_customer->setSsnL4($ssn_l4);
        $this->_customer->setShippingAddress($shipping_address);
        $this->_customer->setShippingCity($shipping_city);
        $this->_customer->setShippingState($shipping_state);
        $this->_customer->setShippingCountry($shipping_country);
        $this->_customer->setShippingZip($shipping_zip);

        return $this;
    }

    /**
     * Return current customer
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->_customer;
    }

    /**
     * Set payment for current transaction
     * @param null $card_number
     * @param null $expiration_date
     * @param null $cvv
     * @param null $last4
     * @return $this
     */
    public function setPayment(
        $card_number = null,
        $cvv = null,
        $expiration_date = null,
        $last4 = null
    )
    {
        $this->_payment = new Payment;
        $this->_payment->setCardNumber($card_number);
        $this->_payment->setCvv($cvv);
        $this->_payment->setExpirationDate($expiration_date);
        $this->_payment->setCardL4($last4 ? $last4 : substr($this->_payment->getCardNumber(), -4));
        return $this;
    }

    /**
     * Get payment info for current transaction
     * @return mixed
     */
    public function getPayment()
    {
        return $this->_payment;
    }

    /**
     * Set an existing customer id for the transaction
     * @param $customer_id
     * @return $this
     */
    public function setExistingCustomer($customer_id)
    {
        $this->existingCustomer = $customer_id;
        return $this;
    }

    /**
     * Get an existing customer id.
     * @return mixed
     */
    public function getExistingCustomer()
    {
        return $this->existingCustomer;
    }

    /**
     * Set an existing payment id
     * @param $id
     * @return $this
     */
    public function setExistingPayment($id)
    {
        $this->setExistingPayment($id);
        return $this;
    }

    /**
     * Get an existing payment id
     * @return mixed
     */
    public function getExistingPayment()
    {
        return $this->existingPayment;
    }

    /**
     * Add item to current transaction
     * @param null $id
     * @param null $quantity
     * @param null $value
     * @return $this
     */
    public function addItem($id = null, $quantity = null, $value = null)
    {
        $item = new Item;
        $item->setId($id);
        $item->setQuantity($quantity);
        $item->setValue($value);
        $this->_items->addItem($item);
        return $this;
    }

    /**
     * Set payment descriptor to appear on billing statement
     * @param $desc
     * @return $this
     */
    public function setDescriptor($desc)
    {
        $this->paymentDescriptor = $desc;
        return $this;
    }

    /**
     * Get current payment descriptor
     * @return mixed
     */
    public function getDescriptor()
    {
        return $this->paymentDescriptor;
    }

    /**
     * Set External Order ID
     * @param $id
     * @return $this
     */
    public function setExternalOrderId($id)
    {
        $this->externalOrderId = $id;
        return $this;
    }

    /**
     * Get external order id
     * @return mixed
     */
    public function getExternalOrderId()
    {
        return $this->externalOrderId;
    }

    /**
     * Set External Payment ID
     * @param $id
     * @return $this
     */
    public function setExternalPaymentId($id)
    {
        $this->externalPaymentId = $id;
        return $this;
    }

    /**
     * Get External Payment ID
     * @return mixed
     */
    public function getExternalPaymentId()
    {
        return $this->externalPaymentId;
    }

    /**
     * Sends a new charge to Mobius API.
     * Requires user to have set a customer, payment, and line item(s)
     * to successfully go through
     *
     * @return object|string
     */
    final public function charge()
    {

        $this->setAction('CCAUTHCAP');
        $this->endpoint = 'payment/pmt_service.cfm';
        //$this->endpoint = 'http://requestb.in/zvcn4wzv'; // to debug

        $errors = [];
        if (!$this->_customer)
        {
            $errors[] = 'Please set a customer before attempting a new charge.';
        }
        if (!$this->_payment)
        {
            $errors[] = 'Please supply payment information before attempting a new charge.';
        }

        if ($this->_items->count() < 1)
        {
            $errors[] = 'Please add at least one item before attempting a new charge.';
        }

        if (!empty($errors))
        {
            return $this->createMessage(500, 'Please correct the following errors', ['errors' => $errors]);
        }

        $params = [
            'xtl_ip'                    => $this->_customer->getIp(),
            'request_currency'          => $this->currency
        ];

        $usr_params = [];
        if(!$this->existingCustomer)
        {
            $usr_params = [
                'cust_fname'                => $this->_customer->getFirstName(),
                'cust_lname'                => $this->_customer->getLastName(),
                'cust_email'                => $this->_customer->getEmail(),
                'bill_addr'                 => $this->_customer->getBillingAddress(),
                'bill_addr_city'            => $this->_customer->getBillingCity(),
                // 2 letter state code
                'bill_addr_state'           => $this->_customer->getBillingState(),
                'bill_addr_zip'             => $this->_customer->getBillingZip(),
                // 2 letter country code
                'bill_addr_country'         => $this->_customer->getBillingCountry(),
            ];
        }

        // if existing customer set, use their info for payment
        if($this->existingCustomer)
        {
            $usr_params = [
                'cust_id'   => $this->existingCustomer
            ];
        }

        $pmt_params = [];
        if (!$this->existingPayment)
        {
            $pmt_params = [
                // payment info
                'pmt_numb'                  => $this->_payment->getCardNumber(),
                'pmt_key'                   => $this->_payment->getCvv(),
                'pmt_expiry'                => $this->_payment->getExpirationDate(),
                'pmt_last4'                 => $this->_payment->getCardL4(),
                'pmt_descriptor'            => $this->paymentDescriptor,
            ];
        }

        // if existing payment set, use that instead of new info
        if ($this->existingPayment)
        {
            $pmt_params = [
                'pmt_id' => $this->existingPayment
            ];
        }

        if($this->externalOrderId)
        {
            $params['xtl_order_id'] = $this->getExternalOrderId();
        }
        if($this->externalPaymentId)
        {
            $params['pmt_id_xtl'] = $this->getExternalPaymentId();
        }

        // add line items
        $i = 1;
        $it = new Iterator($this->_items);
        foreach ($it as $item)
        {
            $params['li_value_' . $i] = $item->getValue();
            $params['li_count_' . $i] = $item->getQuantity();
            $params['li_prod_id_' . $i] = $item->getId();
            $i++;
        }

        $params = ['form_params' => array_merge($this->_params, $pmt_params, $usr_params, $params)];
        return $this->request('POST', $this->endpoint, $params);
    }

    /**
     * Reverse a CCAUTHCAP transaction by Order ID.
     * @param $order_id
     * @return object|string
     */
    public function reverse($order_id)
    {
        $this->setAction('CCREVERSECAP');
        $this->endpoint = 'payment/pmt_service.cfm';

        $params = [
            'request_ref_po_id' => $order_id,
        ];

        $this->_params = ['form_params' => array_merge($this->_params, $params)];
        return $this->request('POST', $this->endpoint, $this->_params);
    }

    public function reverseLineItem($item_id, $order_id)
    {
        $this->setAction('CCREVERSE');
        $this->endpoint = 'payment/pmt_service.cfm';

        $params = [
            'request_ref_po_li_id' => $item_id,
            'request_ref_po_id'    => $order_id
        ];

        $this->_params = ['form_params' => array_merge($this->_params, $params)];
        return $this->request('POST', $this->endpoint, $this->_params);
    }



    /**
     * Credit a transaction back to user's card by Order_ID
     * @param $order_id
     * @param null $amount
     * @return object|string
     */
    public function credit($order_id, $amount)
    {
        $this->setAction('CCCREDIT');
        $this->endpoint = 'payment/pmt_service.cfm';

        $params = [
            'request_ref_po_id' => $order_id,
            'LI_VALUE_1' => $amount
        ];

        $this->_params = ['form_params' => array_merge($this->_params, $params)];
        return $this->request('POST', $this->endpoint, $this->_params);
    }

    /**
     * Cancel a subscription by Membership ID
     * If $cancel_now set to TRUE, cancels immediately
     * If $cancel_now set to NULL, subscription will cancel at end of month
     * @param $membership_id
     * @param null $cancel_now
     * @return object|string
     */
    public function cancelSubscription($membership_id, $cancel_now = null)
    {
        $this->setAction('SUB_CANCEL');
        $this->endpoint = 'payment/pmt_service.cfm';

        $params = [
            'request_ref_mbshp_id' => $membership_id,
            'SUB_CANCEL_TYPE' => $cancel_now ? 1 : 2
        ];

        $this->_params = ['form_params' => array_merge($this->_params, $params)];
        return $this->request('POST', $this->endpoint, $this->_params);
    }

    /**
     * Edit an existing subscription by membership_id
     * Supply new product_id to either upgrade/downgrade subscription.
     * New subscription price doesn't take effect until end of billing cycle
     *
     * @param $membership_id
     * @param $new_prod_id
     * @return object|string
     */
    public function editSubscription($membership_id, $new_prod_id)
    {
        $this->setAction('SUB_UPDATE');
        $this->endpoint = 'payment/pmt_service.cfm';

        $params = [
            'request_ref_mbshp_id' => $membership_id,
            'SUB_UPDATE_PROD_ID' => $new_prod_id
        ];

        $this->_params = ['form_params' => array_merge($this->_params, $params)];
        return $this->request('POST', $this->endpoint, $this->_params);
    }

    /**
     * Return transactions from a specific Order ID
     * @param $order_id
     * @return object|string
     */
    public function status($order_id)
    {
        $this->setAction('CCSTATUS');
        $this->endpoint = 'payment/pmt_service.cfm';

        $params = [
            'request_ref_po_id' => $order_id,
        ];

        $this->_params = ['form_params' => array_merge($this->_params, $params)];
        $response = $this->request('POST', $this->endpoint, $this->_params);
        if (isset($response->body->COLUMNS) && isset($response->body->DATA) && !empty($response->body->DATA))
        {
            $c = count($response->body->DATA);
            if ($c > 1)
            {
                $body = [];
                $data = $response->body->DATA;
                foreach ($data as $d)
                {
                    $body[] = array_combine($response->body->COLUMNS, $d);
                }
            }
            else {
                $body = (object) array_combine($response->body->COLUMNS, $response->body->DATA[0]);
            }

            $response->message = 'SUCCESS';
            $response->body = $body;
        }

        return $response;
    }

    /**
     * Set action for current request
     * @param $action
     */
    public function setAction($action)
    {
        $this->action = $action;
        $this->_params['request_action'] = $action;
    }

    /**
     * Get action for current request
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    protected function errors()
    {
      return json_encode($this->_errors);
    }

    protected function setError($exception)
    {
        $this->_errors[] = $this->createMessage(
                $exception->getCode(),
                $exception->getResponse()->getReasonPhrase()
        );
    }

    private function request($type, $uri, $params)
    {
        try {
            $this->_response = $this->_client->request($type, $uri, $params);

            // if problem w/ http request, return error message
            if ($this->_response->getStatusCode() != 200)
            {
                return $this->createMessage(
                    $this->_response->getStatusCode(),
                    $this->_response->getReasonPhrase(),
                    $this->_response->getBody()->getContents()
                );
            }

            $content = json_decode($this->_response->getBody()->getContents());

            // if api returns error code, return error message
            if(isset($content->API_RESPONSE) && isset($content->API_ADVICE) && $content->API_RESPONSE == 101 && strpos($content->API_ADVICE, 'Invalid login information') !== FALSE)
            {
                return $this->createMessage(
                    403,
                    $content->API_ADVICE,
                    $content
                );
            }

            // if api req is cancelling subscription, return appropriate response
            if(isset($content->REQUEST_ACTION) && $content->REQUEST_ACTION == 'SUB_CANCEL')
            {
                return $this->createMessage(
                    isset($content->MBSHP_CANCEL_TS_UTC) && !empty($content->MBSHP_CANCEL_TS_UTC) ? 200 : $content->API_RESPONSE,
                    isset($content->MBSHP_CANCEL_TS_UTC) && !empty($content->MBSHP_CANCEL_TS_UTC) ? 'Success' : $content->API_ADVICE . ' - dverror: ' . $content->REF_FIELD,
                    $content
                );
            }

            return $this->createMessage(
                isset($content->API_RESPONSE) ? $content->API_RESPONSE : 200,
                isset($content->API_ADVICE) ? $content->API_ADVICE : isset($content->TRANS_STATUS_NAME) ? $content->TRANS_STATUS_NAME : $content->DATA[0][1],
                $content
            );
        }
        catch (RequestException $e)
        {
            $this->setError($e);
        }
        catch (ClientException $e)
        {
            $this->setError($e);
        }
        catch (ConnectException $e)
        {
            $this->setError($e);
        }

        if(!empty($this->errors()))
        {
            return $this->errors();
        }
    }

    private function createMessage($code, $message, $body = null)
    {
        $message = [
          'code' => $code,
          'message' => $message
        ];

        if ($body)
        {
          $message['body'] = $body;
        }
        return (object) $message;
    }
 
}
