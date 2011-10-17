<?php

require_once('simpletest/autorun.php');
require_once('../salesforce/ContactSalesforce.php');
require_once('../salesforce/Contact.php');

require_once('../salesforce/config.php');


class TestContactSalesforce extends UnitTestCase {
private $sales;	
	
	
	function testConnection () {
	   $this->sales = new ContactSalesforce(USERNAME, PASSWORD, SECURITY_TOKEN, WSDL);
	   print_r ($this->sales);
	   $this->assertIdentical(1, 1);	
	   
	   $ret = $this->sales->connection();
	   echo $ret;
	   
	   $this->assertIdentical($ret, true);
	}
	function testContact () {
		
		$contact = new Contact();
		$contact->setEmail("test@test.fr");
		$contact->setFirstName("erwantest");
		$contact->setLastName('dagorntest');

		$elt = $contact->toAdd();
		$rec = new stdclass();
		$rec->FirstName = 'erwantest';
		$rec->LastName = 'dagorntest';
		$rec->Email = 'test@test.fr';
		
		$this->assertIdentical($rec->FirstName , "erwantest");
		$this->assertIdentical($rec->LastName, "dagorntest");
		$this->assertIdentical($rec->Email, "test@test.fr");
		
		
	}
	
	function testAddContact () {
		/* Creation du contact */
		$contact = new Contact();
		$contact->setEmail("test@test.fr");
		$contact->setFirstName("erwantest");
		$contact->setLastName('dagorntest');
		$ret = $this->sales->add($contact);
		echo '<pre> testAddContact <br>/';
		print_r($contact);
		echo '<br/> retour :'.$ret;
		$this->assertIdentical($ret, true);
		$this->assertIdentical(($contact->getId() != ""), true);
		/* Modification  du contact */
		$contact->setFirstName("erwantestModif");
		$ret = $this->sales->update($contact);
		
		$this->assertIdentical($ret, true);
		/* Suppression du contact */
		$ret = $this->sales->delete($contact->getId());
		$this->assertIdentical($ret, true);
		
	}
	
	
	
	
	
	
	
	
	
	
}
?>