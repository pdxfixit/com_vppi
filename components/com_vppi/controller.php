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

class VppiController extends JController {

    public function display($cachable = false, $urlparams = false) {
        $input = JFactory::getApplication()->input;
        $view = $input->getCmd('view', 'reports');
        $input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this; // return self to allow method chaining
    }
}
