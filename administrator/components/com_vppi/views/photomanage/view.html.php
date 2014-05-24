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
    protected $script;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');

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

        require_once(JPATH_COMPONENT . '/helpers/vppi.php');
        $canDo = VppiHelper::getActions();

        JToolbarHelper::title(JText::_('COM_VPPI_IMAGE_MANAGER_VPPI'), 'VPPI-logo.png');

        // Add a delete button
        if ($canDo->get('core.delete')) {
            // Instantiate a new JLayoutFile instance and render the layout
            JToolbarHelper::deleteList('COM_VPPI_VERIFY_DELETE_IMAGES', 'photomanage.delete');

            JToolbarHelper::divider();
        }

        JToolbarHelper::cancel('photomanage.cancel', 'JTOOLBAR_CLOSE');
    }

}
