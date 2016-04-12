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
                $pos = strpos($attribute, '.');
                if ($pos !== false) {
                    $right = $attribute;
                    while ($pos !== false) {
                        $left = substr($right, 0, $pos);
                        $right = substr($right, ($pos + 1));

                        $pos = strpos($right, '.');
                        $relation = $item->$left;
                    }
                    $row[] = $relation->$right;
                } else {
                    $row[] = $item->$attribute;
                }
            }
            $rows[] = $row;
        };

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
