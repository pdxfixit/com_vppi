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

class VppiModelPhotoManage extends JModelAdmin {

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
    public function getTable($type = 'PhotoManage', $prefix = 'VppiTable', $config = array()) {
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

    public function getPoster() {
        $poster = array();
        $poster['slide'] = '';
        $poster['thumb'] = '';
        $item = $this->getItem();
        if (JFile::exists(JPATH_SITE . '/images/homes/' . (int)$item->id . '/poster.jpg')) {
            $poster['slide'] = 'poster.jpg';
        }
        if (JFile::exists(JPATH_SITE . '/images/homes/' . (int)$item->id . '/poster-thumb.jpg')) {
            $poster['thumb'] = 'poster-thumb.jpg';
        }

        return $poster;
    }

    public function getPhotos() {
        $photos = array();
        $slide = array();
        $thumb = array();
        $poster = $this->getPoster();
        $item = $this->getItem();
        if (!empty($poster['slide']) || !empty($poster['thumb'])) {
            $filePhotos = JFolder::files(JPATH_SITE . '/images/homes/' . (int)$item->id . '/');
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

}

