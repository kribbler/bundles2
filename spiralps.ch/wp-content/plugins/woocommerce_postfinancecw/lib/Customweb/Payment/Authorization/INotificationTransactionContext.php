<?php 
/**
  * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2013 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.customweb.ch/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.customweb.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 */


interface Customweb_Payment_Authorization_INotificationTransactionContext {
	
	/**
	 * The URL to which a notification should be sent, when the payment is processed
	 * by the payment service provider. The implementator of the interface has to make sure that
	 * the notification URL can be called, before or after the success or error URL is called. 
	 * May be the user has to be hold on the success URL as long the notification was successfully 
	 * processed, after this the user may see the configrmation message.
	 *          	 		    			 
	 * @return String The URL on which a notification is sent.
	 */
	public function getNotificationUrl();
	
}