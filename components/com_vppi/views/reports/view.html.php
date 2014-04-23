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

/**
 * View a list of available reports.
 */
class VppiViewReports extends JViewLegacy {

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::root() . 'media/com_vppi/css/vppi.css');

        JToolBarHelper::title(JText::_('COM_VPPI'), 'vppi');

        return parent::display($tpl);
    }

}
