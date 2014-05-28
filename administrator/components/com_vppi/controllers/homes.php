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

jimport('joomla.application.component.controlleradmin');

/**
 * VPPI list controller class.
 * @package        Joomla.Administrator
 * @subpackage     com_vppi
 * @since          1.6
 */
class VppiControllerHomes extends JControllerAdmin {

    /**
     * Constructor.
     *
     * @param   array $config An optional associative array of configuration settings.
     *
     * @return  VppiControllerHomes
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array()) {
        parent::__construct($config);

        $this->registerTask('unfeatured', 'featured');
    }

    /**
     * Method to toggle the featured setting of a list of homes.
     * @return  void
     * @since   1.6
     */
    public function featured() {
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $user = JFactory::getUser();
        $ids = $this->input->get('cid', array(), 'array');
        $values = array('featured' => 1, 'unfeatured' => 0);
        $task = $this->getTask();
        $value = JArrayHelper::getValue($values, $task, 0, 'int');

        // Get the model.
        $model = $this->getModel();

        // Access checks.
        foreach ($ids as $i => $id) {
            if (!$user->authorise('core.edit.state', 'com_vppi')) {
                // Prune items that you can't change.
                unset($ids[$i]);
                throw new Exception(JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'));
            }
        }

        if (empty($ids)) {
            throw new Exception(JText::_('COM_VPPI_NO_ITEM_SELECTED'));
        } else {
            // Publish the items.
            if (!$model->featured($ids, $value)) {
                throw new Exception(JText::_('COM_VPPI_ERROR_MESSAGE'));
            }
        }

        $this->setRedirect('index.php?option=com_vppi&view=homes');
    }

    /**
     * Proxy for getModel.
     * @since    1.6
     */
    public function getModel($name = 'Home', $prefix = 'VppiModel', $config = array('ignore_request' => true)) {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }
}
