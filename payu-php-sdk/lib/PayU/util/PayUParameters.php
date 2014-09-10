<?php

/**
 *
 * Contains the parameters names 
 * used in the differents methods
 * 
 * @author PayU Latam
 * @since 1.0.0
 * @version 1.0.0, 17/10/2013
 * 
 */
class PayUParameters {

	/** The payment method's country. */
	const COUNTRY = 'country';
	/** The order's id. */
	const ORDER_ID = 'orderId';
	/** El order's reference code. */
	const REFERENCE_CODE = 'referenceCode';
	/** The order's or payment method's description. */
	const DESCRIPTION = 'description';
	/** The account's id. */
	const ACCOUNT_ID = 'accountId';
	/** The ISO code for the currency to use. */
	const CURRENCY = 'currency';
	/** The value of the purchase. */
	const VALUE = 'value';
	/** The tax value. */
	const TAX_VALUE = 'taxValue';
	/** The tax return base. */
	const TAX_RETURN_BASE = 'taxDevolutionBase';
	/** The tranaction signature. */
	const SIGNATURE = 'signature';
	/** the transaction id */
	const TRANSACTION_ID = 'transactionId';
	/** The credit card token id. */
	const TOKEN_ID = 'creditCardTokenId';
	/** the batch token id. */
	const BATCH_TOKEN_ID = 'batchTokenId';
	/** The payment method to use. */
	const PAYMENT_METHOD = 'paymentMethod';
	

	/** The number of installments on the purchase. */
	const INSTALLMENTS_NUMBER = 'installmentsNumber';
	/** The number on the credit card. */
	const CREDIT_CARD_NUMBER = 'creditCardNumber';
	/** The credit card's expiration date. */
	const CREDIT_CARD_EXPIRATION_DATE = 'creditCardExpirationDate';
	/** The credit card's security code. */
	const CREDIT_CARD_SECURITY_CODE = 'creditCardSecurityCode';
	/** The credit card's document. */
	const CREDIT_CARD_DOCUMENT = 'creditCardDocument';

	/** The payer's name */
	const PAYER_NAME = 'payerName';
	/** The payer's id on the merchant. */
	const PAYER_ID = 'payerId';
	/** The payer's contact e-mail. */
	const PAYER_EMAIL = 'payerEmail';
	/** The payer's CNPJ. */	
	const PAYER_CNPJ = 'payerCNPJ';
	/** The payer's contact phone. */	
	const PAYER_CONTACT_PHONE = 'payerContactPhone';
	/** The payer's DNI. */	
	const PAYER_DNI = 'payerDNI';

	
	/** The payer's city. */
	const PAYER_CITY = 'payerCity';
	/** The payer's country. */
	const PAYER_COUNTRY = 'payerCountry';
	/** The payer's phone. */	
	const PAYER_PHONE = 'payerPhone';
	/** The payer's postal code. */	
	const PAYER_POSTAL_CODE = 'payerPostalCode';
	/** The payer's state. */
	const PAYER_STATE = 'payerState';
	/** The payer's address (part 1). */
	const PAYER_STREET = 'payerStreet';
	/** The payer's address (part 2). */
	const PAYER_STREET_2 = 'payerStreet2';
	/** The payer's address (part 3). */
	const PAYER_STREET_3 = 'payerStreet3';
	
	
	const PAYER_IP_ADDRESS = 'PAYER_IP_ADDRESS';

	const PAYER_COOKIE = 'PAYER_COOKIE';	

	/** Start date to filter. */
	const START_DATE = 'startDate';
	/** Last date to filter. */
	const END_DATE = 'endDate';

	/** The credit card's expiration date. */
	const EXPIRATION_DATE = 'expirationDate';

	/** The customer's name. */
	const CUSTOMER_NAME = 'customerName';
	/** The customer's id on the merchant. */
	const CUSTOMER_ID = 'customerId';
	/** The customer's contact e-mail. */
	const CUSTOMER_EMAIL = 'customerEmail';
	
	

	/** The plan id. */
	const PLAN_ID = 'planId';
	/** The plan code. */
	const PLAN_CODE = 'planCode';
	/** The plan description. */
	const PLAN_DESCRIPTION = 'planDescription';
	/** The plan interval. */
	const PLAN_INTERVAL = 'planInterval';
	/** The plan interval count. */
	const PLAN_INTERVAL_COUNT = 'planIntervalCount';
	/** The number of trial days of the plan. */
	const PLAN_TRIAL_PERIOD_DAYS = 'planTrialPeriodDays';
	/** The currency to use on the plan. */
	const PLAN_CURRENCY = 'planCurrency';
	/** The plan value. */
	const PLAN_VALUE = 'planValue';
	/** The plan tax. */
	const PLAN_TAX = 'planTax';
	/** The plan tax return base. */
	const PLAN_TAX_RETURN_BASE = 'planTaxReturnBase';
	/** The plan maximum number of payments. */
	const PLAN_MAX_PAYMENTS = 'maxPaymentsAllowed';
	/** The plan attempts delay. */
	const PLAN_ATTEMPS_DELAY = 'paymentAttempsDelay';
	
	/** The plan max payments attempts delay. */
	const PLAN_MAX_PAYMENT_ATTEMPTS = 'maxPaymentAttempts';
	/** The plan max pending payments. */
	const PLAN_MAX_PENDING_PAYMENTS = 'maxPendingPayments';
	

	/** The subscription id. */
	const SUBSCRIPTION_ID = 'subscriptionId';

	/** The number of trial days. */
	const TRIAL_DAYS = 'trialDays';
	/** The quantity to purchase. */
	const QUANTITY = 'quantity';

	/** The recurring bill item id. */
	const RECURRING_BILL_ITEM_ID = 'recurringBillItemId';
	/** The item value. */
	const ITEM_VALUE = 'itemValue';
	/** The tax to apply over the item. */
	const ITEM_TAX = 'itemTax';
	/** The item tax return base. */
	const ITEM_TAX_RETURN_BASE = 'itemTaxReturnBase';
	
	/**	Whether a transaction must process the cvv2 field */
	const PROCESS_WITHOUT_CVV2 = 'processWithoutCvv2';
}