<?php namespace NM\Payme\Domain;

class Payment
{
    protected $id;
    protected $card_number;
    protected $expiration_date;
    protected $cvv;
    protected $card_l4;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Payment
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * @param mixed $card_number
     * @return Payment
     */
    public function setCardNumber($card_number)
    {
        $this->card_number = $card_number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     * @param mixed $expiration_date
     * @return Payment
     */
    public function setExpirationDate($expiration_date)
    {
        $this->expiration_date = $expiration_date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCvv()
    {
        return $this->cvv;
    }

    /**
     * @param mixed $cvv
     * @return Payment
     */
    public function setCvv($cvv)
    {
        $this->cvv = $cvv;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardL4()
    {
        return $this->card_l4;
    }

    /**
     * @param mixed $card_l4
     * @return Payment
     */
    public function setCardL4($card_l4)
    {
        $this->card_l4 = $card_l4;
        return $this;
    }



}