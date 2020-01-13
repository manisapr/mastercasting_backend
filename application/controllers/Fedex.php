<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH.'config/credentials.php';
require_once APPPATH.'config/bootstrap.php';

use FedEx\ShipService;
use FedEx\ShipService\Request as ShipServiceRequest;
use FedEx\ShipService\ComplexType;
use FedEx\ShipService\SimpleType;

use FedEx\TrackService\Request as TrackRequest;
use FedEx\TrackService\ComplexType as TrackComplexType;
use FedEx\TrackService\SimpleType as TrackSimpleType;

use FedEx\AddressValidationService\Request as AddressValidationRequest;
use FedEx\AddressValidationService\ComplexType as AddressValidationComplexType;
use FedEx\AddressValidationService\SimpleType as AddressValidationSimpleType;

use FedEx\RateService\Request as RateRequest;
use FedEx\RateService\ComplexType as RateComplexType;
use FedEx\RateService\SimpleType as RateSimpleType;

ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);

class Fedex extends CI_Controller
{

    private $email_form = 'oscar@www.mastercastingandcad.com';

    private $fedex_track_url = "https://www.fedex.com/apps/fedextrack/index.html?action=track&tracknumbers=";

    public function login_check()
    {
        if (!$this->session->userdata('user_id')) {
            return redirect();
        }
    }

    private function email_config()
    {
        return $config = array(
            'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
            'smtp_host' => 'smtp.mailgun.org',
            'smtp_port' => 2525,
            'smtp_user' => 'postmaster@www.mastercastingandcad.com',
            'smtp_pass' => '89e954a6422e1797b501ea7f2cbdbee1-87cdd773-1c23fff2',
            // 'smtp_crypto' => 'tsl', //can be 'ssl' or 'tls' for example
            'mailtype' => 'html', //plaintext 'text' mails or 'html'
            'smtp_timeout' => '4', //in seconds
            'charset' => 'iso-8859-1',
            'wordwrap' => true
        );
    }

