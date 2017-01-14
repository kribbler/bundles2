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


interface Customweb_Payment_Update_INotificationIdentifier{

	const NOTIFICATION_TYPE_UPDATE = 'type-update';
	const NOTIFICATION_TYPE_AUTHORIZATION = 'type-authorization';

	/**
	 * This method identifies the type of incoming notification requests.
	 *
	 * @param array $parameters
	 * @return string NOTIFICATION_TYPE_UPDATE | NOTIFICATION_TYPE_AUTHORIZATION
	 */
	public function identifyNotification(array $parameters);
}