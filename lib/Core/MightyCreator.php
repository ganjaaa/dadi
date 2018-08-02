<?php

namespace DND\Core;

class MightyCreator {

    const tab = "    ";

    private $target;
    private $filename;
    private $xml;
    private $fhandler;
    private $t_class;
    private $t_sql;
    private $t_templates;
    private $t_controller;
    private $controller;
    private $keyname;
    private $keytype;
    private $info;

    public function __construct() {
        $this->target = __DIR__ . '/compiled';
        $this->controller = array();
        $this->table_name = '';
        $this->info = 0;
    }

    public function loadXML($filename) {
        $this->filename = $filename;
        $this->xml = simplexml_load_file($filename) or die("Error: Cannot create object");
    }

    function setT_class($t_class) {
        $this->t_class = $t_class;
    }

    function setT_sql($t_sql) {
        $this->t_sql = $t_sql;
    }

    function setT_templates($t_templates) {
        $this->t_templates = $t_templates;
    }

    function setT_controller($t_controller) {
        $this->t_controller = $t_controller;
    }

    public function info() {
        echo $this->filename . " - Größe: " . filesize($this->filename) . "\n";
        $this->info += filesize($this->filename);
    }

    public function finish() {
        echo "=====================================" . "\n";
        echo "Finish : " . $this->info . "\n";
    }

