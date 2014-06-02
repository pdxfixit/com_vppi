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
$document->addScript('//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
$document->addScript('/media/com_vppi/js/jquery.cycle2.js');
$document->addStyleSheet('/media/com_vppi/css/vppi.css');

if (!$this->items) {
    echo JText::_('COM_VPPI_ITEM_NOT_LOADED');

    return;
}
?>
<div id="homes-slideshow-listings">
    <div id="slideshow-listings" class="pics cycle-slideshow" data-cycle-fx="fadeout" data-cycle-speed="500" data-cycle-timeout="5000" data-cycle-slides="> a" data-cycle-prev="#prev" data-cycle-next="#next" data-cycle-pause-on-hover="true">
        <div class="cycle-overlay"></div>
        <?php if (!empty($this->posters['slide']) || !empty($this->items)) {
        foreach ($this->items as $item) {
            if (!empty($this->posters['slide'][$item->id]) && $item->state && $item->featured) {
                ?>
                <a href="index.php?option=com_vppi&view=home&layout=default&id=<?php echo $item->id; ?>" class="cycle-slide" data-cycle-title="<?php echo $item->street_address; ?>" data-cycle-desc="<?php echo $item->city; ?>,&nbsp;<?php echo $item->state_prov; ?>&nbsp;&nbsp;<?php echo $item->zip_code; ?>">
                    <img src="/images/homes/<?php echo $this->posters['slide'][$item->id]; ?>" width="100%" height="auto">
                    <?php if ($item->sold) { ?>
                        <img src="/media/com_vppi/images/sold.png" class="sold">
                    <?php
                    }
                    ?>
                </a>
            <?php
            }
        }
        ?>
    </div>
    <div id="next" class="arrow"><span>&gt;</span></div>
    <div id="prev" class="arrow"><span>&lt;</span></div>
    <div class="clearfix"></div>
    <br />
    <?php
    }
    ?>
</div>
