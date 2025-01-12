<?php
/**
 * @package    Bulgaria Interactive Map
 *
 * @author     Cybertrain <Cybertrain@padova.it>
 * @copyright  https://git.asdev.io/
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://git.asdev.io/
 */

use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require_once __DIR__.'/helper.php';

$items = getArticles();

$coords = [];

foreach($items as $item) {
    // everyone
    if (! isset($item->coordinates) || $item->coordinates['lat'] === null) {
        continue;
    }

    // url = categorytitle/articleid-articlealias
    if ($item->language === "en-GB") {
        $coordsEN[$item->id] = [
                'id' => $item->id,
                'name' => $item->title,
                'alias' => $item->alias,
                'lat' => $item->coordinates['lat'],
                'long' => $item->coordinates['long'],
                'url' => JUri::base() . 'index.php/en/' . $item->category_alias . '/' . $item->id . '-' . $item->alias,
        ];
    } else {
        $coordsBG[$item->id] = [
            'id' => $item->id,
            'name' => $item->title,
            'alias' => $item->alias,
            'lat' => $item->coordinates['lat'],
            'long' => $item->coordinates['long'],
            'url' => JUri::base() . 'index.php/bg/' . $item->category_alias . '/' . $item->id . '-' . $item->alias,
    ];
    }

}

?>

<link rel="stylesheet" href="<?php JUri::base(); ?>modules/mod_bgInteractiveMap/assets/module.css">

<div class="bgmap" data-id="<?php echo $module->id; ?>">
    <input type="hidden" id="mapData" value="<?php echo htmlentities(json_encode(["en"=> $coordsEN, "bg"=> $coordsBG])) ; ?>" />
    <div id="mapid"></div>
</div>

<script src="<?php JUri::base();?>modules/mod_bgInteractiveMap/dist/bundle.js" defer></script>
