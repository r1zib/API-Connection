<?php
require_once (__dir__.'/developerforce/soapclient/SforcePartnerClient.php');
require_once (__dir__.'/developerforce/soapclient/SforceEnterpriseClient.php');

class ContactSalesforce {
	private $user;
	private $password;
	private $token;
	private $wsdl;
	
	private $mySforceConnection;
	
	function __construct($user,$password,$token,$wsdl ) {
		$this->user = $user;
		$this->password = $password;
		$this->token = $token;
		$this->wsdl = $wsdl;
	}
	
	function connection () {
		try {
			$this->mySforceConnection = new SforceEnterpriseClient();
			$this->mySforceConnection->createConnection($this->wsdl);
			$this->mySforceConnection->login($this->user, $this->password.$this->token);
        } catch (Exception $e) {
        	$msg = 'Problème de connection :'."Exception ".$e->faultstring."<br/><br/>\n";
        	$msg .= $this->infoMsg();
        	return $msg;
        }
        return true;
	}
	function infoMsg(){
		$msg = "Last Request:<br/>\n";
		$msg .= $this->mySforceConnection->getLastRequestHeaders()."<br/>\n";
		$msg .= $this->mySforceConnection->getLastRequest()."<br/>\n";
		$msg .= "Last Response:<br/><br/>\n";
		$msg .= $this->mySforceConnection->getLastResponseHeaders()."<br/>\n";
		$msg .= $this->mySforceConnection->getLastResponse()."<br/>\n";
		return $msg;
	}	
	
	function add(Contact $contact){
		
		$elt = $contact->toAdd();
		echo '<pre>';
		print_r($elt);
		
		$response = $this->mySforceConnection->create(array($elt), 'Contact');
		/* $response : 
		 * id -> the sObject that you attempted to create.
		 * success : boolean Indicates whether the create call succeeded (True) or not (False) for this object.
		 * errors -> Error[] If an error occurred during the create call, an array of one or more Error objects providing the error code and description.
		 */
		print_r($response);
		
		if ($response[0]->success) {
			$contact->setId($response[0]->id);
		} else {
		   $msg = implode(';', $response[0]->errors);
		   return $msg;
		   	
		}
		return true;
	}
	function update(Contact $contact) {
		$id = $contact->getId();
		if ($id == "" && $contact->getEmail() != "") {
			/* on va rechercher par rapport à l'adresse Email */
			$id = $this->recherche_email($contact->getEmail());
			if ($id === false) {
				
			} else {
				$contact->setId($id);
			}
			
		}	
        if ($contact->getId() == '') {
        	/* Il faut faire une création et pas un update */
        	
        } else {
			$elt = $contact->toAdd();
			$response = $this->mySforceConnection->update(array($elt), 'Contact');
			if ($response[0]->success) {
			} else {
				print_r($response);
			   $msg = implode(';', $response[0]->errors);
			   return $msg;	
			}

        }
        return true;
	}
	
	function recherche_email ($email) {
		$query = "SELECT Id, Email from Contact where Email = '".$email."'";
		$response = $mySforceConnection->query($query);
		if (count($response->size > 0)) {
			/* Pb il y a plusieurs contacts avex le même email */
		}
		if (count($response->size == 1)) {
			$id = $response->records[0]->$record->Id;
			echo '<pre>';
			print_r($response->records[0]);
			return $id;
		}
		return false;	
	}
	
	function delete($id){

		$response = $this->mySforceConnection->delete(array($id));
		
		if ($response[0]->success) {
			
		} else {
			$msg = implode(';', $response[0]->errors);
			return $msg;
		}
		return true;
	}
	
		
}