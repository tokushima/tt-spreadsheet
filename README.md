# tt-spreadsheet


```

$obj = new \tt\Spreadsheet();

$obj->set_sheet_title('最初');
$obj->set_cell_width(1,100);
$obj->set_cell(1,1,'コード','FFCC33');
$obj->set_cell(2,1,'日付','FFCC33');

for($i=2;$i<1000;$i++){
	$obj->set_cell(1,$i,'012345678901234567890'.sprintf('%04d',$i));
	$obj->set_cell(2,$i,date('Y/m/d',time() + ($i * 86400)));
}


$obj->add_sheet('次');
$obj->set_cell_width(1,100);
$obj->set_cell(1,1,'コード','CCFF33');
$obj->set_cell(2,1,'日付','CCFF33');

for($i=2;$i<100;$i++){
	$obj->set_cell(1,$i,'ABC'.sprintf('%04d',$i));
	$obj->set_cell(2,$i,date('Y/m/d',time() + ($i * 86400)));
}
$obj->write('AAAAA.xlsx');



$obj = new \tt\Spreadsheet('AAAAA.xlsx');
$obj->active_sheet('次');
var_dump($obj->get_cell(1,10));

```
