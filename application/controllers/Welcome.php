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
                'filename' => basename($filePath)
            );
            array_push($files, $filePaths);
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
        $orderName = ucfirst(basename($filename, ".xml"));

        // Present the list to choose from
        $this->data['orderName'] = $orderName;
        $this->data['customerName'] = $order->getCustomerName();
        $this->data['orderType'] = $order->getOrderType();
        $this->data['pagebody'] = 'justone';
        $this->render();
    }


}
