<?php
define('SITE_URL', dirname(dirname(__FILE__)));

// var_dump(SITE_URL);exit;
include_once SITE_URL . '/lib/Helper.php';

$helper = new Helper();
$d = new crateDate();
if($d->date()){
  echo 'create date true';
} else {
  echo 'create date false';
}

class crateDate
{
  public function __construct()
  {

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
        $helper->saveTable('date', $data);
     }
     return true;
  }

}