    public function create() {
        #print_r($this->controller);
        foreach ($this->xml->classes->class as $class) {
            $this->keyname = 'id';
            $this->keytype = 'int';
            if (isset($class->keyname) && !empty($class->keyname)) {
                $this->keyname = $class->keyname;
            }
            if (isset($class->keytype) && !empty($class->keytype)) {
                $this->keytype = $class->keytype;
            }

            $over = [];
            foreach ($class->override->function as $fkt) {
                $alpha = 'abcdefghijkl';
                $params = array();
                for ($i = 0; $i < $fkt['parameters']; $i++) {
                    $params[] = '$' . $alpha[$i];
                }
                $over[(string) $fkt['id']] = $this->templateFunction($fkt['id'], implode(', ', $params), array($fkt));
            }

            $this->controller[] = array(
                'name' => $class->name,
                'use' => (strlen($class->namespace) > 0) ? 'use ' . $class->namespace . '\\' . $class->name . ';' . PHP_EOL : ''
            );

            $str = $this->getHeader($class);
            $str .= $this->getConstants($class);
            $str .= $this->getVariables($class);

            $str .= $this->getFunctions($class);

            $str .= $this->getGetterSetter($class);


            //-- SQL List
            $str .= isset($over['getSQLList']) ? $over['getSQLList'] : $this->templateFunction('getSQLList', '$filter = "", $rawfilter = ""', array('return "SELECT * FROM `" . self::tableName . "`" . ($filter != "" ? " WHERE " . $filter : "") . " " . $rawfilter;'), false, true);
            $str .= isset($over['bindSQLList']) ? $over['bindSQLList'] : $this->templateFunction('bindSQLList', '\PDOStatement &$stmt');

            //-- SQL Get
            $str .= isset($over['getSQLGet']) ? $over['getSQLGet'] : $this->templateFunction('getSQLGet', '', array('return "SELECT * FROM `" . self::tableName . "` WHERE `' . $this->keyname . '`=:' . $this->keyname . ';";'), false, true);
            $str .= isset($over['bindSQLGet']) ? $over['bindSQLGet'] : $this->templateFunction('bindSQLGet', '\PDOStatement &$stmt', array('$stmt->bindParam(":' . $this->keyname . '", $this->' . $this->keyname . ');'));

            // ----------------------------------------------
            $params = array();
            $values = array();
            $update = array();
            $bindes = array();
            $ajaxes = array();
            $fromrw = array();
            $filler = array('if(isset($array["' . $this->keyname . '"]) && !empty($array["' . $this->keyname . '"])){$this->' . $this->keyname . ' = $array["' . $this->keyname . '"];}');

            foreach ($class->variables->variable as $var) {
                if (!isset($var['virtual']) || $var['virtual'] == 0) {
                    $params[] = '`' . $var['id'] . '`';
                    $values[] = ':' . $var['id'];
                    $update[] = '`' . $var['id'] . '` = :' . $var['id'];
                    $bindes[] = '$stmt->bindParam(":' . $var['id'] . '", $this->' . $var['id'] . ');';
                    $fromrw[] = '$this->' . $var['id'] . ' =  $rec["' . $var['id'] . '"];';
                    $filler[] = 'if(isset($array["' . $var['id'] . '"])){$this->' . $var['id'] . ' = $array["' . $var['id'] . '"];}';
                }
                $ajaxes[] = '"' . $var['id'] . '" => $this->' . $var['id'] . ', ';
            }
            // ----------------------------------------------
            //-- Fill from Post
            $str .= isset($over['fillFromPost']) ? $over['fillFromPost'] : $this->templateFunction('fillFromPost', '$array=array()', $filler);
            //-- SQL Add
            $content = array();
            $content[] = 'return "INSERT INTO `" . self::tableName . "` (`' . $this->keyname . '`, ' . implode(', ', $params) . ' )" . " VALUES " . " (' . ($this->keytype == 'int' ? 'NULL' : ':' . $this->keyname) . ' , ' . implode(', ', $values) . ' );";';
            $str .= isset($over['getSQLAdd']) ? $over['getSQLAdd'] : $this->templateFunction('getSQLAdd', '', $content, false, true);
            $str .= isset($over['bindSQLAdd']) ? $over['bindSQLAdd'] : $this->templateFunction('bindSQLAdd', '\PDOStatement &$stmt', ($this->keyname == 'id' ) ? $bindes : array_merge(array('$stmt->bindParam(":' . $this->keyname . '", $this->' . $this->keyname . ');'), $bindes) );

            //-- SQL Edit
            $content = array();
            $content[] = 'return "UPDATE `" . self::tableName . "` SET ' . implode(', ', $update) . ' " . " WHERE `' . $this->keyname . '` = :' . $this->keyname . ';"; ';
            $str .= isset($over['getSQLEdit']) ? $over['getSQLEdit'] : $this->templateFunction('getSQLEdit', '', $content, false, true);
            $str .= isset($over['bindSQLEdit']) ? $over['bindSQLEdit'] : $this->templateFunction('bindSQLEdit', '\PDOStatement &$stmt', array_merge(array('$stmt->bindParam(":' . $this->keyname . '", $this->' . $this->keyname . ');'), $bindes));

            //-- SQL Del
            $str .= isset($over['getSQLDel']) ? $over['getSQLDel'] : $this->templateFunction('getSQLDel', '', array('return "DELETE FROM " . self::tableName . " WHERE ' . $this->keyname . '=:' . $this->keyname . ';";'), false, true);
            $str .= isset($over['bindSQLDel']) ? $over['bindSQLDel'] : $this->templateFunction('bindSQLDel', '\PDOStatement &$stmt', array('$stmt->bindParam(":' . $this->keyname . '", $this->' . $this->keyname . ');'));

            //-- AJAX
            $str .= isset($over['getAjax']) ? $over['getAjax'] : $this->templateFunction('getAjax', '', array_merge(array('return array(', '"' . $this->keyname . '" => $this->' . $this->keyname . ', '), $ajaxes, array(');')));
            $str .= isset($over['setFromSqlRow']) ? $over['setFromSqlRow'] : $this->templateFunction('setFromSqlRow', '&$rec', array_merge(array('$this->' . $this->keyname . ' = $rec["' . $this->keyname . '"];'), $fromrw));

            //-- Class-End
            $str .= "}" . PHP_EOL . PHP_EOL . '?>';

            // Write Class
            $this->fhandler = fopen($this->t_class . '/' . $class->name . '.php', 'w+');
            fwrite($this->fhandler, $str);
            fclose($this->fhandler);

            // Write SQL
            if (!empty($class->table)) {
                $this->fhandler = fopen($this->t_sql . '/' . $class->name . '.sql', 'w+');
                fwrite($this->fhandler, $this->getSQLCreate($class));
                fclose($this->fhandler);
            }
            // Write Forms
            $this->fhandler = fopen($this->t_templates . '/' . $class->name . '.tpl', 'w+');
            fwrite($this->fhandler, $this->getFormsCreate($class));
            fclose($this->fhandler);
        }
    }

