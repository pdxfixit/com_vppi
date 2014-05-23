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

/**
 * VPPI controller class.
 * @package        Joomla.Administrator
 * @subpackage     com_vppi
 * @since          1.6
 */
class VppiControllerHomeImages extends JControllerForm {
    /**
     * The folder we are uploading into
     *
     * @var   string
     */
    protected $folder = '';

    /**
     * Upload one or more files
     *
     * @return  boolean
     *
     * @since   1.5
     */
    public function upload()
    {
        // Check for request forgeries
        JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));
        $params = JComponentHelper::getParams('com_vppi');

        // Get some data from the request
        $files        = $this->input->files->get('Filedata', '', 'array');
        $return       = $this->input->post->get('return-url', null, 'base64');
        $this->folder = $this->input->get('folder', '', 'path');

        // Set the redirect
        if ($return)
        {
            $this->setRedirect(base64_decode($return) . '&folder=' . $this->folder);
        }

        // Authorize the user
        if (!$this->authoriseUser('create'))
        {
            return false;
        }

        if (($params->get('upload_maxsize', 0) * 1024 * 1024) != 0)
        {
            if (
                $_SERVER['CONTENT_LENGTH'] > ($params->get('upload_maxsize', 0) * 1024 * 1024)
                || $_SERVER['CONTENT_LENGTH'] > (int) (ini_get('upload_max_filesize')) * 1024 * 1024
                || $_SERVER['CONTENT_LENGTH'] > (int) (ini_get('post_max_size')) * 1024 * 1024
                || (($_SERVER['CONTENT_LENGTH'] > (int) (ini_get('memory_limit')) * 1024 * 1024) && ((int) (ini_get('memory_limit')) != -1))
            )
            {
                JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_WARNFILETOOLARGE'));
                return false;
            }
        }

        // Perform basic checks on file info before attempting anything
        foreach ($files as &$file)
        {
            $file['name']     = JFile::makeSafe($file['name']);
            $file['filepath'] = JPath::clean(implode(DIRECTORY_SEPARATOR, array(COM_MEDIA_BASE, $this->folder, $file['name'])));

            if ($file['error'] == 1)
            {
                JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_WARNFILETOOLARGE'));
                return false;
            }

            if (($params->get('upload_maxsize', 0) * 1024 * 1024) != 0 && $file['size'] > ($params->get('upload_maxsize', 0) * 1024 * 1024))
            {
                JError::raiseNotice(100, JText::_('COM_MEDIA_ERROR_WARNFILETOOLARGE'));
                return false;
            }

            if (JFile::exists($file['filepath']))
            {
                // A file with this name already exists
                JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_FILE_EXISTS'));
                return false;
            }

            if (!isset($file['name']))
            {
                // No filename (after the name was cleaned by JFile::makeSafe)
                $this->setRedirect('index.php', JText::_('COM_MEDIA_INVALID_REQUEST'), 'error');
                return false;
            }
        }

        // Set FTP credentials, if given
        JClientHelper::setCredentialsFromRequest('ftp');
        JPluginHelper::importPlugin('content');
        $dispatcher	= JEventDispatcher::getInstance();

        foreach ($files as &$file)
        {
            // The request is valid
            $err = null;

            if (!MediaHelper::canUpload($file, $err))
            {
                // The file can't be uploaded

                return false;
            }

            // Trigger the onContentBeforeSave event.
            $object_file = new JObject($file);
            $result = $dispatcher->trigger('onContentBeforeSave', array('com_media.file', &$object_file, true));

            if (in_array(false, $result, true))
            {
                // There are some errors in the plugins
                JError::raiseWarning(100, JText::plural('COM_MEDIA_ERROR_BEFORE_SAVE', count($errors = $object_file->getErrors()), implode('<br />', $errors)));
                return false;
            }

            if (!JFile::upload($object_file->tmp_name, $object_file->filepath))
            {
                // Error in upload
                JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_UNABLE_TO_UPLOAD_FILE'));
                return false;
            }
            else
            {
                // Trigger the onContentAfterSave event.
                $dispatcher->trigger('onContentAfterSave', array('com_media.file', &$object_file, true));
                $this->setMessage(JText::sprintf('COM_MEDIA_UPLOAD_COMPLETE', substr($object_file->filepath, strlen(COM_MEDIA_BASE))));
            }
        }

        return true;
    }
}
