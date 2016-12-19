<?php
/**
 * Created by PhpStorm.
 * User: wzj
 * Date: 2016/9/29
 * Time: 10:33
 * global common functions
 */

/**
 * @param $type [string] response massage type
 * @return string
 * @description: return a xml template with type
 */
function get_tpl_obj($type){
    $type=ucwords($type);
    $tplStr=file_get_contents(C('MSG_TPL')."{$type}.xml");
    $tplObj = simplexml_load_string($tplStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    return $tplObj;
}

/**
 * @param $xmlObj [xml object]
 * @param null $value [array]
 * @return string
 * @description:echo xml object with string or traverse xml object and change it label's value with a array
 */
function xmlObj_traverse($xmlObj,$value=null){
    if($value == null){ //traverse xml object and echo it label's value
        foreach ($xmlObj as $k => $v){
            if($v->children()->getName()){
                echo $k,'<br/>';
                xmlObj_traverse($v->children(),$value); //recursive
            }else{
                echo $k,'----',$v,'<br/>';
            }
        }
    }else{  //traverse xml object and change it label's value with a array
        static $i=0;
        static $xmlArr=array();
        foreach ($xmlObj as $k => $v){
            if($v->children()->getName()){
                array_push($xmlArr,"<{$k}>");
                xmlObj_traverse($v->children(),$value); //recursive
                array_push($xmlArr,"</{$k}>");
            }else{
                array_push($xmlArr,"<{$k}>{$value[$i]}</{$k}>");
                $i++;
            }
        }
        $xmlStr='<xml>'.implode('',$xmlArr).'</xml>';
        return $xmlStr;
    }
}

/**
 * @param $addPos [object] the node of added
 * @param $node [object] the node of add
 * @description: add specific xml node for specific xml node
 */
function xml_add_node($addPos,$node){
    static $newNode;
    $newNode=$addPos->addChild("{$node->getName()}");
    foreach ($node as $k => $v){
        if($v->children()->getName()){
            xml_add_node($newNode,$v->children);
        }else{
            $newNode->addChild("$k","$v");
        }
    }
}
