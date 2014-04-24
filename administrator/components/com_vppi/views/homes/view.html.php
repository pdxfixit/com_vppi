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
 * View a list of available homes.
 */
class VppiViewHomes extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null)
    {
        $this->state		= $this->get('State');
        $this->items		= $this->get('Items');
        $this->pagination	= $this->get('Pagination');

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
     *
     * @since	1.6
     */
    protected function addToolbar()
    {
        require_once JPATH_COMPONENT.'/helpers/vppi.php';

        $state	= $this->get('State');
        $canDo	= VppiHelper::getActions($state->get('filter.category_id'));
        $user	= JFactory::getUser();

        JToolBarHelper::title(JText::_('COM_VPPI_MANAGER_VPPI'), '48.png');
        if (count($user->getAuthorisedCategories('com_vppi', 'core.create')) > 0) {
            JToolBarHelper::addNew('home.add');
        }
        if ($canDo->get('core.edit')) {
            JToolBarHelper::editList('home.edit');
        }
        if ($canDo->get('core.edit.state')) {

            JToolBarHelper::divider();
            JToolBarHelper::publish('vppi.publish', 'JTOOLBAR_PUBLISH', true);
            JToolBarHelper::unpublish('vppi.unpublish', 'JTOOLBAR_UNPUBLISH', true);


            JToolBarHelper::divider();
            JToolBarHelper::archiveList('vppi.archive');
            JToolBarHelper::checkin('vppi.checkin');
        }
        if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
            JToolBarHelper::deleteList('', 'vppi.delete', 'JTOOLBAR_EMPTY_TRASH');
            JToolBarHelper::divider();
        } elseif ($canDo->get('core.edit.state')) {
            JToolBarHelper::trash('vppi.trash');
            JToolBarHelper::divider();
        }
        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_vppi');
            JToolBarHelper::divider();
        }

        JToolBarHelper::help('JHELP_COMPONENTS_VPPI_HOMES');
    }

}