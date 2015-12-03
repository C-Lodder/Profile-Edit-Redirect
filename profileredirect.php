<?php
/**
 * @package     Redirect after Profile Edit
 *
 * @copyright   Copyright (C) 2015 Charlie Lodder, Inc. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

class PlgSystemProfileredirect extends JPlugin
{
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}

	public static function onUserAfterSave($user, $isNew, $success, $msg)
	{
		$app   = JFactory::getApplication();
		$input = $app->input;
		
		// Check is we're on the front-end and if we're editing an existing user
		if ($app->isSite() && $isNew == false)
		{
			$option = $input->get('option');
			
			// If we're on the profile edit page
			if ($option == 'com_users')
			{
				// Get the redirect parameter value
				$params   = new Registry(JPluginHelper::getPlugin('system', 'profileredirect')->params);
				$redirect = $params->get('url', 'index.php');
				
				// Get the URI from the Menu ID
				$menu = $app->getMenu();
				$item = $menu->getItem($redirect);
				
				// Redirect if the store was successful
				if ($success == true)
				{
					$app->redirect(JRoute::_($item->link));
				}
			}

		}
	}
}
