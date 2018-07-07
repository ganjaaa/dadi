<?php

namespace DND\Interfaces;

interface Objects {

    public static function getSQLList($filter = '', $rawfilter = '');

    public static function getSQLGet();

    public static function getSQLAdd();

    public static function getSQLEdit();

    public static function getSQLDel();

    public function bindSQLList(\PDOStatement &$stmt);

    public function bindSQLGet(\PDOStatement &$stmt);

    public function bindSQLAdd(\PDOStatement &$stmt);

    public function bindSQLEdit(\PDOStatement &$stmt);

    public function bindSQLDel(\PDOStatement &$stmt);

    public function setFromSqlRow(&$row);

    public function getAjax();
}
