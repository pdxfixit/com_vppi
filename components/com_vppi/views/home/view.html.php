<?php
/**
 * @version     1.0.0
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

// No direct access
defined('_JEXEC') or die;

class VppiViewHome extends JViewLegacy {

    protected $item;

    function display($tpl = null)
    {
        $this->state    = $this->get('State');
        $this->item		= $this->get('Item');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        parent::display($tpl);
    }

}