    function writeController() {
        $this->fhandler = fopen($this->t_controller . '/ObjectHandler.php', 'w+');
        fwrite($this->fhandler, $this->templateController());
        fclose($this->fhandler);
    }

    function getHeader($class) {
        $str = '<?php' . PHP_EOL;

        // Includes
        foreach ($class->includes->include as $var)
            $str .= "require_once '$var'" . PHP_EOL;
        $str .= PHP_EOL;

        // Namespace
        if (strlen($class->namespace) > 0)
            $str .= 'namespace ' . $class->namespace . ';' . PHP_EOL;
        $str .= PHP_EOL;

        // Use
        foreach ($class->uses->use as $var)
            $str .= "use $var;" . PHP_EOL;
        $str .= PHP_EOL;

        // Class Head
        $str .= "class {$class->name}";
        $str .= (strlen($class->implements) > 0 ? ' implements ' . $class->implements : '');
        $str .= (strlen($class->extends) > 0 ? ' extends ' . $class->extends : '');
        $str .= " {" . PHP_EOL;
        $str .= PHP_EOL;

        return $str;
    }

    function getConstants($class) {
        $table = (isset($class->table) && !empty($class->table)) ? $class->table : strtolower($class->name);
        // Konstanten
        $str = self::tab . "const tableName = '" . $table . "';" . PHP_EOL;
        foreach ($class->constants->constant as $var)
            $str .= self::tab . "const {$var['id']} = $var;" . PHP_EOL;
        $str .= PHP_EOL;
        return $str;
    }

    function getVariables($class) {
        // Variablen
        $str = self::tab . "private \$" . $this->keyname . ";" . PHP_EOL;
        foreach ($class->variables->variable as $var)
            $str .= self::tab . "private \$" . $var['id'] . (isset($var['default']) ? ' = ' . $var['default'] : '') . ";" . PHP_EOL;
        $str .= PHP_EOL;
        return $str;
    }

    function getFunctions($class) {
        // Constructor
        $str = '';
        $str .= $this->templateFunction('__construct');

        // Funktionen
        foreach ($class->functions->function as $fkt) {
            $alpha = 'abcdefghijklmnopqrstuvwxyz';
            $params = array();
            for ($i = 0; $i < $fkt['parameters']; $i++) {
                $params[] = '$' . $alpha[$i] . ' = NULL';
            }

            $str .= $this->templateFunction($fkt['id'], implode(', ', $params), array($fkt));
        }
        return $str;
    }

    function getGetterSetter($class) {
        // Getter Setter
        $override = array();
        foreach ($class->override->function as $fkt) {
            $alpha = 'abcdefghijkl';
            $params = array();
            for ($i = 0; $i < $fkt['parameters']; $i++) {
                $params[] = '$' . $alpha[$i];
            }
            #var_dump($fkt);
            #var_dump($fkt['id']);
            $override[(string) $fkt['id']] = $this->templateFunction($fkt['id'], implode(', ', $params), array($fkt));
        }


        $str = '';
        $str .= (isset($override['getId'])) ? $override['getId'] : $this->templateFunction('getId', '', array('return $this->id;'));
        $str .= (isset($override['setId'])) ? $override['setId'] : $this->templateFunction('setId', '$value', array('$this->id = $value;', 'return $this;'));

        foreach ($class->variables->variable as $var) {
            $fname = ucfirst(strtolower($var['id']));
            $str .= (isset($override['get' . $fname])) ? $override['get' . $fname] : $this->templateFunction('get' . $fname, '', array('return $this->' . $var['id'] . ';'));
            $str .= (isset($override['set' . $fname])) ? $override['set' . $fname] : $this->templateFunction('set' . $fname, '$value', array('$this->' . $var['id'] . ' = $value;', 'return $this;'));
        }
        return $str;
    }

