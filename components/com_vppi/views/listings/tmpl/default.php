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

$document = JFactory::getDocument();
$document->addScript('/media/com_vppi/js/jquery.v1.5.js');
$document->addScript('/media/com_vppi/js/jquery.cycle.all.js');
$document->addStyleSheet('/media/com_vppi/css/vppi.css');
$document->addScriptDeclaration("
    $(document).ready(function() {
        $('#slideshow-listings').cycle({
            fx:         'fade',
            speed:      500,
            timeout:    5000,
            next:       '#next',
            prev:       '#prev',
            pause:      1
        });
    });
");

if (!$this->items) {
    echo JText::_('COM_VPPI_ITEM_NOT_LOADED');

    return;
} // TODO: fix image container to have dynamic height & overlay address and sold images
?>
<div id="homes-slideshow-listings">
    <div id="slideshow-listings" id="poster-pics">
    <?php if (!empty($this->posters) && !empty($this->items)) {
        foreach ($this->items as $item) {
            if (!empty($this->posters[$item->id]) && $item->state && $item->featured) { ?>
                <a href="index.php?option=com_vppi&view=home&layout=default&id=<?php echo $item->id ?>">
                    <img src="/images/homes/<?php echo $this->posters[$item->id] ?>" width="100%" height="auto">
                </a>
            <?php
            }
        }
        ?>
    </div>
    <div id="next" class="arrow"><span>></span></div>
    <div id="prev" class="arrow"><span><</span></div>
    <div class="clearfix"></div><br />
    <?php
    }
    ?>
</div>
