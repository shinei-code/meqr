<?php

namespace Database\Seeders;

use App\Models\Code;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodesFromCsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 外部キー制約が有る場合のチェックを無視
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('codes')->truncate();

        // docker/mysql/コードマスタ(CSV).csvはコンテナと同期していないので、下記パスに事前にファイルを用意しておく
        $file = new \SplFileObject('./database/seeders/csv/codes.csv');
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $list = [];
        foreach($file as $line) {
            $list[] = [
//                "id" => $line[0],
                "category" => $line[1],
                "key" => $line[2],
                "value" => $line[3],
                "sub_value" => $line[4],
                "display_order" => $line[5],
                "is_not_display" => $line[6],
                "created_at" => date('Y-m-d H:i:s', strtotime((empty($line[7]) ? now() : $line[7]))),
                "updated_at" => date('Y-m-d H:i:s', strtotime((empty($line[8]) ? now() : $line[8]))),
            ];
        }

        DB::table("codes")->insert($list);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}


