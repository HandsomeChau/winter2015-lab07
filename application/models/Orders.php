<?php

/**
 * Created by PhpStorm.
 * User: Edwin
 * Date: 15-03-28
 * Time: 3:38 PM
 */
class Orders extends CI_Model
{

    protected $xml        = NULL;
    protected $patties    = array();
    protected $customerName;
    protected $orderType;
    protected $burgers = array();
    protected $totalPrice = 0;

    public function __construct( $filename = NULL )
    {
        parent::__construct();
        if ( is_null( $filename ) ) {
            return;
        } else {
            $this->xml = simplexml_load_file( DATAPATH . $filename . ".xml" );

            $this->customerName = $this->xml->customer;
            $this->orderType = (string)$this->xml['type'];

            foreach ( $this->xml->burger as $burger ) {
                $burgerOptions = array();
                $burgerOptions['toppings'] = array();
                $burgerOptions['sauces'] = array();
                $burgerOptions['price'] = 0;
                $burgerOptions['patty'] = $burger->patty['type'];

                $burgerOptions['price'] += $this->menu->getPatty( (string)$burgerOptions['patty'] )->price;

                if ( empty( $burger->cheeses['top'] ) ) {
                    $burgerOptions['topCheese'] = "none";
                } else {
                    $burgerOptions['topCheese'] = $burger->cheeses['top'];
                    $burgerOptions['price'] += $this->menu->getCheese( (string)$burgerOptions['topCheese'] )->price;
                }

                if ( empty( $burger->cheeses['bottom'] ) ) {
                    $burgerOptions['bottomCheese'] = "none";
                } else {
                    $burgerOptions['bottomCheese'] = $burger->cheeses['bottom'];
                    $burgerOptions['price'] += $this->menu->getCheese( (string)$burgerOptions['bottomCheese'] )->price;

                }

                foreach ( $burger->topping as $topping ) {
                    array_push( $burgerOptions['toppings'], $topping['type'] );
                    $burgerOptions['price'] += $this->menu->getTopping( (string)$topping['type'] )->price;
                }

                foreach ( $burger->sauce as $sauce ) {
                    array_push( $burgerOptions['sauces'], $sauce['type'] );
                }

                array_push( $this->burgers, $burgerOptions );

                $this->totalPrice += $burgerOptions['price'];
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

    function getBurgers()
    {
        return $this->burgers;
    }

    function getTotalPrice()
    {
        return $this->totalPrice;
    }

}