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
$document->addStyleSheet('/media/com_vppi/css/vppi.css');

if (!$this->items) {
    echo JText::_('COM_VPPI_ITEM_NOT_LOADED');

    return;
}
?>
<div id="homes-list-listings">
    <div id="slideshow-listings" id="poster-pics">
    <?php if (!empty($this->posters) && !empty($this->items)) {
        foreach ($this->items as $item) {
            if (!empty($this->posters[$item->id]) && $item->state) { ?>
                <div class="thumbnail home-list-listing">
                    <a href="index.php?option=com_vppi&view=home&layout=default&id=<?php echo $item->id ?>">
                        <img src="/images/homes/<?php echo $this->posters[$item->id] ?>" width="100%" height="auto">
                    </a>
                    <div class="caption-full">
                        <a href="index.php?option=com_vppi&view=home&layout=default&id=<?php echo $item->id ?>">
                            <h4><?php echo $item->ml_number ?></h4>
                        </a>
                        <p><?php echo $item->street_address ?></p>
                        <p><?php echo $item->city ?>,&nbsp;<?php echo $item->state_prov ?>&nbsp;&nbsp;<?php echo $item->zip_code ?></p>
                    </div>
                </div>

            <?php
            }
        }
        ?>
    </div>
    <div class="clearfix"></div><br />
    <?php
    }
    ?>
</div>
