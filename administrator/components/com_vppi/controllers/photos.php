<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

// No direct access.
defined('_JEXEC') or die;

require_once __DIR__ . '/homes.php';

/**
 * VPPI list controller class.
 * @package        Joomla.Administrator
 * @subpackage     com_vppi
 * @since          1.6
 */
class VppiControllerPhotos extends VppiControllerHomes {

    /**
     * Proxy for getModel.
     * @since    1.6
     */
    public function getModel($name = 'Home', $prefix = 'VppiModel', $config = array('ignore_request' => true)) {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }
}
