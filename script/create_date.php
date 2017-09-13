<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";

use Lib\Helper;

$helper = new Helper();
$d = new crateDate($helper);
$a = $helper->uuidGenerator();
//var_dump($a);exit;

if($d->date()){
    echo 'create date true';
} else {
    echo 'create date false';
}

class crateDate
{
    private $helper;
    public function __construct($helper)
    {
        $this->helper = $helper;
    }

    public function date()
    {
         $data['media_id'] = '';
         for ($i=1; $i<=31; $i++) {
            if($i<10) {
                $data['date'] = '2017-10-0' . $i;
            } else {
                $data['date'] = '2017-10-'. $i;
            }
            $this->helper->saveTable('date', $data);
         }
         return true;
    }

}
