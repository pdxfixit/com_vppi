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
 * @param   array &$query An array of URL arguments
 *
 * @return  array  The URL arguments to use to assemble the subsequent URL.
 */
function VppiBuildRoute(&$query) {
    $segments = array();

    // get a menu item based on Itemid or currently active
    $app = JFactory::getApplication();
    $menu = $app->getMenu();

    // get any id
    if (!isset($query['Itemid'])) {
        $menuItem = $menu->getItems('component', 'com_vppi', true);
        if (isset($menuItem->id)) {
            $query['Itemid'] = $menuItem->id;
        }
    }

    $db = JFactory::getDbo();
    if (array_key_exists('view', $query)) {
        $activeMenu = $menu->getActive()->id;
        $defaultMenu = $menu->getDefault('*')->id;
        if ($activeMenu == $defaultMenu) {
            $segments[] = $query['view'];
        }

        if (array_key_exists('id', $query)) {
            $sql = $db->getQuery(true);
            $sql->select($db->quoteName('alias'))->from($db->quoteName('#__vppi_homes'))->where($db->quoteName('id') . ' = ' . $db->quote((int)$query['id']));

            $db->setQuery($sql);
            $address = $db->loadResult();
            if (isset($address)) {
                $segments[] = $address;
            } else {
                $segments[] = $query['id'];
            }
            unset($query['id']);
        }

        unset($query['view']);
    }

    return $segments;
}

/**
 * Parse the segments of a URL.
 *
 * @param   array $segments The segments of the URL to parse.
 *
 * @return  array  The URL attributes to be used by the application.
 */
function VppiParseRoute($segments) {
    $db = JFactory::getDbo();
    $vars = array();

    $count = count($segments);
    if (isset($segments[0])) {
        if ($count < 2) {
            $vars['view'] = 'home';
        } else {
            $vars['view'] = $segments[0];
        }
        $i = $count - 1;

        if (isset($segments[$i])) {
            if (is_numeric($segments[$i])) {
                if (preg_match('/^\d{6,8}$/', $segments[$i])) {
                    $query = $db->getQuery(true);
                    $query->select($db->quoteName('id'))->from($db->quoteName('#__vppi_homes'))->where($db->quoteName('ml_number') . ' = ' . $db->quote((int)$segments[$i]));

                    $db->setQuery($query);
                    $id = $db->loadResult();
                    if (isset($id)) {
                        $vars['id'] = $id;
                    }
                } else {
                    $vars['id'] = (int)$segments[$i];
                }
            } else {
                $alias = JFilterOutput::stringURLSafe($segments[$i]);
                $query = $db->getQuery(true);
                $query->select($db->quoteName('id'))->from($db->quoteName('#__vppi_homes'))->where($db->quoteName('alias') . ' = ' . $db->quote($alias));

                $db->setQuery($query);
                $id = $db->loadResult();
                if (isset($id)) {
                    $vars['id'] = $id;
                }
            }
        }
    }

    return $vars;
}
