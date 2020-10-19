<?php
require_once dirname(__FILE__) . '/excel_reader2.php';

class ExcelImport extends Spreadsheet_Excel_Reader
{
  function __construct()
  {
      parent::__construct();
  }
}
?>
