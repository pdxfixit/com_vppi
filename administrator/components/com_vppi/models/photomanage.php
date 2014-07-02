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
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class VppiModelPhotoManage extends JModelList {

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
                'id', 'b.id',
                'home_id', 'b.home_id',
                'name', 'b.name',
                'ordering', 'b.ordering',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     * Note. Calling getState in this method will result in recursion.
     * @since    1.6
     */
    protected function populateState() {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_vppi');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('b.ordering', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param    string $id A prefix for the store id.
     *
     * @return    string        A store id.
     * @since    1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     * @return    JDatabaseQuery
     * @since    1.6
     */
    protected function getListQuery() {
        $app = JFactory::getApplication();
        $input = $app->input;
        $id = $input->get('id');

        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select($this->getState('list.select', 'b.*'))->from($db->quoteName('#__vppi_images') . ' AS b')->where($db->quoteName('home_id') . ' = ' . $id);

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getPoster() {
        $poster = array();
        $poster['slide'] = '';
        $poster['thumb'] = '';
        $app = JFactory::getApplication();
        $input = $app->input;
        $id = $input->get('id');
        if (JFile::exists(JPATH_SITE . '/images/homes/' . (int)$id . '/poster.jpg')) {
            $poster['slide'] = 'poster.jpg';
        }
        if (JFile::exists(JPATH_SITE . '/images/homes/' . (int)$id . '/poster-thumb.jpg')) {
            $poster['thumb'] = 'poster-thumb.jpg';
        }

        return $poster;
    }

    public function getPhotos() {
        $photos = array();
        $slide = array();
        $thumb = array();
        $poster = $this->getPoster();
        $app = JFactory::getApplication();
        $input = $app->input;
        $id = $input->get('id');
        if (!empty($poster['slide']) || !empty($poster['thumb'])) {
            $filePhotos = JFolder::files(JPATH_SITE . '/images/homes/' . (int)$id . '/');
            foreach ($filePhotos as $photo) {
                if (strpos($photo, '-thumb.jpg')) {
                    $thumb[] = $photo;
                } else {
                    $slide[] = $photo;
                }
            }

            $slide = array_diff($slide, array($poster['slide']));
            if (!empty($slide)) {
                $photos['slide'] = $slide;
            }

            $thumb = array_diff($thumb, array($poster['thumb']));
            if (!empty($thumb)) {
                $photos['thumb'] = $thumb;
            }

        }

        return $photos;
    }

    public function getHomeId() {
        $app = JFactory::getApplication();
        $input = $app->input;
        $id = $input->get('id');

        return $id;
    }
}

