<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

defined('_JEXEC') or die;

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
require_once __DIR__ . '/homes.php';

class VppiModelPhotos extends VppiModelHomes {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     *
     * @see        JController
     * @since      1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'street_address', 'a.street_address',
                'city', 'a.city',
                'state_prov', 'a.state_prov',
                'zip_code', 'a.zip_code',
                'ml_number', 'a.ml_number',
                'state', 'a.state',
                'ordering', 'a.ordering',
                'featured', 'a.featured',
            );
        }

        parent::__construct($config);
    }

    /**
     * Build an SQL query to load the list data.
     * @return    JDatabaseQuery
     * @since    1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $user = JFactory::getUser();

        // Select the required fields from the table.
        $query->select(
              $this->getState(
                   'list.select', 'a.id, a.street_address, a.city, a.state_prov, a.zip_code, a.ml_number, a.state, a.checked_out, ' .
                   'a.checked_out_time, a.ordering, a.featured, a.modified_by, a.modified, a.created_by, a.created'
              )
        );
        $query->from($db->quoteName('#__vppi_home') . ' AS a');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor');
        $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

        // Filter by published state
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('a.state = ' . (int)$published);
        } elseif ($published === '') {
            $query->where('(a.state IN (0, 1))');
        }

        // Filter by search in ml_number
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int)substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('(a.ml_number LIKE ' . $search . ')');
            }
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }
}
