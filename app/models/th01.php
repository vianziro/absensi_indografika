<?php

class th01 extends Eloquent {

    protected $table = 'th01';
    protected $primaryKey = 'idhut';

    function mk01() {
        return $this->belongsTo("mk01");
    }

    function getAutoIncrement() {
        $sql = "SELECT AUTO_INCREMENT as idth FROM information_schema.tables WHERE TABLE_SCHEMA = 'absensi' AND TABLE_NAME = 'th01'";
        $th01 = DB::select(DB::raw($sql));
        $th01 = $th01[0];
        return $th01->idth;
    }

    function getHutangBlmLunas() {
        $sql = "SELECT th01.*, mk01.nama FROM th01 INNER JOIN mk01 ON mk01.idkar = th01.idkar WHERE th01.flglns = 'N';";
        $th01 = DB::select(DB::raw($sql));
        return $th01;
    }

    function getHutang($idhut) {
        $sql = "SELECT th01.*, mk01.nama FROM th01 INNER JOIN mk01 ON mk01.idkar = th01.idkar WHERE th01.idhut = $idhut;";
        $th01 = DB::select(DB::raw($sql));
        return $th01;
    }

    function getDetailHutang($idhut) {
        $sql = "SELECT * FROM th02 WHERE th02.idhut = $idhut;";
        $th02 = DB::select(DB::raw($sql));
        return $th02;
    }

    function getHutangBulan($idkar, $date) {
        $sql = "SELECT * FROM th02 INNER JOIN th01 ON th01.idhut = th02.idhut WHERE MONTH(th02.tglph) = " . date("n", strtotime($date)) . " AND YEAR(th02.tglph) = " . date("Y", strtotime($date)) . " AND th01.jenhut = 'Hutang' AND th01.idkar = $idkar;";
        $th02 = DB::select(DB::raw($sql));
        return $th02;
    }

    function getKasBonBulan($idkar, $date) {
        $sql = "SELECT * FROM th02 INNER JOIN th01 ON th01.idhut = th02.idhut WHERE MONTH(th02.tglph) = " . date("n", strtotime($date)) . " AND YEAR(th02.tglph) = " . date("Y", strtotime($date)) . " AND th01.jenhut = 'Kas Bon' AND th01.idkar = $idkar;";
        $th02 = DB::select(DB::raw($sql));
        return $th02;
    }

    function checkAktifHutang($idkar) {
        $sql = "SELECT COUNT(idhut) as c_idhut FROM th01 WHERE idkar = $idkar AND flglns = 'N';";
        $th02 = DB::select(DB::raw($sql));
        $th02 = $th02[0]->c_idhut;
        return $th02;
    }

    function getLatestHutang($idkar) {
        $sql = "SELECT COUNT(tglhut), tglhut FROM th01 WHERE idkar = $idkar ORDER BY tglhut DESC LIMIT 1;";
        $th01 = DB::select(DB::raw($sql));
        return $th01;
    }

}
