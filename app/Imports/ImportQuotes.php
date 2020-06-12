<?php

namespace App\Imports;

use App\Quote;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportQuotes implements ToModel
{
    /**
     * @param array $row
     *
     * @return Quote
     */
    public function model(array $row)
    {
        return new Quote([
            'text'     => @$row[0],
            'author'    => @$row[1],
            'active'    => @$row[2]
        ]);
    }
}
