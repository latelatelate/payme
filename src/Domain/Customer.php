<?php namespace NM\Payme\Domain;

class Customer
{
    protected $id;

    protected $first_name;
    protected $last_name;
    protected $email;
    protected $username;
    protected $password;
    protected $ip;

    protected $billing_address;
    protected $billing_city;
    protected $billing_state;
    protected $billing_country;
    protected $billing_zip;
    protected $telephone;
    protected $dob;
    protected $drivers_license_number;
    protected $dln_state;
    protected $ssn_l4;

    protected $shipping_address;
    protected $shipping_city;
    protected $shipping_state;
    protected $shipping_country;
    protected $shipping_zip;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Customer
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return Customer
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return Customer
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return Customer
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Customer
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     * @return Customer
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillingAddress()
    {
        return $this->billing_address;
    }

    /**
     * @param mixed $billing_address
     * @return Customer
     */
    public function setBillingAddress($billing_address)
    {
        $this->billing_address = $billing_address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillingCity()
    {
        return $this->billing_city;
    }

    /**
     * @param mixed $billing_city
     * @return Customer
     */
    public function setBillingCity($billing_city)
    {
        $this->billing_city = $billing_city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillingState()
    {
        return $this->billing_state;
    }

    /**
     * @param mixed $billing_state
     * @return Customer
     */
    public function setBillingState($billing_state)
    {
        $this->billing_state = $billing_state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillingCountry()
    {
        return $this->billing_country;
    }

    /**
     * @param mixed $billing_country
     * @return Customer
     */
    public function setBillingCountry($billing_country)
    {
        $this->billing_country = $billing_country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBillingZip()
    {
        return $this->billing_zip;
    }

    /**
     * @param mixed $billing_zip
     * @return Customer
     */
    public function setBillingZip($billing_zip)
    {
        $this->billing_zip = $billing_zip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     * @return Customer
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param mixed $dob
     * @return Customer
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDriversLicenseNumber()
    {
        return $this->drivers_license_number;
    }

    /**
     * @param mixed $drivers_license_number
     * @return Customer
     */
    public function setDriversLicenseNumber($drivers_license_number)
    {
        $this->drivers_license_number = $drivers_license_number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDlnState()
    {
        return $this->dln_state;
    }

    /**
     * @param mixed $dln_state
     * @return Customer
     */
    public function setDlnState($dln_state)
    {
        $this->dln_state = $dln_state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSsnL4()
    {
        return $this->ssn_l4;
    }

    /**
     * @param mixed $ssn_l4
     * @return Customer
     */
    public function setSsnL4($ssn_l4)
    {
        $this->ssn_l4 = $ssn_l4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }

    /**
     * @param mixed $shipping_address
     * @return Customer
     */
    public function setShippingAddress($shipping_address)
    {
        $this->shipping_address = $shipping_address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingCity()
    {
        return $this->shipping_city;
    }

    /**
     * @param mixed $shipping_city
     * @return Customer
     */
    public function setShippingCity($shipping_city)
    {
        $this->shipping_city = $shipping_city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingState()
    {
        return $this->shipping_state;
    }

    /**
     * @param mixed $shipping_state
     * @return Customer
     */
    public function setShippingState($shipping_state)
    {
        $this->shipping_state = $shipping_state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingCountry()
    {
        return $this->shipping_country;
    }

    /**
     * @param mixed $shipping_country
     * @return Customer
     */
    public function setShippingCountry($shipping_country)
    {
        $this->shipping_country = $shipping_country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingZip()
    {
        return $this->shipping_zip;
    }

    /**
     * @param mixed $shipping_zip
     * @return Customer
     */
    public function setShippingZip($shipping_zip)
    {
        $this->shipping_zip = $shipping_zip;
        return $this;
    }
}