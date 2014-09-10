<?php

/**
 *
 * Util class to build  the url to subscriptions api operations
 *
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0, 22/12/2013
 *
 */

class PayUSubscriptionsUrlResolver{
	
	/** constant to plan entity */
	const PLAN_ENTITY = 'Plan';
	
	/** constant to customer entity */
	const CUSTOMER_ENTITY = 'Customer';
	
	/** constant to credit card entity */
	const CREDIT_CARD_ENTITY = 'CreditCard';
	
	/** constant to subscription entity */
	const SUBSCRIPTIONS_ENTITY = 'subscription';
	
	/** constant to recurring bill item entity */
	const RECURRING_BILL_ITEM_ENTITY ='RecurringBillItem';
	
	/** constant to add operation */
	const ADD_OPERATION = "add";	
	
	/** constant to edit operation */
	const EDIT_OPERATION = "edit";
	
	/** constant to delete operation */
	const DELETE_OPERATION = "delete";
	
	/** constant to get operation */
	const GET_OPERATION = "get";
	
	/** constant to query operation */
	const QUERY_OPERATION = "query";

	/** contains the url info to each entity and operation this is built in the constructor class */
	private $urlInfo;
	
	/** instancia to singleton pattern*/
	private static $instancia;
	
	/**
	 * the constructor class
	 */
	 private function __construct()
	 {
	 	$planBaseUrl = '/plans';
	 	$planUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $planBaseUrl, 'numberParams'=> 0),
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $planBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $planBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $planBaseUrl . '/%s', 'numberParams'=> 1));
	 	
	 	$customerBaseUrl = '/customers';
	 	$customerUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $customerBaseUrl, 'numberParams'=> 0),
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $customerBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $customerBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $customerBaseUrl . '/%s', 'numberParams'=> 1));
	 	
	 	$creditCardBaseUrl = '/creditCards';
	 	$creditCardsUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $customerBaseUrl .'/%s'.$creditCardBaseUrl, 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $creditCardBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $creditCardBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $customerBaseUrl .'/%s'.$creditCardBaseUrl . '/%s/', 'numberParams'=> 2));

	 	$subscriptionsCardBaseUrl = '/subscriptions';
	 	$subscriptionsUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl, 'numberParams'=> 0),
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl . '/%s', 'numberParams'=> 1));
	 	
	 	
	 	$recurringBillItemBaseUrl = '/recurringBillItems';
	 	$recurringBillItemUrlInfo = array(
	 			PayUSubscriptionsUrlResolver::ADD_OPERATION => array('segmentPattern'=> $subscriptionsCardBaseUrl .'/%s'.$recurringBillItemBaseUrl, 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::GET_OPERATION => array('segmentPattern'=> $recurringBillItemBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::EDIT_OPERATION => array('segmentPattern'=> $recurringBillItemBaseUrl . '/%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::QUERY_OPERATION => array('segmentPattern'=> $recurringBillItemBaseUrl . '/params%s', 'numberParams'=> 1),
	 			PayUSubscriptionsUrlResolver::DELETE_OPERATION => array('segmentPattern'=> $recurringBillItemBaseUrl . '/%s', 'numberParams'=> 1));
	 	
	 	
	 	
	 	$this->urlInfo = array( PayUSubscriptionsUrlResolver::PLAN_ENTITY => $planUrlInfo,
								PayUSubscriptionsUrlResolver::CUSTOMER_ENTITY => $customerUrlInfo,
								PayUSubscriptionsUrlResolver::CREDIT_CARD_ENTITY => $creditCardsUrlInfo,
	 							PayUSubscriptionsUrlResolver::SUBSCRIPTIONS_ENTITY => $subscriptionsUrlInfo,
	 							PayUSubscriptionsUrlResolver::RECURRING_BILL_ITEM_ENTITY => $recurringBillItemUrlInfo);
	 	
	 }
	 
	/**
	 * return a instance of this class
	 * @return PayUSubscriptionsUrlResolver
	 */
	public static function getInstance(){
		if(!self::$instancia instanceof self){
	 		self::$instancia = new self;
	 	}
	 	return self::$instancia;
	 }
	 
	 
	/**
	 * build an url segment using the entity, operation and the url params 
	 * @param string $entity
	 * @param string $operation
	 * @param string $params
	 * @throws InvalidArgumentException
	 * @return the url segment built
	 */ 
	public function getUrlSegment($entity, $operation, $params = NULL){
		
		if(!isset($this->urlInfo[$entity])){
			throw new InvalidArgumentException("the entity " . $entity. 'was not found ');
		}
		
		if(!isset($this->urlInfo[$entity][$operation])){
			throw new InvalidArgumentException("the request method " . $requestMethod. 'was not found ');
		}
		
		$numberParams = $this->urlInfo[$entity][$operation]['numberParams'];
		
		if(!isset($params) && $numberParams > 0){
			throw new InvalidArgumentException("the url needs " . $numberParams. ' parameters ');
		}
		
		if(isset($params) && count($params) != $numberParams){
			throw new InvalidArgumentException("the url needs " . $numberParams. ' parameters  but ' . count($params) . 'was received');
		}
		
		if(!is_array($params)){
			$params = array($params);
		}
		
		return vsprintf($this->urlInfo[$entity][$operation]['segmentPattern'],$params);
		
	}
	
	
	
	
}