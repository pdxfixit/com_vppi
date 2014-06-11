<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

class VppiModelHome extends JModelAdmin {

    /**
     * @var        string    The prefix to use with controller messages.
     * @since    1.6
     */
    protected $text_prefix = 'COM_VPPI';

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param    type      The table type to instantiate
     * @param    string    A prefix for the table class name. Optional.
     * @param    array     Configuration array for model. Optional.
     *
     * @return    JTable    A database object
     * @since    1.6
     */
    public function getTable($type = 'Home', $prefix = 'VppiTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param    array   $data     An optional array of data for the form to interrogate.
     * @param    boolean $loadData True if the form is to load its own data (default case), false if not.
     *
     * @return    JForm    A JForm object on success, false on failure
     * @since    1.6
     */
    public function getForm($data = array(), $loadData = true) {
        // Initialise variables.
        $app = JFactory::getApplication();

        // Get the form.
        $form = $this->loadForm('com_vppi.home', 'home', array('control' => 'jform', 'load_data' => $loadData));

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     * @return    mixed    The data for the form.
     * @since    1.6
     */
    protected function loadFormData() {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_vppi.edit.home.data', array());

        if (empty($data)) {
            $data = $this->getItem();

        }

        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param    integer    The id of the primary key.
     *
     * @return    mixed    Object on success, false on failure.
     * @since    1.6
     */
    public function getItem($pk = null) {
        $item = parent::getItem($pk);

        return $item;
    }

    /**
     * Prepare and sanitise the table prior to saving.
     * @since    1.6
     */
    protected function prepareTable(&$table) {
        if (empty($table->id)) {
            // Set the values

            // Set ordering to the last item if not set
            if (empty($table->ordering)) {
                $db = JFactory::getDbo();
                $db->setQuery('SELECT MAX(ordering) FROM #__vppi_homes');
                $max = $db->loadResult();

                $table->ordering = $max + 1;
            }
        }
    }

    /**
     * Method to get the script that have to be included on the form
     * @return string       Script files
     */
    public function getScript() {
        return 'administrator/components/com_vppi/models/forms/home.js';
    }

    /**
     * Method to toggle the featured setting of homes.
     *
     * @param   array   $pks   The ids of the items to toggle.
     * @param   integer $value The value to toggle to.
     *
     * @return  boolean  True on success.
     * @since   1.6
     */
    public function featured($pks, $value = 0) {
        // Sanitize the ids.
        $pks = (array)$pks;
        JArrayHelper::toInteger($pks);

        if (empty($pks)) {
            throw new Exception(JText::_('COM_VPPI_NO_ITEM_SELECTED'));
        }

        $table = $this->getTable();

        try {
            $db = $this->getDbo();

            $query = $db->getQuery(true);
            $query->update('#__vppi_homes')->set('featured = ' . (int)$value)->where('id IN (' . implode(',', $pks) . ')');
            $db->setQuery($query);

            $db->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        $table->reorder();

        // Clean component's cache
        $this->cleanCache();

        return true;
    }

    /**
     * Method to save the form data.
     *
     * @param   array $data The form data.
     *
     * @return  boolean  True on success, False on error.
     * @since   12.2
     */
    public function save($data) {
        $dispatcher = JEventDispatcher::getInstance();
        $table = $this->getTable();

        $key = $table->getKeyName();
        $pk = (!empty($data[$key])) ? $data[$key] : (int)$this->getState($this->getName() . '.id');
        $isNew = true;

        // Include the content plugins for the on save events.
        JPluginHelper::importPlugin('content');

        // Allow an exception to be thrown.
        try {
            // Load the row if saving an existing record.
            if ($pk > 0) {
                $table->load($pk);
                // check if ordering was changed
                if ($table->ordering != $data['ordering']) {
                    $oldOrder = $table->ordering;
                    $newOrder = $data['ordering'];
                }
                $isNew = false;
            }

            // create alias if needed
            if (empty($data['alias'])) {
                $data['alias'] = JFilterOutput::stringURLSafe($data['name']);
            }

            // Bind the data.
            if (!$table->bind($data)) {
                throw new Exception('There was an error with the data');
            }

            // Reorder home items
            if (!empty($oldOrder) && !empty($newOrder)) {
                try {
                    $db = $this->getDbo();

                    if ($oldOrder < $newOrder) {
                        $newValue = $oldOrder;
                        $oldValue = $oldOrder + 1;
                        for ($i = $oldValue; $i <= $newOrder; $i++) {
                            $query = $db->getQuery(true);
                            $query->update('#__vppi_homes')->set('ordering = ' . (int)$newValue)->where('ordering = ' . (int)$oldValue);
                            $db->setQuery($query);
                            $db->execute();
                            $newValue++;
                            $oldValue++;
                        }
                    } else {
                        $newValue = $newOrder + 1;
                        $oldValue = $newOrder;
                        for ($i = $oldValue; $i <= $oldOrder - 1; $i++) {
                            $query = $db->getQuery(true);
                            $query->update('#__vppi_homes')->set('ordering = ' . (int)$newValue)->where('ordering = ' . (int)$oldValue);
                            $db->setQuery($query);
                            $db->execute();
                            $newValue++;
                            $oldValue++;
                        }
                    }
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            }

            // Prepare the row for saving
            $this->prepareTable($table);

            // Check the data.
            if (!$table->check()) {
                throw new Exception('There was an error with the data');
            }

            // Trigger the onContentBeforeSave event.
            $result = $dispatcher->trigger($this->event_before_save, array($this->option . '.' . $this->name, $table, $isNew));

            if (in_array(false, $result, true)) {
                throw new Exception('There was an error with the data');
            }

            // Store the data.
            if (!$table->store()) {
                throw new Exception('There was an error storing the data');
            }

            // Clean the cache.
            $this->cleanCache();

            // Trigger the onContentAfterSave event.
            $dispatcher->trigger($this->event_after_save, array($this->option . '.' . $this->name, $table, $isNew));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        $pkName = $table->getKeyName();

        if (isset($table->$pkName)) {
            $this->setState($this->getName() . '.id', $table->$pkName);
        }
        $this->setState($this->getName() . '.new', $isNew);

        return true;
    }

}