    function getSQLCreate($class) {
        $table = (isset($class->table) && !empty($class->table)) ? $class->table : strtolower($class->name);

        $str = 'DROP TABLE IF EXISTS `' . $table . '`;' . PHP_EOL;
        $str .= 'CREATE TABLE `' . $table . '` (' . PHP_EOL;
        $str .= ' `' . $this->keyname . '` ' . $this->keytype . ' NOT NULL ' . ($this->keytype != 'int' ? '' : 'AUTO_INCREMENT') . ',' . PHP_EOL;

        foreach ($class->variables->variable as $var) {
            if (!isset($var['virtual']) || $var['virtual'] == 0) {
                $str .= ' `' . $var['id'] . '` ' . $var . ' DEFAULT NULL,' . PHP_EOL;
            }
        }
        $str .= 'PRIMARY KEY (`' . $this->keyname . '`)' . PHP_EOL;
        $str .= ') ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;' . PHP_EOL;
        $str .= PHP_EOL;
        return $str;
    }

    function getFormsCreate($class) {
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');
        $str = '';
        $javascript = '';
        $indize = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p'];
        $index = 0;

        foreach ($class->forms->form as $form) {
            $str .= '<div id="' . $class->name . '_' . $form['id'] . '" class="ui modal">' . PHP_EOL;
            $str .= $this->t(1) . '<i class="close icon"></i>' . PHP_EOL;
            $str .= $this->t(1) . '<div class="header">' . $form['title'] . '</div>' . PHP_EOL;
            $str .= $this->t(1) . '<div class="content">' . PHP_EOL;
            $str .= $this->t(2) . '<form class="ui form">' . PHP_EOL;
            $str .= $this->t(3) . '<input id="' . $class->name . '_' . $form['id'] . '_' . $this->keyname . '" name="id" type="hidden" value="">' . PHP_EOL;
            foreach ($form->fields as $field) {
                $count = 0;
                $fields = [];
                foreach ($field->field as $line) {
                    $name = $class->name . '_' . $form['id'] . '_' . $line['id'];
                    $count++;
                    $tmp = '';
                    $tmp .= $this->t(4) . '<div class="field">' . PHP_EOL;
                    $tmp .= $this->t(5) . '<label>' . $line['label'] . '</label>' . PHP_EOL;
                    switch ($line['type']) {
                        case 'ajax-select':
                            $index++;
                            $tmp .= $this->t(5) . '<select id="' . $name . '" name="' . $line['id'] . (isset($line['multiple']) ? '[]' : '') . '" class="ui fluid remote search dropdown" ' . (isset($line['multiple']) ? 'multiple=""' : '') . '>';
                            //$tmp .= $this->t(6) . '<option value="">-</option>';
                            $tmp .= $this->t(5) . '</select>';
                            if (isset($line['url'])) {
                                $javascript .= $this->t(3) . "$('#" . $name . "').dropdown({" . PHP_EOL;
                                $javascript .= $this->t(3) . " apiSettings: {" . PHP_EOL;
                                $javascript .= $this->t(3) . "   url: '{/literal}{\$BASEURL}{literal}" . $line['url'] . "'" . PHP_EOL;
                                $javascript .= $this->t(3) . " }," . PHP_EOL;
                                $javascript .= $this->t(3) . " filterRemoteData: true," . PHP_EOL;
                                $javascript .= $this->t(3) . " fields: {" . PHP_EOL;
                                $javascript .= $this->t(3) . "   remoteValues: 'data'," . PHP_EOL;
                                $javascript .= $this->t(3) . "   name: 'name'," . PHP_EOL;
                                $javascript .= $this->t(3) . "   value: 'id'" . PHP_EOL;
                                $javascript .= $this->t(3) . " }," . PHP_EOL;
                                $javascript .= $this->t(3) . "});" . PHP_EOL;
                                /*
                                  $javascript .= $this->t(3) . "$.ajax({" . PHP_EOL;
                                  $javascript .= $this->t(3) . "  url: '" . $line['url'] . "'," . PHP_EOL;
                                  $javascript .= $this->t(3) . "  dataType: 'json'," . PHP_EOL;
                                  $javascript .= $this->t(3) . "  type: 'GET'," . PHP_EOL;
                                  $javascript .= $this->t(3) . "  data: {}," . PHP_EOL;
                                  $javascript .= $this->t(3) . "  success: function (data) {" . PHP_EOL;
                                  $javascript .= $this->t(3) . "    if (data.success) {" . PHP_EOL;
                                  $javascript .= $this->t(3) . "        $('#" . $name . "').html('<option value=\"\">-</option>');" . PHP_EOL;
                                  $javascript .= $this->t(3) . "        $.each(data.data, function (idx, val) {" . PHP_EOL;
                                  $javascript .= $this->t(3) . "            $('#" . $name . "').append('<option value=\"'+val.id+'\">'+val.name+'</option>');" . PHP_EOL;
                                  $javascript .= $this->t(3) . "        });" . PHP_EOL;
                                  $javascript .= $this->t(3) . "    } else {" . PHP_EOL;
                                  $javascript .= $this->t(3) . "        $('#" . $name . "').html('<option value=\"\">'+data.message+'</option>'); " . PHP_EOL;
                                  $javascript .= $this->t(3) . "    }" . PHP_EOL;
                                  $javascript .= $this->t(3) . "  }" . PHP_EOL;
                                  $javascript .= $this->t(3) . "});" . PHP_EOL;
                                 */
                            }

                            break;
                        case 'select-smarty':
                            $tmp .= $this->t(5) . '<select id="' . $name . '" name="' . $line['id'] . '">';
                            $tmp .= $this->t(5) . '{$' . $line['varname'] . '}';
                            $tmp .= $this->t(5) . '</select>';
                            break;
                        case 'select':
                            $tmp .= $this->t(5) . '<select id="' . $name . '" name="' . $line['id'] . '">';
                            if (isset($line['type-value'])) {
                                foreach (explode('|', $line['type-value']) as $o) {
                                    if (strpos($o, '=') !== false) {
                                        list($a, $b) = explode('=', $o);
                                    } else {
                                        $a = $o;
                                        $b = $o;
                                    }
                                    $tmp .= $this->t(6) . '<option value="' . $a . '">' . $b . '</option>';
                                }
                            }
                            if (isset($line['type-callback'])) {
                                foreach (call_user_func((string) $line['type-callback']) as $a => $b) {
                                    $tmp .= $this->t(6) . '<option value="' . $a . '">' . $b . '</option>';
                                }
                            }
                            $tmp .= $this->t(5) . '</select>';
                            break;
                        case 'textarea':
                            $tmp .= $this->t(5) . '<textarea name="' . $line['id'] . '"  id="' . $name . '" placeholder="' . $line['placeholder'] . '"></textarea>' . PHP_EOL;
                            break;
                        case 'div':
                            $tmp .= $this->t(5) . '<div id="' . $line['id'] . '"></div>' . PHP_EOL;
                            break;
                        default:
                            $tmp .= $this->t(5) . '<input type="' . $line['type'] . '" name="' . $line['id'] . '"  id="' . $name . '" placeholder="' . $line['placeholder'] . '" ' . (isset($line['default']) ? 'value="' . $line['default'] . '"' : '') . '>' . PHP_EOL;
                            break;
                    }
                    if (isset($line['hint'])) {
                        $tmp .= '<small>' . $line['hint'] . '</small>';
                    }
                    $tmp .= $this->t(4) . '</div>' . PHP_EOL;
                    $fields[] = $tmp;
                }


                if (isset($field['legend']) && !empty($field['legend'])) {
                    $str .= $this->t(4) . '<fieldset>' . PHP_EOL;
                    $str .= $this->t(5) . '<legend>' . $field['legend'] . '</legend>' . PHP_EOL;
                    if ($list1[$count] == 'one') {
                        foreach ($fields as $f) {
                            $str .= $f;
                        }
                    } else {
                        $str .= $this->t(3) . '<div class="' . $list1[$count] . ' fields">' . PHP_EOL;
                        foreach ($fields as $f) {
                            $str .= $f;
                        }
                        $str .= $this->t(3) . '</div>' . PHP_EOL;
                    }
                    $str .= $this->t(4) . '</fieldset>' . PHP_EOL;
                } else {
                    if ($list1[$count] == 'one') {
                        foreach ($fields as $f) {
                            $str .= $f;
                        }
                    } else {
                        $str .= $this->t(3) . '<div class="' . $list1[$count] . ' fields">' . PHP_EOL;
                        foreach ($fields as $f) {
                            $str .= $f;
                        }
                        $str .= $this->t(3) . '</div>' . PHP_EOL;
                    }
                }
            }
            $str .= $this->t(2) . '</form>' . PHP_EOL;
            $str .= $this->t(1) . '</div>' . PHP_EOL;
            $str .= $this->t(1) . '<div class="actions">' . PHP_EOL;
            $str .= $this->t(2) . '<div class="ui black approve button" data-kind="1">Speichern</div>' . PHP_EOL;
            $str .= $this->t(2) . '<div class="ui red deny button">Abbrechen</div>' . PHP_EOL;
            $str .= $this->t(1) . '</div>' . PHP_EOL;
            $str .= '</div>' . PHP_EOL;
            $str .= PHP_EOL;
        }

        if (!empty($javascript)) {
            $str .= '<script>' . PHP_EOL;
            $str .= '{literal}' . PHP_EOL;
            $str .= '$(document).ready(function () {' . PHP_EOL;
            $str .= $javascript;
            $str .= '});' . PHP_EOL;
            $str .= '{/literal}' . PHP_EOL;
            $str .= '</script>' . PHP_EOL;
        }

        return $str;
    }

