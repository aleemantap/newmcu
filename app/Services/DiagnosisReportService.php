<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DiagnosisReportService
{
    public function getSummaryReport($limit = 15)
    {
        // Subquery rekomendasi dan icd10
        $subRi = DB::table('recommendations as r')
            ->select('r.id as rid', 'i.id', 'i.code', 'i.name')
            ->join('icd10s as i', 'r.icd10_id', '=', 'i.id');

        // Subquery A: Total semua
        $subDiagnosa = DB::table('diagnoses as d')
            ->select('d.id', 'd.recommendation_id')
            ->joinSub(
                DB::table('mcu as m')
                    ->select('m.id')
                    ->join('vendor_customer as vc', 'm.vendor_customer_id', '=', 'vc.id'),
                'm',
                'd.mcu_id',
                '=',
                'm.id'
            )
            ->where('d.deleted', '0');

        $a = DB::table(DB::raw("({$subDiagnosa->toSql()}) as d"))
            ->mergeBindings($subDiagnosa)
            ->joinSub($subRi, 'ri', 'd.recommendation_id', '=', 'ri.rid')
            ->selectRaw('COUNT(ri.id) as total, ri.id, ri.code, ri.name')
            ->groupBy('ri.id', 'ri.code', 'ri.name');

        // TL (laki-laki)
        $TL = DB::table('diagnoses as d')
            ->select('ri2.code', DB::raw('COUNT(ri2.id) as TL'))
            ->joinSub(
                DB::table('mcu as m')
                    ->select('m.id')
                    ->join('vendor_customer as vc', 'm.vendor_customer_id', '=', 'vc.id')
                    ->where('m.jenis_kelamin', 'L'),
                'm',
                'd.mcu_id',
                '=',
                'm.id'
            )
            ->joinSub($subRi, 'ri2', 'd.recommendation_id', '=', 'ri2.rid')
            ->where('d.deleted', '0')
            ->groupBy('ri2.code');

        // Usia < 30
        $bawah30 = DB::table('diagnoses as d')
            ->select('ri2.code', DB::raw('COUNT(ri2.id) as bawah_tigapuluh'))
            ->joinSub(
                DB::table('mcu as m')
                    ->select('m.id')
                    ->join('vendor_customer as vc', 'm.vendor_customer_id', '=', 'vc.id')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, tgl_input) < 30'),
                'm',
                'd.mcu_id',
                '=',
                'm.id'
            )
            ->joinSub($subRi, 'ri2', 'd.recommendation_id', '=', 'ri2.rid')
            ->where('d.deleted', '0')
            ->groupBy('ri2.code');

        // Usia > 40
        $atas40 = DB::table('diagnoses as d')
            ->select('ri2.code', DB::raw('COUNT(ri2.id) as atas_empatpuluh'))
            ->joinSub(
                DB::table('mcu as m')
                    ->select('m.id')
                    ->join('vendor_customer as vc', 'm.vendor_customer_id', '=', 'vc.id')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, tgl_input) > 40'),
                'm',
                'd.mcu_id',
                '=',
                'm.id'
            )
            ->joinSub($subRi, 'ri2', 'd.recommendation_id', '=', 'ri2.rid')
            ->where('d.deleted', '0')
            ->groupBy('ri2.code');

        // Final query
        return DB::table(DB::raw("({$a->toSql()}) as a"))
            ->mergeBindings($a)
            ->leftJoinSub($TL, 'b', 'b.code', '=', 'a.code')
            ->leftJoinSub($bawah30, 'c', 'c.code', '=', 'a.code')
            ->leftJoinSub($atas40, 'cc', 'cc.code', '=', 'a.code')
            ->selectRaw('
                a.*,
                IFNULL(b.TL, 0) as TL,
                (a.total - IFNULL(b.TL, 0)) as TP,
                IFNULL(c.bawah_tigapuluh, 0) as bawah_tigapuluh,
                IFNULL(cc.atas_empatpuluh, 0) as atas_empatpuluh,
                IFNULL(a.total - (IFNULL(c.bawah_tigapuluh, 0) + IFNULL(cc.atas_empatpuluh, 0)), 0) as tigapuluh_sd_empatpuluh
            ')
            ->orderByDesc('a.total')
            ->limit($limit)
            ->get();
    }
}
?>