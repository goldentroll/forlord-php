<?php
/**
 * 
 * MassPayClient
 * 
 * A class which facilitates the interaction with Payza's 
 * MassPay API. MassPayClient class allows user to create 
 * the data to be sent to the API in the correct format and 
 * retrieve the response. 
 * 
 * 
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY
 * OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT
 * LIMITED TO THE IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * @author Payza
 * @copyright 2009
 */

class MassPayClient
{
    /**
     * The API's response variables
     */
    private $responseArray;

    /**
     * The server address of the MassPay API
     */
    private $server = 'api.payza.com';

    /**
     * The exact URL of the MassPay API
     */
    private $url = '/svc/api.svc/executemasspay';

    /**
     * Your Payza user name which is your email address
     */
    private $myUserName = '';

    /**
     * Your API password that is generated from your Payza account
     */
    private $apiPassword = '';

    /**
     * The data that will be sent to the MassPay API
     */
    public $dataToSend = '';


    /**
     * MassPayClient::__construct()
     * 
     * Constructs a MassPayClient object
     * 
     * @param string $userName Your Payza user name.
     * @param string $password Your API password.
     */
    public function __construct($userName='', $password='')
    {
        $this->myUserName = $userName;
        $this->apiPassword = $password;
        $this->dataToSend = '';
    }


    /**
     * MassPayClient::setServer()
     * 
     * Sets the $server variable
     * 
     * @param string $newServer New web address of the server.
     */
    public function setServer($newServer = '')
    {
        $this->server = $newServer;
    }


    /**
     * MassPayClient::getServer()
     * 
     * Returns the server variable
     * 
     * @return string A variable containing the server's web address.
     */
    public function getServer()
    {
        return $this->server;
    }


    /**
     * MassPayClient::setUrl()
     * 
     * Sets the $url variable
     * 
     * @param string $newUrl New url address.
     */
    public function setUrl($newUrl = '')
    {
        $this->url = $newUrl;
    }


    /**
     * MassPayClient::getUrl()
     * 
     * Returns the url variable
     * 
     * @return string A variable containing a URL address.
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * MassPayClient::buildPostVariables()
     * 
     * Builds a URL encoded post string which contains the variables to be 
     * sent to the API in the correct format. 
     * 
     * @param int $payments Array containing the payments to be made.
     * @param string $currency 3 letter ISO-4217 currency code.
     * @param string $receiverEmail	Recipient's email address.
     * @param string $senderEmail Your secondary email (optional).
     * @param int $purchaseType A valid purchase type code.
     * @param int $testMode Test mode status.
     * 
     * @return string The URL encoded post string
     */
    public function buildPostVariables($payments, $currency = 'USD', $senderEmail = '', $testMode = '1')
    {
    	$iteration = count($payments);
    	$payees='';
    	
		//check if the received variable is an array
    	if (!is_array($payments)) 
		{ 
			die ("Argument is not an array!"); 
		}
    	else
    	{
			//create another array with proper parameter names
    		$p = 0;		//variable used for the subscript of the payment number
			for ($x = 0; $x < $iteration; $x++)
			{			    
				$p++;
		    	$payees .= "&RECEIVEREMAIL_$p=".urlencode($payments[$x]["receiver"])."&AMOUNT_$p=".urlencode($payments[$x]["amount"])."&NOTE_$p=".urlencode($payments[$x]["note"]);
			}    			
    	}
    	
        $this->dataToSend = sprintf("USER=%s&PASSWORD=%s&CURRENCY=%s&SENDEREMAIL=%s&TESTMODE=%s",
						            urlencode($this->myUserName),
									urlencode($this->apiPassword),
									urlencode($currency),
									urlencode($senderEmail),
									urlencode((string )$testMode));
        $this->dataToSend .= $payees;
        
        return $this->dataToSend;
    }


    /**
     * MassPayClient::send()
     * 
     * Sends the URL encoded post string to the MassPay API 
     * using cURL and retrieves the response.
     * 
     * @return string The response from the MassPay API.
     */
    public function send()
    {
        $response = '';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://' . $this->getServer() . $this->getUrl());
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->dataToSend);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


    /**
     * MassPayClient::parseResponse()
     * 
     * Parses the encoded response from the MassPay API
     * into an associative array.
     * 
     * @param string $input The string to be parsed by the function.
     */
    public function parseResponse($input)
    {
        parse_str($input, $this->responseArray);
    }


    /**
     * MassPayClient::getResponse()
     * 
     * Returns the responseArray 
     * 
     * @return string An array containing the response variables.
     */
    public function getResponse()
    {
        return $this->responseArray;
    }


    /**
     * MassPayClient::__destruct()
     * 
     * Destructor of the MassPayClient object
     */
    public function __destruct()
    {
        unset($this->responseArray);
    }
}