    private function templateFunction($name, $parameters = '', $content = array(), $private = false, $static = false) {
        $str = '';
        $str .= $this->t(1) . ($private ? 'private ' : 'public ') . ($static ? 'static ' : '') . "function $name($parameters) {" . PHP_EOL;
        foreach ($content as $line) {
            $str .= $this->t(2) . $line . PHP_EOL;
        }
        $str .= $this->t(1) . "}" . PHP_EOL;
        $str .= PHP_EOL;
        return $str;
    }

    private function templateController() {
        $functionen = '';
        $uses = '';

        foreach ($this->controller as $item) {
            $uses .= $item['use'];
            $functionen .= '    public function list' . $item['name'] . '($filter = \'\', $rawfilter = \'\') {
        $result = array();
        $q = ' . $item['name'] . '::getSQLList($filter, $rawfilter);
        $s = $this->pdo->prepare($q);
        if ($s->execute()) {
            while ($rec = $s->fetch(PDO::FETCH_ASSOC)) {
                $obj = new ' . $item['name'] . '();
                $obj->setFromSqlRow($rec);
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function get' . $item['name'] . '($' . $this->keyname . ') {
        $obj = new ' . $item['name'] . '();
        $obj->set' . ucfirst($this->keyname) . '($' . $this->keyname . ');
        $q = ' . $item['name'] . '::getSQLGet();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLGet($s);
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                $rec = $s->fetch(PDO::FETCH_ASSOC);
                $obj->setFromSqlRow($rec);
                return $obj;
            }
        }
        return NULL;
    }

    public function add' . $item['name'] . '(' . $item['name'] . ' &$obj) {
        $q = ' . $item['name'] . '::getSQLAdd();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLAdd($s);
        if ($s->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function edit' . $item['name'] . '(' . $item['name'] . ' &$obj) {
        $q = ' . $item['name'] . '::getSQLEdit();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLEdit($s);
        return $s->execute();
    }

    public function del' . $item['name'] . '(' . $item['name'] . ' &$obj) {
        $q = ' . $item['name'] . '::getSQLDel();
        $s = $this->pdo->prepare($q);
        $obj->bindSQLDel($s);
        return $s->execute();
    }

';
        }

        return '<?php

namespace DND\\Core;

' . $uses . '
use \PDO;

class ObjectHandler{
    private $pdo;

    public function __construct(\\PDO &$pdo) {
        $this->pdo = $pdo;
    }

    ' . $functionen . '
}';
    }

    private function t($c = 1) {
        $t = '';
        for ($i = 0; $i < $c; $i++)
            $t .= self::tab;
        return $t;
    }

}
