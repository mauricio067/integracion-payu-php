<?php

/**
 * Manages all PayU subscriptions operations 
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 17/12/2013
 *
 */
class PayUSubscriptions{
	
	/**
	 * Creates a subscription
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function createSubscription($parameters, $lang = null){
	
		$planCode = CommonRequestUtil::getParameter($parameters, PayUParameters::PLAN_CODE);
		$tokenId = CommonRequestUtil::getParameter($parameters, PayUParameters::TOKEN_ID);
		if(!isset($planCode)){
			PayUSubscriptionsRequestUtil::validateSubscriptionPlan($parameters);
		}
		
		PayUSubscriptionsRequestUtil::validateCustomerToSubscription($parameters);
		PayUSubscriptionsRequestUtil::validateToken($parameters);
		
		
		
 		$request = PayUSubscriptionsRequestUtil::buildSubscription($parameters);
 		$urlSegment = PayUSubscriptionsUrlResolver::getInstance()->getUrlSegment(PayUSubscriptionsUrlResolver::SUBSCRIPTIONS_ENTITY, PayUSubscriptionsUrlResolver::ADD_OPERATION);
		
 		$payUHttpRequestInfo = PayUSubscriptionsRequestUtil::buildHttpRequestInfo($urlSegment, $lang, RequestMethod::POST);
		
 		return PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
	}
	
	/**
	 * Cancels a subscription
	 * @param parameters The parameters to be sent to the server
	 * @param string $lang language of request see SupportedLanguages class
	 * @return The response to the request sent
	 * @throws PayUException
	 * @throws InvalidArgumentException
	 */
	public static function cancel($parameters, $lang = null){
		$required = array(PayUParameters::SUBSCRIPTION_ID);
		CommonRequestUtil::validateParameters($parameters, $required);

		$request = PayUSubscriptionsRequestUtil::buildSubscription($parameters);
		$urlSegment = PayUSubscriptionsUrlResolver::getInstance()->getUrlSegment(PayUSubscriptionsUrlResolver::SUBSCRIPTIONS_ENTITY,
																				PayUSubscriptionsUrlResolver::DELETE_OPERATION,
																				array($parameters[PayUParameters::SUBSCRIPTION_ID]));
		
		$payUHttpRequestInfo = PayUSubscriptionsRequestUtil::buildHttpRequestInfo($urlSegment, $lang, RequestMethod::DELETE);
		
		return PayUApiServiceUtil::sendRequest($request, $payUHttpRequestInfo);
		
	}
	
	
}