<?php

/**
 * Our homepage. Show the most recently added quote.
 *
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application
{

    function __construct()
    {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
        // Build a list of orders
        $files = array();
        foreach ( glob( DATAPATH . "order*.xml" ) as $filePath ) {
            $filePaths = array(
                'filename' => basename( $filePath, ".xml" )
            );
            array_push( $files, $filePaths );
        }

        // Present the list to choose from
        $this->data['orders'] = $files;
        $this->data['pagebody'] = 'homepage';
        $this->render();
    }

    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order( $filename )
    {
        // Build a receipt for the chosen order
        $order = new Orders( $filename );
        $orderName = ucfirst( basename( $filename, ".xml" ) );
        $customerName = $order->getCustomerName();
        $orderType = $order->getOrderType();
        $burgers = $order->getBurgers();
        $totalPrice = $order->getTotalPrice();

        for ( $i = 0; $i < count( $burgers ); $i++ ) {
            $burgers[$i]['toppings'] = $this->getToppings( $burgers[$i] );
        }

        for ( $i = 0; $i < count( $burgers ); $i++ ) {
            $burgers[$i]['sauces'] = $this->getSauces( $burgers[$i] );
        }

        // Present the list to choose from
        $this->data['orderName'] = $orderName;
        $this->data['customerName'] = $customerName;
        $this->data['orderType'] = $orderType;
        $this->data['burgers'] = $burgers;
        $this->data['totalPrice'] = $totalPrice;

        $this->data['pagebody'] = 'justone';
        $this->render();
    }

    function getToppings( $burger )
    {
        if ( empty( $burger['toppings'] ) ) {
            return "none";
        } else {
            return implode( ", ", $burger['toppings'] );
        }
    }

    function getSauces( $burger )
    {
        if ( empty( $burger['sauces'] ) ) {
            return "none";
        } else {
            return implode( ", ", $burger['sauces'] );
        }
    }

}
