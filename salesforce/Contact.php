<?php

Class Contact {
	private $_Id;
	private $_lastname;
	private $_firstname;
	private $_phone;
	private $_email;
	
	function Contact () {
		
	}
	
	
	
	/**
	* @param String $Id
	* @return Contact
	*/
	public function setId($Id)
	{
	    $this->_Id = $Id;
	    return $this;
	}
	 
	/**
	* @return String
	*/
	public function getId()
	{
	    return $this->_Id;
	}
	/**
	* @param String $Firstname
	* @return Contact
	*/
	public function setFirstName($firstname)
	{
	    $this->_firstname = $firstname;
	    return $this;
	}
	 
	/**
	* @return String
	*/
	public function getFirstName()
	{
	    return $this->_firstname;
	}
	/**
	* @param String $Lastname
	* @return Contact
	*/
	public function setLastName($lastname)
	{
	    $this->_lastname = $lastname;
	    return $this;
	}
	 
	/**
	* @return String
	*/
	public function getLastName()
	{
	    return $this->_lastname;
	}
	
	/**
	* @param String $phone
	* @return Contact
	*/
	public function setPhone($phone)
	{
	    $this->_phone = $phone;
	    return $this;
	}
	 
	/**
	* @return String
	*/
	public function getPhone()
	{
	    return $this->_phone;
	}
	/**
	* @param String $email
	* @return Contact
	*/
	public function setEmail($email)
	{
	    $this->_email = $email;
	    return $this;
	}
	 
	/**
	* @return String
	*/
	public function getEmail()
	{
	    return $this->_email;
	}
	
	function toAdd() {
		$contact = new stdclass();
		
		if ($this->getEmail() != "")
		    $contact->Email = $this->getEmail();
		
		
		if ($this->getFirstName() != "")
		$contact->FirstName = $this->getFirstName();
		
		if ($this->getLastName() != "")
		$contact->LastName = $this->getLastName();
		
		if ($this->getPhone() != "")
		$contact->Phone = $this->getPhone();
		
		if ($this->getId() != "")
		$contact->Id = $this->getId();
		
		return $contact;
	}
	
	
}