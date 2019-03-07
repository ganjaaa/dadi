<?php

namespace DND\Helper;

class ApiHelper {

    public static function buildDatatableLimit($fields, $columns, $search, $order, $start = NULL, $length = NULL, $filter = NULL) {
        // Order
        $oColId = isset($order[0]['column']) && $order[0]['column'] >= 0 ? $order[0]['column'] : 0;
        $oCol = $fields[$oColId];
        $oDir = isset($order[0]['dir']) && $order[0]['dir'] == 'asc' ? 'asc' : 'desc';
        $orderQuery = 'ORDER BY ' . $oCol . ' ' . $oDir;
        // Limit
        $limitQuery = '';
        if ($start != NULL && $length != NULL) {
            $start = !empty($start) ? $start : 0;
            $length = !empty($length) ? $length : 10;
            $limitQuery .= 'LIMIT ' . $start . ', ' . $length;
        }

        // Search
        $searchQuery = '';
        $words = isset($search['value']) ? $search['value'] : '';
        if (!empty($words)) {
            $w = [];
            if ($filter !== NULL) {
                $w[] = $filter;
            }
            foreach (explode(' ', $words) as $word) {
                $word = trim($word);
                if ($word != '') {
                    $negate = (substr($word, 0, 1) == "!") ? true : false;
                    if ($negate) {
                        $word = substr($word, 1, strlen($word) - 1);
                    }

                    $t = [];
                    foreach ($fields as $field) {
                        if ($negate) {
                            $t[] = '( IFNULL(`' . $field . '`,"") NOT LIKE "%' . trim($word) . '%" )';
                        } else {
                            $t[] = '( `' . $field . '` LIKE "%' . trim($word) . '%" )';
                        }
                    }
                    $w[] = '( ' . implode(($negate ? ' AND ' : ' OR '), $t) . ' )';
                }
            }
            $searchQuery = 'WHERE ' . implode(' AND ', $w);
        } else {
            if ($filter !== NULL) {
                $searchQuery = 'WHERE ' . $filter;
            }
        }


        return $searchQuery . ' ' . $orderQuery . ' ' . $limitQuery;
    }

    public static function getResponseDummy() {
        return array(
            'success' => true,
            'message' => '',
            'errorCode' => 0,
            'data' => array()
        );
    }

    public static function getErrorMessage($code = null) {
        return array(
            'success' => false,
            'message' => self::messages($code),
            'errorCode' => $code,
            'data' => array()
        );
    }

    public static function messages($id) {
        switch ($id) {
            case 1:
                return 'Username oder Passwort dürfen nicht leer sein';
                break;
            case 2:
                return 'Username oder Passwort sind nicht korrekt';
                break;
            case 3:
                return 'Fehler in der Datenbank';
                break;
            case 4:
                return 'No Access';
                break;
            default :
                return 'Default Error';
                break;
        }
    }

}
