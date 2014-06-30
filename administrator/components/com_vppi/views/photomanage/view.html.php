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
class VppiViewPhotoManage extends JViewLegacy {

    protected $state;
    protected $item;
    protected $form;
    protected $poster;
    protected $photos;
    protected $homeId;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->item = $this->get('Items');
        $this->form = $this->get('Pagination');
        $this->poster = $this->get('Poster');
        $this->photos = $this->get('Photos');
        $this->homeId = $this->get('homeId');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar() {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        JToolbarHelper::title(JText::_('COM_VPPI_IMAGE_MANAGER_VPPI'), 'VPPI-logo.png');

        JToolbarHelper::back('JTOOLBAR_CLOSE', '/administrator/index.php?option=com_vppi&view=photos');
    }

    /**
     * Returns an array of fields the table can be sorted by
     * @return  array  Array containing the field name to sort by as the key and display text as value
     * @since   3.0
     */
    protected function getSortFields() {
        return array(
            'b.ordering' => JText::_('JGRID_HEADING_ORDERING'),
        );
    }
}
