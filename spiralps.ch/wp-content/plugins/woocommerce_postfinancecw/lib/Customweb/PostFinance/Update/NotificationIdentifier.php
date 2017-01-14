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

/**
 * Implementation of the Customweb_Payment_Update_INotificationIdentifier
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_PostFinance_Update_NotificationIdentifier implements Customweb_Payment_Update_INotificationIdentifier {
	
	
	public function identifyNotification(array $parameters){
		
		// We support currently only pull and not push. Hence it is always an authorization request:
		return Customweb_Payment_Update_INotificationIdentifier::NOTIFICATION_TYPE_AUTHORIZATION;
	}
	
	
	
}