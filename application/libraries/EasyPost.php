<?php

class EasyPost 
{
	
	public function Calc($data) {

$tooo = array(
			        "name"    => $data['firstname'].' '.$data['lastname'],
			    	"street1" => $data['address'],
			    	"city"    => $data['city'],
			    	"state"   => $data['state'],
			    	"zip"     => $data['zip'],
			    	"phone"   => $data['phone']
			    );

		// print_r($data);
		// Require this file if you're not using composer's vendor/autoload

		// Required PHP extensions
		if (!function_exists('curl_init')) {
		  throw new Exception('EasyPost needs the CURL PHP extension.');
		}
		if (!function_exists('json_decode')) {
		  throw new Exception('EasyPost needs the JSON PHP extension.');
		}

		$app_path = str_replace('controllers\admin', '', dirname(__FILE__));
		// Config and Utilities
		require(dirname(__FILE__) . '/EasyPost/EasyPost.php');
		require(dirname(__FILE__) . '/EasyPost/Util.php');
		require(dirname(__FILE__) . '/EasyPost/Error.php');

		// Guts
		require(dirname(__FILE__) . '/EasyPost/Object.php');
		require(dirname(__FILE__) . '/EasyPost/Resource.php');
		require(dirname(__FILE__) . '/EasyPost/Requestor.php');

		// API Resources
		require(dirname(__FILE__) . '/EasyPost/Address.php');
		require(dirname(__FILE__) . '/EasyPost/Batch.php');
		require(dirname(__FILE__) . '/EasyPost/CarrierAccount.php');
		require(dirname(__FILE__) . '/EasyPost/Container.php');
		require(dirname(__FILE__) . '/EasyPost/CustomsInfo.php');
		require(dirname(__FILE__) . '/EasyPost/CustomsItem.php');
		require(dirname(__FILE__) . '/EasyPost/Event.php');
		require(dirname(__FILE__) . '/EasyPost/Fee.php');
		require(dirname(__FILE__) . '/EasyPost/Item.php');
		require(dirname(__FILE__) . '/EasyPost/Order.php');
		require(dirname(__FILE__) . '/EasyPost/Parcel.php');
		require(dirname(__FILE__) . '/EasyPost/Pickup.php');
		require(dirname(__FILE__) . '/EasyPost/PostageLabel.php');
		require(dirname(__FILE__) . '/EasyPost/Rate.php');
		require(dirname(__FILE__) . '/EasyPost/Refund.php');
		require(dirname(__FILE__) . '/EasyPost/ScanForm.php');
		require(dirname(__FILE__) . '/EasyPost/Shipment.php');
		require(dirname(__FILE__) . '/EasyPost/Tracker.php');
		require(dirname(__FILE__) . '/EasyPost/User.php');

		//$this->load->library('EasyPost');
		
			// $weight = $this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->config->get('easypost_weight_class_id'));
			
			// \EasyPost\EasyPost::setApiKey('vglmzgFOjumHDVh8X26iSw');
			\EasyPost\EasyPost::setApiKey('cueqNZUb3ldeWTNX7MU3Mel8UXtaAMUi');

			$shipment = \EasyPost\Shipment::create(array(
			  'to_address' => array(
 					"name"    => "Dr. Steve Brule",
			        "street1" => "179 N Harbor Dr",
			        "city"    => "Redondo Beach",
			        "state"   => "CA",
			        "zip"     => "90277",
			        "phone"   => "310-808-5243"
			
			  ),
			  'from_address' => array(
			    "company" => "EasyPost",
			    "street1" => "118 2nd Street",
			    "street2" => "4th Floor",
			    "city"    => "San Francisco",
			    "state"   => "CA",
			    "zip"     => "94105",
			    "phone"   => "415-456-7890"
			  ),
			  'parcel' => array(
			    'length' => "10",
			    'width' => "50",
			    'height' => "45",
			    'weight' => "50"
			  )
			));

			// $to_address = \EasyPost\Address::create(
			    
			//     array(
			//         "name"    => "Dr. Steve Brule",
			//         "street1" => "179 N Harbor Dr",
			//         "city"    => "Redondo Beach",
			//         "state"   => "CA",
			//         "zip"     => "90277",
			//         "phone"   => "310-808-5243"
			//     )
			// );
			// $from_address = \EasyPost\Address::create(
			//     array(
			//         "company" => "EasyPost",
			//     	"street1" => "118 2nd Street",
			//     	"street2" => "4th Floor",
			//     	"city"    => "San Francisco",
			//     	"state"   => "CA",
			//     	"zip"     => "94105",
			//     	"phone"   => "415-456-7890"
			//     )
			// );
			// $parcel = \EasyPost\Parcel::create(
			//     array(
			//         "predefined_package" => "LargeFlatRateBox",
			//         "weight" => 76.9
			//     )
			// );
			// $shipment = \EasyPost\Shipment::create(
			//     array(
			//         "to_address"   => $to_address,
			//         "from_address" => $from_address,
			//         "parcel"       => $parcel
			//     )
			// );

			$shipment->buy($shipment->lowest_rate());

			$shipment->insure(array('amount' => 100));

			// $this->data['easypost_label'] = $shipment->postage_label->label_url;

			// $this->load->view('admin/easypost_label',$this->data);

			$ship_data = json_decode($shipment);
			return $ship_data->rates;
			//echo "<pre>";
			//print_r($data);exit;

		// 	$method_data = array();
		// 	$i = 1;
		// 	foreach($data->rates as $row) {
		// 		$quote_data[$i] = array(
		// 			'code'         => 'easypost.'.$i,
		// 			'title'        => $row->service,
		// 			'cost'         => $this->currency->convert($row->rate, 'USD', $this->config->get('config_currency')),
		// 			'tax_class_id' => $this->config->get('easypost_tax_class_id'),
		// 			'text'         => $this->currency->format($this->tax->calculate($this->currency->convert($row->rate, 'USD', $this->currency->getCode()), $this->config->get('easypost_tax_class_id'), $this->config->get('config_tax')), $this->currency->getCode(), 1.0000000)
		// 		);
		// 		$i++;
		// 	}

		// 	$method_data = array(
		// 		'code'       => "easypost",
		// 		'title'      => $row->service,
		// 		'quote'      => $quote_data,
		// 		'sort_order' => 1,
		// 		'error'      => false
		// 	);
		// }
		// print_r($method_data);
		// // return $method_data;
		// echo "check:";
	}
}