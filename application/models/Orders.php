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
                $burgerOptions = array();
                $burgerOptions['toppings'] = array();
                $burgerOptions['sauces'] = array();
                $burgerOptions['patty'] = $burger->patty['type'];

                if ( empty( $burger->cheeses['top'] ) ) {
                    $burgerOptions['topCheese'] = "none";
                } else {
                    $burgerOptions['topCheese'] = $burger->cheeses['top'];

                }

                if ( empty( $burger->cheeses['bottom'] ) ) {
                    $burgerOptions['bottomCheese'] = "none";
                } else {
                    $burgerOptions['bottomCheese'] = $burger->cheeses['bottom'];

                }

                foreach ( $burger->topping as $topping ) {
                    array_push( $burgerOptions['toppings'], $topping['type'] );
                }

                foreach ( $burger->sauce as $sauce ) {
                    array_push( $burgerOptions['sauces'], $sauce['type'] );
                }

                array_push( $this->burgers, $burgerOptions );
            }

            echo "<pre>";
            echo print_r( $this->burgers );
            echo "</pre>";
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

    function getBurgers()
    {
        return $this->burgers;
    }

}