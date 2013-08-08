<?php
namespace abstraction\xysLibrary\utils;

/**
 * Created by IntelliJ IDEA.
 * User: marioeugenio
 * Date: 10/26/12
 * Time: 9:36 AM
 * To change this template use File | Settings | File Templates.
 */
class utils
{
    const ASC_AZ = 1000;
    const DESC_AZ = 1001;
    const ASC_NUM = 1002;
    const DESC_NUM = 1003;


    function arraySort( $arr, $field, $sort_type, $sticky_fields = array() ) {
        $i = 0;
        foreach ($arr as $value) {
            $is_contiguous = true;
            if(!empty($grouped_arr)) {
                $last_value = end($grouped_arr[$i]);

                if(!($sticky_fields == array())) {
                    foreach ($sticky_fields as $sticky_field) {
                        if ($value[$sticky_field] <> $last_value[$sticky_field]) {
                            $is_contiguous = false;
                            break;
                        }
                    }
                }
            }
            if ($is_contiguous)
                $grouped_arr[$i][] = $value;
            else
                $grouped_arr[++$i][] = $value;
        }
        $code = '';
        switch($sort_type) {
            case self::ASC_AZ:
                $code .= 'return strcasecmp($a["'.$field.'"], $b["'.$field.'"]);';
                break;
            case self::DESC_AZ:
                $code .= 'return (-1*strcasecmp($a["'.$field.'"], $b["'.$field.'"]));';
                break;
            case self::ASC_NUM:
                $code .= 'return ($a["'.$field.'"] - $b["'.$field.'"]);';
                break;
            case self::DESC_NUM:
                $code .= 'return ($b["'.$field.'"] - $a["'.$field.'"]);';
                break;
        }

        $compare = create_function('$a, $b', $code);

        foreach($grouped_arr as $grouped_arr_key=>$grouped_arr_value)
            usort ( $grouped_arr[$grouped_arr_key], $compare );

        $arr = array();
        foreach($grouped_arr as $grouped_arr_key=>$grouped_arr_value)
            foreach($grouped_arr[$grouped_arr_key] as $grouped_arr_arr_key=>$grouped_arr_arr_value)
                $arr[] = $grouped_arr[$grouped_arr_key][$grouped_arr_arr_key];

        return $arr;
    }
}
