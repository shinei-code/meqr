<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Insurance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $classes = [
        'hospital' => [
            'model' => Hospital::class,
            'name' => '医療機関'
        ],
        'insurance' => [
            'model' => Insurance::class,
            'name' => '保険者'
        ],
        'code' => [
            'model' => Code::class,
            'name' => 'コードマスタ'
        ],
        'user' => [
            'model' => User::class,
            'name' => '職員'
        ],

    ];

    /**
     * @param string $fileName
     * @return string[]
     */
    protected function csvResponseHeader($fileName)
    {
        return array(
            'Content-Type'        => 'application/octet-stream',
//            'Content-Disposition' => 'attachment; filename*=UTF-8\'\''.rawurlencode($fileName)
            'Content-Disposition' => 'attachment; filename="'.rawurlencode($fileName).'"',
        );
    }

    /**
     * CSV出力データ作成（配列から）
     * @param $items
     * @return string
     */
    protected function csvBody($items)
    {
        $stream = fopen('php://temp', 'r+b');
        foreach ($items as $item) {
            fputcsv($stream, $item, ",", '"');
        }
        rewind($stream);
        $bom = chr(255) . chr(254);
        $csv = stream_get_contents($stream);
        $pattern = "/(^|\t)((0|０)[0-9０-９]+)(\t|$)/i";
        $replacement = '${1}="${2}"${4}';
        $csv =preg_replace($pattern, $replacement, $csv);
        $csv = $bom . mb_convert_encoding($csv, 'UTF-16LE', 'UTF-8');

        return $csv;
    }

    /**
     * CSVダウンロード
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View\
     */
    public function export_csv(Request $request)
    {
        try {
            $receptions = $this->repository->findAll($request);
            $data = [];
            $data[] = array_keys($receptions[0]->getAttributes());
            foreach ($receptions as $reception) {
                $data[] = $reception->toCSVArray();
            }

            $headers = $this->getCsvFileName();
            $csv = $this->csvBody($data);
            \DB::commit();
        } catch (\PDOException $e) {
            \DB::rollBack();

            throw new \ErrorException('エラーが発生しました。');
        }
        return \Response::make($csv, 200, $headers);
    }

    /**
     * @return string[]
     */
    protected function getCsvFileName()
    {
        return $this->csvResponseHeader('一覧-'.$this->classes[$this->type]['name'].'-' . Carbon::now()->format('YmdHim') . '.csv');
    }

}
