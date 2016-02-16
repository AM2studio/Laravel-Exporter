<?php 

namespace AM2Studio\Laravel\Exporter;

trait Exporter
{
    
    public function exportOneSheet(\Illuminate\Database\Eloquent\Collection $collection, array $columns, $title, $filename, $format = 'xls', $creator = '', $company = '')
    {
        $rows   = [];
        $rows[] = array_values($columns);
        foreach ($collection as $item) {
            $row = [];
            foreach ($columns as $attribute => $title) {
                $row[] = $item->$attribute;
            }
            $rows[] = $row;
        };

        return Excel::create($filename, function ($excel) use ($rows, $title, $creator, $company) {
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