    function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->model('projectmodel');
        $this->session->keep_flashdata('send_ship_details');
        $this->session->keep_flashdata('fedex_ship');
    }

    public function ship($project_id)
    {
    	// phpinfo();die;
        $this->login_check();

        /**
         * This test will send the same test data as in FedEx's documentation:
         * /php/RateAvailableServices/RateAvailableServices.php5
         */

        //remember to copy example.credentials.php as credentials.php replace 'FEDEX_KEY', 'FEDEX_PASSWORD', 'FEDEX_ACCOUNT_NUMBER', and 'FEDEX_METER_NUMBER'
        

        $project_details = $this->db->get_where('project_details', ['project_id' => $project_id])->row();
        $ship_details = $this->projectmodel->ship_address($project_id);

        // print_r($ship_details);
        // // // echo $this->projectmodel->get_ship_suctomer_email($project_id);
        // // echo $ship_details->customer_email;
        // die;


        $userCredential = new ComplexType\WebAuthenticationCredential();
        $userCredential
            ->setKey(FEDEX_KEY)
            ->setPassword(FEDEX_PASSWORD);

        $webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
        $webAuthenticationDetail->setUserCredential($userCredential);

        $clientDetail = new ComplexType\ClientDetail();
        $clientDetail
            ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
            ->setMeterNumber(FEDEX_METER_NUMBER);

        $version = new ComplexType\VersionId();
        $version
            ->setMajor(23)
            ->setIntermediate(0)
            ->setMinor(0)
            ->setServiceId('ship');

        $shipperAddress = new ComplexType\Address();
        $shipperAddress
            ->setStreetLines(['68 E Madison Street'])
            ->setCity('Chicago')
            ->setStateOrProvinceCode('IL')
            ->setPostalCode('60602')
            ->setCountryCode('US');

        $shipperContact = new ComplexType\Contact();
        $shipperContact
            ->setCompanyName('MCC Fulfillment')
            ->setEMailAddress('http://mastercastingandcad.com')
            //->setPersonName('Oscar Valencia')
            ->setPhoneNumber(('312-332-4434'));

        $shipper = new ComplexType\Party();
        $shipper
            ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
            ->setAddress($shipperAddress)
            ->setContact($shipperContact);

        $recipientAddress = new ComplexType\Address();
        $recipientAddress
            ->setStreetLines([$ship_details->address])
            ->setCity($ship_details->city)
            ->setStateOrProvinceCode($ship_details->region)
            ->setPostalCode($ship_details->postal_code)
            ->setCountryCode($ship_details->country)
            ->setResidential($ship_details->residential_address);

        $recipientContact = new ComplexType\Contact();
        $recipientContact
            ->setPersonName($ship_details->customer_name)
            ->setPhoneNumber($ship_details->customer_phone);

        $recipient = new ComplexType\Party();
        $recipient
            ->setAddress($recipientAddress)
            ->setContact($recipientContact);

        $labelSpecification = new ComplexType\LabelSpecification();
        $labelSpecification
            ->setLabelStockType(new SimpleType\LabelStockType($ship_details->lable_stock_type))
            ->setImageType(new SimpleType\ShippingDocumentImageType(SimpleType\ShippingDocumentImageType::_PDF))
            ->setLabelFormatType(new SimpleType\LabelFormatType(SimpleType\LabelFormatType::_COMMON2D));

        // $desc = 'Finish : Satin Finish';

        $packageLineItem1 = new ComplexType\RequestedPackageLineItem();
        $packageLineItem1
            ->setSequenceNumber(1)
            ->setItemDescription($project_details->description)
            // ->setDimensions(new ComplexType\Dimensions(array(
            //     'Width' => 10,
            //     'Height' => 10,
            //     'Length' => 25,
            //     'Units' => SimpleType\LinearUnits::_IN
            // )))
            ->setWeight(new ComplexType\Weight(array(
                'Value' => $ship_details->weight,
                'Units' => $ship_details->weight_unit
            )));

        $shippingChargesPayor = new ComplexType\Payor();
        $shippingChargesPayor->setResponsibleParty($shipper);

        $shippingChargesPayment = new ComplexType\Payment();
        $shippingChargesPayment
            ->setPaymentType(SimpleType\PaymentType::_SENDER)
            ->setPayor($shippingChargesPayor);

        if($ship_details->custom_value != NULL){
            $money = new ComplexType\Money;
            $money->setCurrency('USD');
            $money->setAmount($ship_details->custom_value);
            $customsClearanceDetail = new ComplexType\CustomsClearanceDetail;
            $customsClearanceDetail->setCustomsValue($money);
        }

        $ship_service = $ship_details->shipping_method;

        $requestedShipment = new ComplexType\RequestedShipment();
        $requestedShipment->setShipTimestamp(date('c'));
        $requestedShipment->setDropoffType(new SimpleType\DropoffType(SimpleType\DropoffType::_REGULAR_PICKUP));
        $requestedShipment->setServiceType(new SimpleType\ServiceType($ship_service));
        $requestedShipment->setPackagingType(new SimpleType\PackagingType(SimpleType\PackagingType::_YOUR_PACKAGING));
        $requestedShipment->setShipper($shipper);
        $requestedShipment->setRecipient($recipient);
        $requestedShipment->setLabelSpecification($labelSpecification);
        $requestedShipment->setRateRequestTypes(array(new SimpleType\RateRequestType(SimpleType\RateRequestType::_PREFERRED)));
        $requestedShipment->setPackageCount(1);
        $requestedShipment->setShippingChargesPayment($shippingChargesPayment);
        $requestedShipment->setRequestedPackageLineItems([
            $packageLineItem1
        ]);

        if($ship_details->custom_value != NULL){
            $requestedShipment->setCustomsClearanceDetail($customsClearanceDetail);
        }


        $processShipmentRequest = new ComplexType\ProcessShipmentRequest();
        $processShipmentRequest->setWebAuthenticationDetail($webAuthenticationDetail);
        $processShipmentRequest->setClientDetail($clientDetail);
        $processShipmentRequest->setVersion($version);
        $processShipmentRequest->setRequestedShipment($requestedShipment);

        $shipService = new ShipServiceRequest();
        $shipService->getSoapClient()->__setLocation('https://ws.fedex.com:443/web-services/ship');
        
        $result = $shipService->getProcessShipmentReply($processShipmentRequest);


        // // Save .pdf label
        if($result->HighestSeverity === 'ERROR'){
            $data['error_type'] = 'Error';
            $data['error'] = $result->Notifications[0]->Message;
            echo "<pre>";
            print_r($result);
            // $this->load->view('errors/error', $data);
            return;
        }



        // rate calculation
        $rate = $this->total_rate_calc($result);

        $time = date('m_d_y');
        $filename = 'shipment_details_of_'.$project_id.'_'.$time.'.pdf';
        if (!file_exists(FCPATH.'/uploads/fedex/shipping_label/'.$filename)) {
            file_put_contents(FCPATH.'/uploads/fedex/shipping_label/'.$filename, $result->CompletedShipmentDetail->CompletedPackageDetails[0]->Label->Parts[0]->Image);
        }

        
        $this->db->update('project_details', ['tracking' => $result->CompletedShipmentDetail->MasterTrackingId->TrackingNumber, 'type' => 'completed'], ['project_id' => $project_id]);
        $this->db->update('project_disposition', ['flag' => 1], ['project_id' => $project_id]);
        $this->db->update('ship', ['is_shipped' => 1, 'file' => $filename, 'rate' => $rate], ['project_id' => $project_id]);


        $this->send_shipment_details_mail($ship_details->customer_email, $project_id, $filename);



        $this->session->set_flashdata('fedex_ship', 'success');

        redirect('projects/project_details/'.$project_id);
    }

    public function total_rate_calc($result){
        // rate calculation
        $rate = 0;
        if(isset($result->CompletedShipmentDetail->ShipmentRating)){
            foreach ($result->CompletedShipmentDetail->ShipmentRating->ShipmentRateDetails as $key) {
                $rate += $key->TotalNetCharge->Amount;
            }
        }

        return $this->projectmodel->get_percentile_rate($rate);
    }

    public function send_shipment_details_mail($email = 'sjgalaxy98@gmail.com', $project_id = 1001, $filename = 'shipment_details_of_1001_10_03_19.pdf')
    {
        $config = $this->email_config();
        $this->load->library('email', $config);

        $ship_details = $this->db->get_where('ship', ['project_id' => $project_id])->row();
        $project_details = $this->db->get_where('project_details', ['project_id' => $project_id])->row();

        ob_start(); ?>
        
        <p class="msg">Your mcc order <?php echo $ship_details->ship_id ?> is ready to ship via Fedex using <?php echo $ship_details->shipping_method ?>.</p>

        <p class="msg"><a href="https://www.fedex.com/apps/fedextrack/index.html?action=track&tracknumbers=<?php echo $project_details->tracking ?>">Click Here</a> anytime to keep track of its progress. You can also track your order by visiting <a href="https://www.fedex.com">https://www.fedex.com</a> anytime and using the following tracking number(s): <?php echo $project_details->tracking ?>.</p>
        
        <?php

        $data['html'] = ob_get_clean();
        $data['name'] = $ship_details->customer_name;

        $html = $this->load->view('default_email_template', $data, true);

        // $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->email_form, 'Master Casting'); // change it to yours
        $this->email->to($email); // change it to yours
        $this->email->subject("Shipment details");
        $this->email->message($html);
        $this->email->attach(DOMAIN.'/mastercasting_backend/uploads/fedex/shipping_label/'.$filename);
        $this->email->send();
    }

    public function track($trackingId1 = 123456789012)
    {
        $this->login_check();

        // $trackingId1 = 123456789012;
        // $trackingId2 = 123456789012;

        $trackRequest = new TrackComplexType\TrackRequest();

        // User Credential
        $trackRequest->WebAuthenticationDetail->UserCredential->Key = FEDEX_KEY;
        $trackRequest->WebAuthenticationDetail->UserCredential->Password = FEDEX_PASSWORD;

        // Client Detail
        $trackRequest->ClientDetail->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $trackRequest->ClientDetail->MeterNumber = FEDEX_METER_NUMBER;

        // Version
        $trackRequest->Version->ServiceId = 'trck';
        $trackRequest->Version->Major = 16;
        $trackRequest->Version->Intermediate = 0;
        $trackRequest->Version->Minor = 0;

        // Track 2 shipments
        $trackRequest->SelectionDetails = [new TrackComplexType\TrackSelectionDetail(), new TrackComplexType\TrackSelectionDetail()];

        // Track shipment 1
        $trackRequest->SelectionDetails[0]->PackageIdentifier->Value = $trackingId1;
        $trackRequest->SelectionDetails[0]->PackageIdentifier->Type = TrackSimpleType\TrackIdentifierType::_TRACKING_NUMBER_OR_DOORTAG;

        // Track shipment 2
        // $trackRequest->SelectionDetails[1]->PackageIdentifier->Value = $trackingId2;
        // $trackRequest->SelectionDetails[1]->PackageIdentifier->Type = TrackSimpleType\TrackIdentifierType::_TRACKING_NUMBER_OR_DOORTAG;

        $request = new TrackRequest();
        $request->getSoapClient()->__setLocation(TrackRequest::PRODUCTION_URL); //use production URL

        $trackReply = $request->getTrackReply($trackRequest);

        echo "<pre>";
        print_r($trackReply);
    }

    public function send_ship_label($project_id)
    {
        $ship_details = $this->db->get_where('ship', ['project_id' => $project_id])->row();
        $this->send_shipment_details_mail($ship_details->customer_email, $project_id, $shp_details->file);

        // $this->session->set_flashdata('send_ship_details', 'success');

        redirect('projects/project_details/'.$project_id);
    }

    public function address_validation($project_id = null)
    {
        $ship_details = $this->db->get_where('ship', ['project_id' => $project_id])->row();

        $addressValidationRequest = new AddressValidationComplexType\AddressValidationRequest();

        // User Credentials
        $addressValidationRequest->WebAuthenticationDetail->UserCredential->Key = FEDEX_KEY;
        $addressValidationRequest->WebAuthenticationDetail->UserCredential->Password = FEDEX_PASSWORD;

        // Client Detail
        $addressValidationRequest->ClientDetail->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $addressValidationRequest->ClientDetail->MeterNumber = FEDEX_METER_NUMBER;

        // Version
        $addressValidationRequest->Version->ServiceId = 'aval';
        $addressValidationRequest->Version->Major = 4;
        $addressValidationRequest->Version->Intermediate = 0;
        $addressValidationRequest->Version->Minor = 0;

        // Address(es) to validate.
        $addressValidationRequest->AddressesToValidate = [new AddressValidationComplexType\AddressToValidate()]; // just validating 1 address in this example.
        $addressValidationRequest->AddressesToValidate[0]->Address->StreetLines = [$ship_details->address];
        $addressValidationRequest->AddressesToValidate[0]->Address->City = $ship_details->city;
        $addressValidationRequest->AddressesToValidate[0]->Address->StateOrProvinceCode = $ship_details->region;
        $addressValidationRequest->AddressesToValidate[0]->Address->PostalCode = $ship_details->postal_code;
        $addressValidationRequest->AddressesToValidate[0]->Address->CountryCode =  $ship_details->country;

        $request = new AddressValidationRequest();
        $addressValidationReply = $request->getAddressValidationReply($addressValidationRequest);
        echo "<pre>";
        print_r($addressValidationReply->AddressResults[0]->Attributes);
    }

    public function cancel_shipment()
    {
        $trackingNumber = '794638113083';

        $cancelPendingShipmentRequest = new ComplexType\CancelPendingShipmentRequest();
        $cancelPendingShipmentRequest->WebAuthenticationDetail->UserCredential->Key = FEDEX_KEY;
        $cancelPendingShipmentRequest->WebAuthenticationDetail->UserCredential->Password = FEDEX_PASSWORD;
        $cancelPendingShipmentRequest->ClientDetail->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $cancelPendingShipmentRequest->ClientDetail->MeterNumber = FEDEX_METER_NUMBER;
        $cancelPendingShipmentRequest->Version->ServiceId = 'ship';
        $cancelPendingShipmentRequest->Version->Major = 12;
        $cancelPendingShipmentRequest->Version->Intermediate = 1;
        $cancelPendingShipmentRequest->Version->Minor = 0;
        $cancelPendingShipmentRequest->TrackingId->TrackingNumber = $trackingNumber;


        $shipServiceRequest = new ShipServiceRequest();
        $cancelPendingShipmentReply = $shipServiceRequest->getCancelPendingShipmentReply($cancelPendingShipmentRequest);

        var_dump($cancelPendingShipmentReply);
    }

    public function rate($project_id = NULL){

        $type = $this->input->post('type');

        // echo "<pre>";
        $ship_details = $this->projectmodel->ship_address($project_id, $type);

        $rateRequest = new RateComplexType\RateRequest();

        //authentication & client details
        $rateRequest->WebAuthenticationDetail->UserCredential->Key = FEDEX_KEY;
        $rateRequest->WebAuthenticationDetail->UserCredential->Password = FEDEX_PASSWORD;
        $rateRequest->ClientDetail->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $rateRequest->ClientDetail->MeterNumber = FEDEX_METER_NUMBER;

        $rateRequest->TransactionDetail->CustomerTransactionId = 'testing rate service request';

        //version
        $rateRequest->Version->ServiceId = 'crs';
        $rateRequest->Version->Major = 24;
        $rateRequest->Version->Minor = 0;
        $rateRequest->Version->Intermediate = 0;

        $rateRequest->ReturnTransitAndCommit = true;

        //shipper
        $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
        $rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['68 E Madison Street'];
        $rateRequest->RequestedShipment->Shipper->Address->City = 'Chicago';
        $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'IL';
        $rateRequest->RequestedShipment->Shipper->Address->PostalCode = 60602;
        $rateRequest->RequestedShipment->Shipper->Address->CountryCode = 'US';

        //recipient
        $rateRequest->RequestedShipment->Recipient->Address->StreetLines = [$ship_details->address];
        $rateRequest->RequestedShipment->Recipient->Address->City = $ship_details->city;
        $rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = $ship_details->country == "GB" ? "" : $ship_details->region;
        $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $ship_details->postal_code;
        $rateRequest->RequestedShipment->Recipient->Address->CountryCode = $ship_details->country;
        if ($type == 'drop_ship') {
            $rateRequest->RequestedShipment->Recipient->Address->Residential = $ship_details->residential_address;
        }
        
        //shipping charges payment
        $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = RateSimpleType\PaymentType::_SENDER;

        //rate request types
        $rateRequest->RequestedShipment->RateRequestTypes = [RateSimpleType\RateRequestType::_NONE];

        $rateRequest->RequestedShipment->PackageCount = 1;

        //create package line items
        $specialServiceRequest = new RateComplexType\PackageSpecialServicesRequested();
        // RateSimpleType\SignatureOptionType::_DIRECT
        $specialServiceRequest
            ->setSpecialServiceTypes( array(RateSimpleType\PackageSpecialServiceType::_SIGNATURE_OPTION))
            ->setSignatureOptionDetail(
                (new RateComplexType\SignatureOptionDetail())->setOptionType($ship_details->signature_type));
        $requestedPackageLineItem = new RateComplexType\RequestedPackageLineItem();
        $requestedPackageLineItem
            ->setSpecialServicesRequested($specialServiceRequest);
        $rateRequest->RequestedShipment->RequestedPackageLineItems = [$requestedPackageLineItem];

        //package 1
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = $ship_details->weight;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = $ship_details->weight_unit;
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = 25;
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = 10;
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = 10;
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = RateSimpleType\LinearUnits::_IN;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;

        // //package 2
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Value = 5;
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Units = RateSimpleType\WeightUnits::_LB;
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Length = 20;
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Width = 20;
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Height = 10;
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Units = RateSimpleType\LinearUnits::_IN;
        // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->GroupPackageCount = 1;

        $rateServiceRequest = new RateRequest();
        $rateServiceRequest->getSoapClient()->__setLocation(RateRequest::PRODUCTION_URL); //use production URL

        $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); // send true as the 2nd argument to return the SoapClient's stdClass response.

        // echo "<pre>";
        // print_r($rateReply);die;

        if($rateReply->HighestSeverity === 'WARNING'){
             return die($rateReply->Notifications[0]->Message);
        } else if($rateReply->HighestSeverity === 'ERROR'){
             return die($rateReply->Notifications[0]->Message);
        }


        if (!empty($rateReply->RateReplyDetails)) {
            foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
                echo "<b>";
                print_r($rateReplyDetail->ServiceType);
                echo "</b>";
                echo " = ";
                if (!empty($rateReplyDetail->RatedShipmentDetails)) {
                    foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
                        print_r(" $" . $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount. " - $". $this->projectmodel->get_percentile_rate($ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount) . " (10%)");
                    }
                }
                echo "<hr />";
            }
        }

        // print_r($rateReply);
    }

    public function multiple_ship(){
        $this->login_check();

        $project_ids = $this->input->post('project_id');
        $ship = $this->db->select("shipping_type, shipping_method, address, city, region, postal_code, country")->where_in('project_id', $project_ids)->get('ship')->result();

        $shipping_type = array_column($ship, 'shipping_type');
        // $shipping_method = array_column($ship, 'shipping_method');

        if(count(array_unique($shipping_type)) !== 1){
            echo json_encode(array("status" => "error","msg" => "Shipping types are different for this selected job. \n ***Please select same shipping type jobs"));
            return;
        }

        if($shipping_type[0] == 'drop_ship'){
            $shipping_country = array_column($ship, 'country');
            $error = 0;
            if(count(array_unique($shipping_country)) !== 1){
                echo json_encode(array("status" => "error", "msg" => "Shipping country not mathced \n"));
                $error++;
            }

            $shipping_postal = array_column($ship, 'postal_code');
            if(count(array_unique($shipping_postal)) !== 1){
                echo json_encode(array("status" => "error", "msg" => "Shipping postal not mathced \n"));
                $error++;
            }

            $shipping_region = array_column($ship, 'region');
            if(count(array_unique($shipping_region)) !== 1){
                echo json_encode(array("status" => "error", "msg" => "Shipping region not mathced \n"));
                $error++;
            }

            $shipping_city = array_column($ship, 'city');
            if(count(array_unique($shipping_city)) !== 1){
                echo json_encode(array("status" => "error", "msg" => "Shipping city not mathced \n"));
                $error++;
            }


            $shipping_address = array_column($ship, 'address');
            if(count(array_unique($shipping_address)) !== 1){
                echo json_encode(array("status" => "error", "msg" => "Shipping address not mathced \n"));
                $error++;
            }

            if(!empty($error))
                return;
        }

        $inp_tracking_id = $this->input->post('tracking');

        if($inp_tracking_id != ''){
            $inp_rate = $this->input->post('rate');
            foreach($project_ids as $key){

                $this->db->update('project_details', ['tracking' => $inp_tracking_id, 'type' => 'completed'], ['project_id' => $key]);
                $this->db->update('project_disposition', ['flag' => 1], ['project_id' => $key]);
                $this->db->update('ship', ['is_shipped' => 1, 'rate' => $inp_rate], ['project_id' => $key]);
            }

            if(count($project_ids) > 1){
                $this->db->insert('ship_group', ['ship_ids' => implode(',', $project_ids)]);
                $group_id = $this->db->insert_id();
                $this->db->set(['group_id' => $group_id])->where_in('project_id', $project_ids)->update('ship');
            }
            
            echo json_encode(array("status" => "success", "msg" => 'Project shipped'));
            return;
        }

        // echo json_encode(array("status" => "error", "msg" => 'eeee'));
        //     return;


        $data = $this->multipe_ship_process($project_ids[0]);

        if(isset($data['error']) && $data['error'] != ''){
            echo json_encode(array("status" => "error", "msg" => $data['error']));
            return;
        }

        // print_r($data);

        foreach($project_ids as $key){
            $time = date('m_d_y');

            $filename = 'shipment_details_of_'.$key.'_'.$time.'.pdf';
            if (!file_exists(FCPATH.'/uploads/fedex/shipping_label/'.$filename)) {
                file_put_contents(FCPATH.'/uploads/fedex/shipping_label/'.$filename, $data['file']);
            }
            $this->db->update('project_details', ['tracking' => $data['tracking'], 'type' => 'completed'], ['project_id' => $key]);
            $this->db->update('project_disposition', ['flag' => 1], ['project_id' => $key]);
            $this->db->update('ship', ['is_shipped' => 1, 'file' => $filename, 'rate' => $data['rate']], ['project_id' => $key]);
            
            $ship_details = $this->projectmodel->ship_address($key);

            $this->send_shipment_details_mail($ship_details->customer_email, $key, $filename);
        }

        if(count($project_ids) > 1){
            $this->db->insert('ship_group', ['ship_ids' => implode(',', $project_ids)]);
            $group_id = $this->db->insert_id();
            $this->db->set(['group_id' => $group_id])->where_in('project_id', $project_ids)->update('ship');
        }


        echo json_encode(array("status" => "success", "msg" => "Project shipped"));;
        return;
    }


    public function multipe_ship_process($project_id)
    {
        $this->login_check();

        /**
         * This test will send the same test data as in FedEx's documentation:
         * /php/RateAvailableServices/RateAvailableServices.php5
         */

        //remember to copy example.credentials.php as credentials.php replace 'FEDEX_KEY', 'FEDEX_PASSWORD', 'FEDEX_ACCOUNT_NUMBER', and 'FEDEX_METER_NUMBER'
        

        $project_details = $this->db->get_where('project_details', ['project_id' => $project_id])->row();
        $ship_details = $this->projectmodel->ship_address($project_id);

        $userCredential = new ComplexType\WebAuthenticationCredential();
        $userCredential
            ->setKey(FEDEX_KEY)
            ->setPassword(FEDEX_PASSWORD);

        $webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
        $webAuthenticationDetail->setUserCredential($userCredential);

        $clientDetail = new ComplexType\ClientDetail();
        $clientDetail
            ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
            ->setMeterNumber(FEDEX_METER_NUMBER);

        $version = new ComplexType\VersionId();
        $version
            ->setMajor(25)
            ->setIntermediate(0)
            ->setMinor(0)
            ->setServiceId('ship');

        $shipperAddress = new ComplexType\Address();
        $shipperAddress
            ->setStreetLines(['68 E Madison Street'])
            ->setCity('Chicago')
            ->setStateOrProvinceCode('IL')
            ->setPostalCode('60602')
            ->setCountryCode('US');

        $shipperContact = new ComplexType\Contact();
        $shipperContact
            ->setCompanyName('MCC Fulfillment')
            ->setEMailAddress('http://mastercastingandcad.com')
            //->setPersonName('Oscar Valencia')
            ->setPhoneNumber(('312-332-4434'));

        $shipper = new ComplexType\Party();
        $shipper
            ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
            ->setAddress($shipperAddress)
            ->setContact($shipperContact);

        $recipientAddress = new ComplexType\Address();
        $recipientAddress
            ->setStreetLines([$ship_details->address])
            ->setCity($ship_details->city)
            ->setStateOrProvinceCode($ship_details->region)
            ->setPostalCode($ship_details->postal_code)
            ->setCountryCode($ship_details->country);

        $recipientContact = new ComplexType\Contact();
        $recipientContact
            ->setPersonName($ship_details->customer_name)
            ->setPhoneNumber($ship_details->customer_phone);

        $recipient = new ComplexType\Party();
        $recipient
            ->setAddress($recipientAddress)
            ->setContact($recipientContact);

        $labelSpecification = new ComplexType\LabelSpecification();
        $labelSpecification
            ->setLabelStockType(new SimpleType\LabelStockType(SimpleType\LabelStockType::_PAPER_7X4POINT75))
            ->setImageType(new SimpleType\ShippingDocumentImageType(SimpleType\ShippingDocumentImageType::_PDF))
            ->setLabelFormatType(new SimpleType\LabelFormatType(SimpleType\LabelFormatType::_COMMON2D));


        $packageLineItem1 = new ComplexType\RequestedPackageLineItem();
        $packageLineItem1
            ->setSequenceNumber(1)
            ->setItemDescription($project_details->description)
            ->setWeight(new ComplexType\Weight(array(
                'Value' => 2,
                'Units' => SimpleType\WeightUnits::_LB
            )));

        $shippingChargesPayor = new ComplexType\Payor();
        $shippingChargesPayor->setResponsibleParty($shipper);

        $shippingChargesPayment = new ComplexType\Payment();
        $shippingChargesPayment
            ->setPaymentType(SimpleType\PaymentType::_SENDER)
            ->setPayor($shippingChargesPayor);

        if($ship_details->custom_value != NULL){
            $money = new ComplexType\Money;
            $money->setCurrency('USD');
            $money->setAmount($ship_details->custom_value);
            $customsClearanceDetail = new ComplexType\CustomsClearanceDetail;
            $customsClearanceDetail->setCustomsValue($money);
        }

        $ship_service = $ship_details->shipping_method;

        $requestedShipment = new ComplexType\RequestedShipment();
        $requestedShipment->setShipTimestamp(date('c'));
        $requestedShipment->setDropoffType(new SimpleType\DropoffType(SimpleType\DropoffType::_REGULAR_PICKUP));
        $requestedShipment->setServiceType(new SimpleType\ServiceType($ship_service));
        $requestedShipment->setPackagingType(new SimpleType\PackagingType(SimpleType\PackagingType::_YOUR_PACKAGING));
        $requestedShipment->setShipper($shipper);
        $requestedShipment->setRecipient($recipient);
        $requestedShipment->setLabelSpecification($labelSpecification);
        $requestedShipment->setRateRequestTypes(array(new SimpleType\RateRequestType(SimpleType\RateRequestType::_PREFERRED)));
        $requestedShipment->setPackageCount(1);
        $requestedShipment->setRequestedPackageLineItems([
            $packageLineItem1
        ]);

        if($ship_details->custom_value != NULL){
            $requestedShipment->setShippingChargesPayment($shippingChargesPayment);
            $requestedShipment->setCustomsClearanceDetail($customsClearanceDetail);
        }


        $processShipmentRequest = new ComplexType\ProcessShipmentRequest();
        $processShipmentRequest->setWebAuthenticationDetail($webAuthenticationDetail);
        $processShipmentRequest->setClientDetail($clientDetail);
        $processShipmentRequest->setVersion($version);
        $processShipmentRequest->setRequestedShipment($requestedShipment);

        $shipService = new ShipService\Request();
        $shipService->getSoapClient()->__setLocation('https://wsbeta.fedex.com:443/web-services');
        $result = $shipService->getProcessShipmentReply($processShipmentRequest);



        if($result->HighestSeverity === 'ERROR'){
            $data['error'] = $result->Notifications[0]->Message;
        } else {

            $data['rate'] = $this->total_rate_calc($result);

            $data['tracking'] = $result->CompletedShipmentDetail->MasterTrackingId->TrackingNumber;

            $data['file'] = $result->CompletedShipmentDetail->CompletedPackageDetails[0]->Label->Parts[0]->Image;
        }


        return $data;

    }
    
}