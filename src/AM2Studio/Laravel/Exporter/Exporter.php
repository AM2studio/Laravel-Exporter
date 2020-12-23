<?php


namespace AM2Studio\Laravel\Exporter;

trait Exporter
{
    public function exportOneSheet($collection, array $columns, $title, $filename, $format = 'xls', $creator = '', $company = '')
    {
        $rows = [];
        $rows[] = array_values($columns);
        foreach ($collection as $item) {
            $row = [];
            foreach ($columns as $attribute => $title) {
                $itemTmp = clone $item;
                $relations = explode("." , $attribute);
                
                foreach($relations as $relation){
                    $relationData = explode('(' , rtrim($relation, ')'));
                    
                    if($itemTmp == null){
                        $itemTmp = '';
                    }elseif(isset($relationData[1])){
                        $relation = $relationData[0];
                        $param    = $relationData[1];
                        $itemTmp  = $itemTmp->$relation($param);
                    }else{
                        $itemTmp = $itemTmp->$relation;
                    }
                }
                
                $row[] = (string) $itemTmp;
            }
            $rows[] = $row;
        };

        return \Maatwebsite\Excel\Facades\Excel::create($filename, function ($excel) use ($rows, $title, $creator, $company) {
            $excel->setTitle($title);
            $excel->setCreator($creator)->setCompany($company);
            $excel->sheet($title, function ($sheet) use ($rows) {
                $sheet->fromArray($rows, null, 'A1', true, false);
                for ($i = 1; $i <= count($rows); $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(15);
                }
            });
        })->download($format);
    }

    public function exportMoreSheets($headings, $model, $config)
    {
        exit('not implemented');
    }
}
