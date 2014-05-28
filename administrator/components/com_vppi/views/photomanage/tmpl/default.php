<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'media/com_vppi/css/vppi.css');
?>
<div class="row-fluid form-horizontal">
    <div class="span3">
        <form action="<?php echo JRoute::_('index.php?option=com_vppi&view=photomanage&layout=default&id=' . (int)$this->item->id); ?>" method="post" name="adminForm" id="home-images-form" enctype="multipart/form-data">
            <div>
                <h1><?php echo JText::_('COM_VPPI_POSTER_IMAGE'); ?></h1>
            </div>
            <div class="form-vertical">
                <div class="control-group">
                    <fieldset class="actions">
                        <label for="homeImageUpload"><?php echo JText::_('COM_VPPI_UPLOAD_POSTER_BUTTON_LABEL') ?></label>
                        <input type="file" name="homeImageFiles" id="homeImageUpload" /><br/>
                        <input type="submit" class="btn btn-primary" value="Upload Image" />
                    </fieldset>
                </div>
            </div>
            <input type="hidden" name="poster" value="1" />
            <input type="hidden" name="task" value="photomanage.upload" />
            <?php echo JHtml::_('form.token'); ?>
        </form>
    </div>
    <?php //TODO: fix so that when a new image is uploaded to overwrite poster.jpg, the new photo renders as the poster image
    if (JFile::exists(JPATH_SITE . '/images/homes/' . (int)$this->item->id . '/poster.jpg')) { ?>
        <div class="span9">
            <img src="/images/homes/<?php echo (int)$this->item->id ?>/poster.jpg" style="width: 300px">
        </div>
    <?php
    }
    ?>
</div>
<?php if (JFile::exists(JPATH_SITE . '/images/homes/' . (int)$this->item->id . '/poster.jpg')) { ?>
    <p></p>
    <div class="row-fluid form-horizontal">
        <div class="span3">
            <form action="<?php echo JRoute::_('index.php?option=com_vppi&view=photomanage&layout=default&id=' . (int)$this->item->id); ?>" method="post" name="adminForm" id="home-images-form" enctype="multipart/form-data">
                <div>
                    <h1><?php echo JText::_('COM_VPPI_HOME_IMAGES'); ?></h1>
                </div>
                <div class="form-vertical">
                    <div class="control-group">
                        <fieldset class="actions">
                            <label for="homeImageUpload"><?php echo JText::_('COM_VPPI_UPLOAD_BUTTON_LABEL') ?></label>
                            <input type="file" name="homeImageFiles[]" id="homeImageUpload" multiple /><br/>
                            <input type="submit" class="btn btn-primary" value="Upload Images" />
                        </fieldset>
                    </div>
                </div>
                <input type="hidden" name="poster" value="0" />
                <input type="hidden" name="task" value="photomanage.upload" />
                <?php echo JHtml::_('form.token'); ?>
            </form>
        </div>
        <div class="span9 row-fluid form-horizontal">
            <?php if (JFolder::exists(JPATH_SITE . '/images/homes/' . (int)$this->item->id . '/')) {
                $photos = JFolder::files(JPATH_SITE . '/images/homes/' . (int)$this->item->id . '/');
                $poster = array('poster.jpg');
                $photos = array_diff($photos, $poster);
            }
            // TODO: fix how photos of different height render for multiple photos
            if (!empty($photos)) { ?>
                <form action="<?php echo JRoute::_('index.php?option=com_vppi&view=photomanage&layout=default&id=' . (int)$this->item->id); ?>" method="post" name="adminForm" id="home-images-delete-form">
                    <div style="overflow: hidden;">
                    <?php foreach ($photos as $photo) { ?>
                        <div class="span3">
                            <input type="checkbox" name="photo[]" value="<?php echo $photo ?>">
                            <img src="/images/homes/<?php echo (int)$this->item->id ?>/<?php echo $photo ?>" style="width: 200px"><br />
                            <p><?php echo $photo ?></p>
                        </div>
                    <?php
                    }
                    ?>
                    </div><br />
                    <div>
                        <input type="submit" class="btn btn-primary" value="Delete Images" />
                        <input type="hidden" name="task" value="photomanage.delete" />
                        <?php echo JHtml::_('form.token'); ?>
                    </div>
                </form>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}
