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

/**
 * View a list of available homes.
 */
class VppiViewPhotos extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;
    protected $poster;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state        = $this->get('State');
        $this->items        = $this->get('Items');
        $this->pagination   = $this->get('Pagination');
        $this->poster       = $this->get('Poster');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->addToolbar();

        $input = JFactory::getApplication()->input;
        $view = $input->getCmd('view', '');
        VppiHelper::addSubmenu($view);

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     * @since    1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/vppi.php';

        JToolBarHelper::title(JText::_('COM_VPPI_MANAGER_VPPI'), 'VPPI-logo.png');

    }

    /**
     * Returns an array of fields the table can be sorted by
     * @return  array  Array containing the field name to sort by as the key and display text as value
     * @since   3.0
     */
    protected function getSortFields() {
        return array(
            'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
            'a.published' => JText::_('JSTATUS'),
            'a.featured' => JText::_('JFEATURED'),
            'a.ml_number' => JText::_('COM_VPPI_ML_NUMBER'),
            'a.street_address' => JText::_('COM_VPPI_STREET_ADDRESS'),
            'a.city' => JText::_('COM_VPPI_CITY'),
            'a.state_prov' => JText::_('COM_VPPI_STATE_PROV'),
            'a.id' => JText::_('JGRID_HEADING_ID')
        );
    }

}
