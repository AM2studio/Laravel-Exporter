<?php 

namespace AM2Studio\Laravel\Exporter;

trait Exporter
{
    
    public function exportOneSheet(\Illuminate\Pagination\LengthAwarePaginator $collection, array $columns, $title, $filename, $format = 'xls', $creator = '', $company = '')
    {
        $rows   = [];
        $rows[] = array_values($columns);
        foreach ($columns as $attribute => $title) {
                if (strpos($attribute, '.') !== false) {
                    $relations = explode('.', $attribute);
                    $object = $item;
                    foreach($relations as $relation) {
                        $object = $object->$relation;
                    }
                    $row[] = $object;
                } else {
                    $row[] = $item->$attribute;
                }
            }

        return \Maatwebsite\Excel\Facades\Excel::create($filename, function ($excel) use ($rows, $title, $creator, $company) {
            $excel->setTitle($title);
            $excel->setCreator($creator)->setCompany($company);
            $excel->sheet($title, function ($sheet) use ($rows) {
                $sheet->fromArray($rows, null, 'A1', false, false);
            });
        })->download($format);
    }

    public function exportMoreSheets($headings, $model, $config)
    {
        exit('not implemented');
    }
	
    
}
