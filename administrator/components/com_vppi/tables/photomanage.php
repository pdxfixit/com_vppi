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
 * home Table class
 */
class VppiTablePhotoManage extends JTable {

    /**
     * Constructor
     *
     * @param JDatabase A database connector object
     */
    public function __construct(&$db) {
        parent::__construct('#__vppi_home', 'id', $db);
    }

    /**
     * Overloaded bind function to pre-process the params.
     *
     * @param    array        Named array
     *
     * @return    null|string    null is operation was satisfactory, otherwise returns an error
     * @see        JTable:bind
     * @since      1.5
     */
    public function bind($array, $ignore = '') {
        if (isset($array['params']) && is_array($array['params'])) {
            $registry = new JRegistry();
            $registry->loadArray($array['params']);
            $array['params'] = (string)$registry;
        }

        if (isset($array['metadata']) && is_array($array['metadata'])) {
            $registry = new JRegistry();
            $registry->loadArray($array['metadata']);
            $array['metadata'] = (string)$registry;
        }

        return parent::bind($array, $ignore);
    }

    /**
     * Overload the store method for the Homes table.
     *
     * @param    boolean    Toggle whether null values should be updated.
     *
     * @return    boolean    True on success, false on failure.
     * @since    1.6
     */
    public function store($updateNulls = false) {
        $date = JFactory::getDate();
        $user = JFactory::getUser();
        if ($this->id) {
            // Existing item
            $this->modified = $date->toSql();
            $this->modified_by = $user->get('id');
        } else {
            if (!intval($this->created)) {
                $this->created = $date->toSql();
            }
            if (empty($this->created_by)) {
                $this->created_by = $user->get('id');
            }
        }

        // Attempt to store the user data.
        return parent::store($updateNulls);
    }

    /**
     * Overloaded check function
     */
    public function check() {

        //If there is an ordering column and this is a new row then get the next ordering value
        if (property_exists($this, 'ordering') && $this->id == 0) {
            $this->ordering = self::getNextOrder();
        }

        return parent::check();
    }

    /**
     * Method to set the publishing state for a row or list of rows in the database
     * table.  The method respects checked out rows by other users and will attempt
     * to checkin rows that it can after adjustments are made.
     *
     * @param    mixed    An optional array of primary key values to update.  If not
     *                    set the instance property value is used.
     * @param    integer  The publishing state. eg. [0 = unpublished, 1 = published]
     * @param    integer  The user id of the user performing the operation.
     *
     * @return    boolean    True on success.
     * @since    1.0.4
     */
    public function publish($pks = null, $state = 1, $userId = 0) {
        // Initialise variables.
        $k = $this->_tbl_key;

        // Sanitize input.
        JArrayHelper::toInteger($pks);
        $userId = (int)$userId;
        $state = (int)$state;

        // If there are no primary keys set check to see if the instance key is set.
        if (empty($pks)) {
            if ($this->$k) {
                $pks = array($this->$k);
            } // Nothing to set publishing state on, return false.
            else {
                throw new Exception(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));

                return false;
            }
        }

        // Build the WHERE clause for the primary keys.
        $where = $k . '=' . implode(' OR ' . $k . '=', $pks);

        // Determine if there is checkin support for the table.
        if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time')) {
            $checkin = '';
        } else {
            $checkin = ' AND (checked_out = 0 OR checked_out = ' . (int)$userId . ')';
        }

        // Update the publishing state for rows with the given primary keys.
        $this->_db->setQuery(
                  'UPDATE `' . $this->_tbl . '`' .
                  ' SET `state` = ' . (int)$state .
                  ' WHERE (' . $where . ')' .
                  $checkin
        );

        // Check for a database error.
        try {
            $this->_db->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        // If checkin is supported and all rows were adjusted, check them in.
        if ($checkin && (count($pks) == $this->_db->getAffectedRows())) {
            // Checkin each row.
            foreach ($pks as $pk) {
                $this->checkin($pk);
            }
        }

        // If the JTable instance value is in the list of primary keys that were set, set the instance.
        if (in_array($this->$k, $pks)) {
            $this->state = $state;
        }

        return true;
    }

}
