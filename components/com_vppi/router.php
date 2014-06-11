<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

defined('_JEXEC') or die;

/**
 * Build the route for the com_vppi component
 *
 * @param   array  &$query  An array of URL arguments
 *
 * @return  array  The URL arguments to use to assemble the subsequent URL.
 */
function VppiBuildRoute(&$query)
{
	$segments = array();

	// get a menu item based on Itemid or currently active
	$app = JFactory::getApplication();
	$menu = $app->getMenu();

	if (empty($query['Itemid'])) {
		$menuItem = $menu->getActive();
	} else {
		$menuItem = $menu->getItem($query['Itemid']);
	}

	if (isset($query['view'])) {
		if (empty($query['Itemid']) || empty($menuItem) || $menuItem->component != 'com_vppi' || $query['view'] == 'home') {
			$segments[] = $query['view'];
		}
		unset($query['view']);
	}

    if (isset($query['id'])) {
        $parts = explode(':', $query['id']);
        if (count($parts) > 1) {
            $segments[] = $parts[0];
            $segments[] = $parts[1];
        } else {
            $segments[] = $parts[0];
        }
        unset($query['id']);
    }

	if (isset($query['layout'])) {
        unset($query['layout']);
	}

	return $segments;
}

/**
 * Parse the segments of a URL.
 *
 * @param   array  $segments  The segments of the URL to parse.
 *
 * @return  array  The URL attributes to be used by the application.
 */
function VppiParseRoute($segments)
{
	$vars = array();

	//Get the active menu item.
	$app = JFactory::getApplication();
	$menu = $app->getMenu();
	$item = $menu->getActive();
	$params = JComponentHelper::getParams('com_vppi');
	$advanced = $params->get('sef_advanced_link', 0);

	// Count route segments
	$count = count($segments);

    $vars['view'] = $segments[0];
    $vars['id'] = $segments[1];

    // TODO: add advanced functionality
    /*$slug = str_replace(':', '-', $segments[2]);

    if (!empty($slug)) {
        try {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                        ->select($db->quoteName('id'))
                        ->from('#__vppi_homes')
                        ->where($db->quoteName('id') . ' = ' . (int) $vars['id'])
                        ->where($db->quoteName('alias') . ' = ' . $db->quote($slug) . ' OR ' . $db->quoteName('ml_number') . ' = ' . $db->quote($slug));
            $db->setQuery($query);
            $id = $db->loadResult();
            $vars['id'] = $id;
        } catch (Exception $e) {
            throw new Exception ($e->getMessage());
        }
    }*/

	return $vars;
}
