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
    <div style="padding-left: 10px; padding-bottom: 15px;">
        <h4>
            Browse our listings or search the <a href="http://www.rmls.com/RC2/UI/search_residential.asp" target="_blank">RMLS Website</a>.
        </h4>
    </div>
    <div id="slideshow-listings" id="poster-pics" class="container">
        <?php if (!empty($this->posters['thumb']) && !empty($this->items)) {
        foreach ($this->items as $item) {
            if (!empty($this->posters['thumb'][$item->id]) && $item->state) {
                ?>
                <div class="thumbnail home-list-listing">
                    <a href="<?php echo JRoute::_('index.php?option=com_vppi&view=home&id=' . $item->id); ?>" style="display: block;">
                        <img src="/images/homes/<?php echo $this->posters['thumb'][$item->id]; ?>" width="100%" height="auto">
                        <?php if ($item->sold) {
                            ?>
                            <img src="/media/com_vppi/images/sold-thumb.png" class="sold">
                        <?php
                        }
                        ?>
                        <div class="overlay">
                            <address>
                                <div class="overlay-address"><div><?php echo $item->name; ?></div><br />
                                <div class="city-state-zip"><?php echo $item->city; ?>,&nbsp;<?php echo $item->state_prov; ?></div>&nbsp;&nbsp;<div class="city-state-zip"><?php echo $item->zip_code; ?></div></div>
                            </address>
                        </div>
                    </a>
                </div>

            <?php
            }
        }
        ?>
    </div>
    <div class="clearfix"></div>
    <br />
    <?php
    }
    ?>
</div>
