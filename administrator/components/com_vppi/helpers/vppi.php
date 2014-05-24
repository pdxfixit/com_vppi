<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

// No direct access
defined('_JEXEC') or die;

class VppiHelper {

    /**
     * Configure the Linkbar.
     *
     * @param    string    The name of the active view.
     *
     * @since    1.6
     */
    public static function addSubmenu($vName = '') {
        JSubMenuHelper::addEntry(
                      JText::_('COM_VPPI_SUBMENU_HOMES'),
                      'index.php?option=com_vppi&view=homes',
                      $vName == 'homes'
        );
        JSubMenuHelper::addEntry(
                    JText::_('COM_VPPI_SUBMENU_HOME_IMAGES'),
                    'index.php?option=com_vppi&view=photos',
                    $vName == 'photos'
        );
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @param    int        The category ID.
     *
     * @return    JObject
     * @since    1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_vppi';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }
}
