<?php
namespace tt;
/**
 * 
 * @composer phpoffice/phpspreadsheet 1.2.0
 * @author tokushima
 *
 */
class Spreadsheet{
	private $spshee;
	private $active_sheet;
	
	public function __construct($filename=null){
		if(ini_get('date.timezone') == ''){
			date_default_timezone_set('Asia/Tokyo');
		}
		if(!empty($filename)){
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$this->spshee = $reader->load($filename);
		}else{
			$this->spshee = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		}
		$this->active_sheet = $this->spshee->setActiveSheetIndex(0);
	}
	
	/**
	 * シートに名前をつける
	 * @param string $title
	 */
	public function set_sheet_title($title){
		$this->active_sheet->setTitle($title);
		return $this;
	}
	
	/**
	 * シートを追加する
	 * @param string $title
	 */
	public function add_sheet($title=null){
		$this->active_sheet = $this->spshee->createSheet();
		
		if(!empty($title)){
			$this->set_sheet_title($title);
		}
		return $this;
	}
	
	/**
	 * シートを選択する
	 * @param number $index
	 */
	public function active_sheet($index=0){
		if(is_int($index)){
			$this->active_sheet = $this->spshee->setActiveSheetIndex($index);
		}else{
			$this->active_sheet = $this->spshee->setActiveSheetIndexByName($index);
		}
		return $this;
	}
	
	/**
	 * セルの幅を指定する
	 * @param integer $column
	 * @param integer $size
	 */
	public function set_cell_width($column,$size){
		$this->active_sheet->getColumnDimensionByColumn($column)->setWidth($size);
		return $this;
	}
	
	/**
	 * セルに値をセットする
	 * @param integer $column
	 * @param integer $row
	 * @param mixed $value
	 * @param string $bgrgb
	 * @param number $width
	 */
	public function set_cell($column,$row,$value,$bgrgb=null,$width=0){
		$this->active_sheet->setCellValueByColumnAndRow($column,$row,$value,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

		if(!empty($bgrgb)){
			$this->active_sheet->getStyleByColumnAndRow($column,$row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
			$this->active_sheet->getStyleByColumnAndRow($column,$row)->getFill()->getStartColor()->setRGB($bgrgb);
		}
		return $this;
	}
	
	/**
	 * セルの値を取得する
	 * @param integer $column
	 * @param integer $row
	 * @return mixed
	 */
	public function get_cell($column,$row){
		$cell = $this->active_sheet->getCellByColumnAndRow($column,$row);
		return $cell->getValue();
	}
	
	/**
	 * attachmentとして出力する
	 * @param string $filename
	 */
	public function output($filename=null){
		if(empty($filename)){
			$filename = date('YmdHis').'.xlsx';
		}
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment;filename="'.$filename.'"');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($this->spshee);
		$writer->save('php://output');
	}
	
	/**
	 * xlsとしてファイルに書き出す
	 * @param string $filename
	 */
	public function write($filename=null){
		if(empty($filename)){
			$filename = getcwd().'/'.date('YmdHis').'.xlsx';
		}
		\ebi\Util::mkdir(dirname($filename));
		
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($this->spshee);
		$writer->save($filename);
	}
}