<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 11/25/16
 * Time: 6:00 PM
 */

namespace App\Helpers;


class MenuItems
{

    //$tree - menu data array
    //$parent - 0
    public static function menu_tree($tree, $parent){
        $tree2 = array();
        foreach($tree as $i => $item){
            if($item['parent_menu_id'] == $parent){
                $tree2[$item['id']] = $item;
                $tree2[$item['id']]['sub-menu'] = MenuItems::menu_tree($tree, $item['id']);
            }
        }
        return $tree2;
    }

}