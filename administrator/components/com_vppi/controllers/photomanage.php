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

jimport('joomla.application.component.controllerform');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * VPPI controller class.
 * @package        Joomla.Administrator
 * @subpackage     com_vppi
 * @since          1.6
 */
class VppiControllerPhotoManage extends JControllerForm {

    /**
     * The folder we are uploading into
     * @var   string
     */
    protected $folder = '';

    /**
     * Upload one or more files
     * @return  boolean
     * @since   1.5
     */
    public function upload() {
        // Check for request forgeries
        JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));
        $params = JComponentHelper::getParams('com_vppi');

        // Get some data from the request
        $poster = $this->input->get('poster');
        if ($poster) {
            $files = array($this->input->files->get('homeImageFiles'));
        } else {
            $files = $this->input->files->get('homeImageFiles', '', 'array');

        }
        $returnId = $this->input->get('id');
        $this->folder = $this->input->get('folder', '', 'path');

        // Set the redirect
        try {
            $this->setRedirect(JUri::root() . 'administrator/index.php?option=com_vppi&view=photomanage&layout=default&id=' . $returnId);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        // Authorize the user
        require_once(JPATH_COMPONENT . '/helpers/vppi.php');
        $canDo = VppiHelper::getActions();
        if (!$canDo->get('core.create')) {
            return false;
        }

        if (($params->get('upload_maxsize', 0) * 1024 * 1024) != 0) {
            if (
                $_SERVER['CONTENT_LENGTH'] > ($params->get('upload_maxsize', 0) * 1024 * 1024)
                || $_SERVER['CONTENT_LENGTH'] > (int)(ini_get('upload_max_filesize')) * 1024 * 1024
                || $_SERVER['CONTENT_LENGTH'] > (int)(ini_get('post_max_size')) * 1024 * 1024
                || (($_SERVER['CONTENT_LENGTH'] > (int)(ini_get('memory_limit')) * 1024 * 1024) && ((int)(ini_get('memory_limit')) != -1))
            ) {
                throw new Exception(JText::_('COM_VPPI_ERROR_WARN_FILE_TOO_LARGE'));
            }
        }

        // Perform basic checks on file info before attempting anything
        foreach ($files as &$file) {
            $file['name'] = strtolower(JFile::makeSafe($file['name']));
            if ($poster) {
                $file['filepath'] = JPath::clean(JPATH_SITE . '/images/homes/' . $this->input->get('id') . '/poster.jpg');
            } else {
                $file['filepath'] = JPath::clean(JPATH_SITE . '/images/homes/' . $this->input->get('id') . '/' . $file['name']);
            }

            if ($file['error'] == 1) {
                throw new Exception(JText::_('COM_VPPI_ERROR_WARN_FILE_TOO_LARGE'));
            }

            if (($params->get('upload_maxsize', 0) * 1024 * 1024) != 0 && $file['size'] > ($params->get('upload_maxsize', 0) * 1024 * 1024)) {
                throw new Exception(JText::_('COM_VPPI_ERROR_WARN_FILE_TOO_LARGE'));
            }

            if (!isset($file['name'])) {
                // No filename (after the name was cleaned by JFile::makeSafe)
                $this->setRedirect('index.php', JText::_('COM_VPPI_NO_FILE_SELECTED'), 'error');

                return false;
            }
        }

        foreach ($files as &$file) {

            require_once(JPATH_SITE . '/libraries/cms/helper/media.php');
            if (!JHelperMedia::canUpload($file)) {
                // The file can't be uploaded
                throw new Exception('COM_VPPI_ERROR_UNABLE_TO_UPLOAD_FILE');
            }

            $format = strtolower(JFile::getExt($file['name']));
            if ($format != 'jpg') {
                throw new Exception('COM_VPPI_FILE_MUST_BE_JPG_FORMAT');
            }

            $object_file = new JObject($file);

            if (!JFile::upload($object_file->tmp_name, $object_file->filepath)) {
                // Error in upload
                throw new Exception(JText::_('COM_VPPI_ERROR_UNABLE_TO_UPLOAD_FILE'));
            } else {
                $app = JFactory::getApplication();
                $app->enqueueMessage(JText::sprintf('COM_VPPI_UPLOAD_COMPLETE', substr($object_file->filepath, strlen(JPATH_SITE))), 'message');
            }
        }

        return true;
    }

    public function delete() {
        // Check for request forgeries
        JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));

        // Set the redirect
        try {
            $this->setRedirect(JUri::root() . 'administrator/index.php?option=com_vppi&view=photomanage&layout=default&id=' . $this->input->get('id'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        // Authorize the user
        require_once(JPATH_COMPONENT . '/helpers/vppi.php');
        $canDo = VppiHelper::getActions();
        if (!$canDo->get('core.edit')) {
            return false;
        }

        $deletePhotos = $this->input->get('photo', ' ', 'array');
        if ($deletePhotos) {
            foreach ($deletePhotos as $photo) {
                JFile::delete(JPATH_SITE . '/images/homes/' . $this->input->get('id') . '/' . $photo);
            }
        }

        return true;
    }
}
