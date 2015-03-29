<?php
/**
 * Created by PhpStorm.
 * User: Edwin
 * Date: 15-03-28
 * Time: 3:38 PM
 */
class Orders extends CI_Model {

    protected $xml         = null;
    protected $patties     = array();
    protected $customerName;
    protected $orderType;
    protected $burgers = array();

    public function __construct( $filename = null )
    {
        parent::__construct();
        if( is_null($filename) )
        {
            return;
        }
        else
        {
            $this->xml = simplexml_load_file( DATAPATH . $filename );

            $this->customerName = $this->xml->customer;
            $this->orderType = (string) $this->xml['type'];
            foreach ( $this->xml->burger as $burger ) {
                array_push($this->burgers, $burger);
            }
        }
    }

    function getCustomerName()
    {
        return $this->customerName;
    }

    function getOrderType()
    {
        return $this->orderType;
    }
}