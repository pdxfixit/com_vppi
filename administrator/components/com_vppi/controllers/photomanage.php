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

        $uploadCount = 0;
        $thumbUploadCount = 0;
        foreach ($files as &$file) {

            require_once(JPATH_SITE . '/libraries/cms/helper/media.php');
            if (!JHelperMedia::canUpload($file)) {
                // The file can't be uploaded
                throw new Exception(JText::_('COM_VPPI_ERROR_UNABLE_TO_UPLOAD_FILE'));
            }

            $format = strtolower(JFile::getExt($file['name']));
            if ($format != 'jpg') {
                throw new Exception(JText::_('COM_VPPI_FILE_MUST_BE_JPG_FORMAT'));
            }

            // resize upload photo
            $destWidth = 910;
            $destHeight = 500;
            $sourceImage = imagecreatefromjpeg($file['tmp_name']);
            $sourceWidth = imagesx($sourceImage);
            $sourceHeight = imagesy($sourceImage);
            $ratio = $sourceHeight / $sourceWidth;
            if ($ratio != 0) {
                if ($ratio <= ($destHeight / $destWidth)) {
                    $newSourceWidth = ($sourceHeight * $destWidth) / $destHeight;
                    $sourceX = (int)(($sourceWidth - $newSourceWidth) / 2);
                    $sourceY = 0;
                    $sourceWidth = (int)$newSourceWidth;
                } else {
                    $newSourceHeight = ($sourceWidth * $destHeight) / $destWidth;
                    $sourceY = (int)(($sourceHeight - $newSourceHeight) / 2);
                    $sourceX = 0;
                    $sourceHeight = (int)$newSourceHeight;
                }
            }

            $destImage = imagecreatetruecolor($destWidth, $destHeight);
            imagecopyresampled($destImage, $sourceImage, 0, 0, $sourceX, $sourceY, $destWidth, $destHeight, $sourceWidth, $sourceHeight);
            imagejpeg($destImage, $file['tmp_name']);

            $objectFile = new JObject($file);

            if (!JFile::upload($objectFile->tmp_name, $objectFile->filepath)) {
                // Error in upload
                throw new Exception(JText::_('COM_VPPI_ERROR_UNABLE_TO_UPLOAD_FILE'));
            } else {
                $firstImage = false;
                if (strpos($objectFile->filepath, 'poster')) {
                    $firstImage = true;
                }
                $path = preg_replace('@(.*?)(\\images.*?\.jpg|\\images.*?\.jpeg)@', '\2', $objectFile->filepath);
                $parts = explode('\\', $path);
                $filepath = '/' . implode('/', $parts);
                $this->store($this->input->get('id'), $filepath, $firstImage);
                $uploadCount++;
            }

            // create thumbnail images
            $thumbFilepath = JFile::stripExt($file['filepath']) . '-thumb.jpg';
            $thumbWidth = 250;
            $thumbHeight = (int)(($thumbWidth * $destHeight) / $destWidth);
            $slideImage = imagecreatefromjpeg($objectFile->filepath);
            $slideWidth = imagesx($slideImage);
            $slideHeight = imagesy($slideImage);
            $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
            imagecopyresampled($thumbImage, $slideImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $slideWidth, $slideHeight);

            if (!imagejpeg($thumbImage, $thumbFilepath)) {
                // Error in upload
                throw new Exception(JText::_('COM_VPPI_ERROR_UNABLE_TO_UPLOAD_THUMB_FILE'));
            } else {
                $thumbUploadCount++;
            }
        }
        if ($uploadCount > 0) {
            if ($uploadCount == 1) {
                $app = JFactory::getApplication();
                $app->enqueueMessage(JText::sprintf('COM_VPPI_SINGLE_UPLOAD_COMPLETE', $uploadCount), 'message');
            } else {
                $app = JFactory::getApplication();
                $app->enqueueMessage(JText::sprintf('COM_VPPI_UPLOAD_COMPLETE', $uploadCount), 'message');
            }
        }
        if ($thumbUploadCount > 0) {
            if ($thumbUploadCount == 1) {
                $app = JFactory::getApplication();
                $app->enqueueMessage(JText::sprintf('COM_VPPI_SINGLE_UPLOAD_THUMB_COMPLETE', $thumbUploadCount), 'message');
            } else {
                $app = JFactory::getApplication();
                $app->enqueueMessage(JText::sprintf('COM_VPPI_UPLOAD_THUMB_COMPLETE', $thumbUploadCount), 'message');
            }
        }

        return true;
    }

    public function store($homeId, $filepath, $firstImage) {
        $db = JFactory::getDbo();

        $columns = '(`home_id`, `name`, `ordering`)';
        if ($firstImage) {
            $values = $homeId . ', ' . $db->quote($filepath) . ', 1';
            $query = 'INSERT INTO ' . $db->quoteName('#__vppi_images') . $columns . ' VALUES (' . $values . ')';
        } else {
            $values = $homeId . ', ' . $db->quote($filepath) . ', MAX(`ordering`) + 1';
            $query = 'INSERT INTO ' . $db->quoteName('#__vppi_images') . $columns . ' SELECT ' . $values . ' FROM ' . $db->quoteName('#__vppi_images') . ' WHERE home_id = ' . $homeId;
        }
        $db->setQuery($query);
        $db->execute();
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
                $slidePhoto = str_replace('-thumb.jpg', '.jpg', $photo);
                $photoId = $this->input->get('id');
                try {
                    JFile::delete(JPATH_SITE . '/images/homes/' . $photoId . '/' . $slidePhoto);
                    JFile::delete(JPATH_SITE . '/images/homes/' . $photoId . '/' . $photo);
                    $this->unstore($photoId, $slidePhoto);
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            }
        }

        return true;
    }

    public function unstore($photoId, $photoName) {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('home_id') . ' = ' . $photoId,
            $db->quoteName('name') . ' LIKE ' . $db->quote('%' . $photoName . '%')
        );

        // get the furrent order of the image
        $query = $db->getQuery(true);
        $query->select($db->quoteName('ordering'))->from($db->quoteName('#__vppi_images'))->where($conditions);
        $db->setQuery($query);
        $currentOrder = $db->loadResult();

        // get the maximum order
        $query = $db->getQuery(true);
        $query->select('MAX(' . $db->quoteName('ordering') . ')')->from($db->quoteName('#__vppi_images'))->where($db->quoteName('home_id') . ' = ' . $photoId);
        $db->setQuery($query);
        $maxOrder = $db->loadResult();

        // delete the record
        $query = $db->getQuery(true);
        $query->delete($db->quoteName('#__vppi_images'))->where($conditions);
        $db->setQuery($query);
        $db->execute();

        // reorder images
        if ($currentOrder != $maxOrder) {
            $newOrder = $currentOrder;
            for ($i = $currentOrder; $i <= $maxOrder - 1; $i++) {
                $oldOrder = $newOrder + 1;
                $query = $db->getQuery(true);
                $query->update($db->quoteName('#__vppi_images'))->set($db->quoteName('ordering') . ' = ' . $newOrder)->where($db->quoteName('ordering') . ' = ' . $oldOrder);
                $db->setQuery($query);
                $db->execute();
                $newOrder = $oldOrder;
            }
        }
    }
}
