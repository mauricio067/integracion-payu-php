<?php

/**
 * Manages all PayU recurring bill item operations 
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 22/12/2013
 *
 */
class PayURecurringBillItem{
	
	/**
	 * Creates a recurring bill item 
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function create($parameters, $lang = null){
		
		$required = array(
				PayUParameters::SUBSCRIPTION_ID,
				PayUParameters::DESCRIPTION,
				PayUParameters::ITEM_VALUE,
				PayUParameters::CURRENCY
		);
		
		CommonRequestUtil::validateParameters($parameters,$required);
		$request = PayUSubscriptionsRequestUtil::buildRecurringBillItem($parameters);
		$urlSegment = PayUSubscriptionsUrlResolver::getInstance()->getUrlSegment(PayUSubscriptionsUrlResolver::RECURRING_BILL_ITEM_ENTITY, 
																				 PayUSubscriptionsUrlResolver::ADD_OPERATION,
																				 array($parameters[PayUParameters::SUBSCRIPTION_ID]));
		
		$payUHttpRequestInfo = PayUSubscriptionsRequestUtil::buildHttpRequestInfo($urlSegment, $lang, RequestMethod::POST);
		
		return PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
	}
	
	/**
	 * Finds recurring bill items by id, subscription or description
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function find($parameters, $lang = null){
		$recurringBillItemId = CommonRequestUtil::getParameter($parameters, PayUParameters::RECURRING_BILL_ITEM_ID);
		$subscriptionId = CommonRequestUtil::getParameter($parameters, PayUParameters::SUBSCRIPTION_ID);
		$description = CommonRequestUtil::getParameter($parameters, PayUParameters::DESCRIPTION);
		
		
		if(isset($recurringBillItemId)){
			$invalid = array(PayUParameters::DESCRIPTION,PayUParameters::SUBSCRIPTION_ID);
			CommonRequestUtil::validateParameters($parameters,NULL, $invalid);
			$urlSegment = PayUSubscriptionsUrlResolver::getInstance()->getUrlSegment(PayUSubscriptionsUrlResolver::RECURRING_BILL_ITEM_ENTITY,
																					PayUSubscriptionsUrlResolver::GET_OPERATION,
																					array($recurringBillItemId));
			
			$payUHttpRequestInfo = PayUSubscriptionsRequestUtil::buildHttpRequestInfo($urlSegment, $lang, RequestMethod::GET);
			return PayUApiServiceUtil::sendRequest(NULL, $payUHttpRequestInfo);
		}else if(isset($subscriptionId) || isset($description)){
			$webParams = '?';
			$webParams .= isset($subscriptionId) ? 'subscriptionId=' . urlencode($subscriptionId) . '&':'';		
			$webParams .= isset($description) ? 'description=' . urlencode($description):'';
			
			$urlSegment = PayUSubscriptionsUrlResolver::getInstance()->getUrlSegment(PayUSubscriptionsUrlResolver::RECURRING_BILL_ITEM_ENTITY,
					PayUSubscriptionsUrlResolver::QUERY_OPERATION,
					array($webParams));
				
			$payUHttpRequestInfo = PayUSubscriptionsRequestUtil::buildHttpRequestInfo($urlSegment, $lang, RequestMethod::GET);
			return PayUApiServiceUtil::sendRequest(NULL, $payUHttpRequestInfo);
		}else{
			throw new InvalidArgumentException('You must send ' . PayUParameters::RECURRING_BILL_ITEM_ID 
												. 'or ' .  PayUParameters::SUBSCRIPTION_ID
												. 'or ' . PayUParameters::DESCRIPTION . 'parameter');
		}
		
	}
	
	/**
	 * Updates a recurring bill item
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function update($parameters, $lang = null){
		$required = array(PayUParameters::RECURRING_BILL_ITEM_ID);
		
		CommonRequestUtil::validateParameters($parameters, $required);
		
		$recurrinbBillItem = PayUSubscriptionsRequestUtil::buildRecurringBillItem($parameters);
		$urlSegment = PayUSubscriptionsUrlResolver::getInstance()->getUrlSegment(PayUSubscriptionsUrlResolver::RECURRING_BILL_ITEM_ENTITY,
				PayUSubscriptionsUrlResolver::EDIT_OPERATION,
				array($recurrinbBillItem->id));
		$payUHttpRequestInfo = PayUSubscriptionsRequestUtil::buildHttpRequestInfo($urlSegment, $lang, RequestMethod::PUT);
		return PayUApiServiceUtil::sendRequest($recurrinbBillItem, $payUHttpRequestInfo);
	}
	
	/**
	 * Deletes a recurring bill item
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function delete($parameters, $lang = null){
		$required = array(PayUParameters::RECURRING_BILL_ITEM_ID);
		CommonRequestUtil::validateParameters($parameters, $required);
		
		$recurrinbBillItem = PayUSubscriptionsRequestUtil::buildRecurringBillItem($parameters);
		
		$urlSegment = PayUSubscriptionsUrlResolver::getInstance()->getUrlSegment(PayUSubscriptionsUrlResolver::RECURRING_BILL_ITEM_ENTITY,
											PayUSubscriptionsUrlResolver::DELETE_OPERATION,
											array($recurrinbBillItem->id));
		$payUHttpRequestInfo = PayUSubscriptionsRequestUtil::buildHttpRequestInfo($urlSegment, $lang, RequestMethod::DELETE);
		return PayUApiServiceUtil::sendRequest(NULL, $payUHttpRequestInfo);
	}
	
	
}