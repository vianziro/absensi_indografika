<?php

class TransaksiTabunganController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        User::loginCheck([0,1]);
        
        $success = Session::get('tt01_success');
        $tt01 = new tt01();
        $data = array(
            "karyawans" => mk01::where("status", "=", "Y")->get(),
            "tabungans" => $tt01->getTabungan(),
            "tt01_success" => $success
        );
        return View::make('transaksi.trans_tabungan', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!',
            'numeric' => 'Inputan <b>Harus Angka</b>!',
            'same' => 'Password <b>Tidak Sama</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "niltb" => "required|numeric"
                        ), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $niltb = Input::get("niltb");
            $idkar = Input::get("idkar");
            $tt01 = new tt01();
            $idtb = $tt01->getAutoIncrement();

            $tt01->nortb = "TB" . $idtb . date("m") . date("y");
            $tt01->tgltb = date("Y-m-d");
            $tt01->niltb = $niltb;
            $tt01->idkar = $idkar;
            $tt01->save();

            $mk01 = mk01::find($idkar);
            $mk01->tbsld = $mk01->tbsld + $niltb;
            $mk01->save();

            Session::flash('tt01_success', 'Data Telah Ditambahkan!');
            return Redirect::to('inputdata/tabungan');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('inputdata/tabungan')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $tt01 = tt01::find($id);
        $idkar = $tt01->idkar;
        $niltb = $tt01->niltb;

        $tt01->delete();

        $mk01 = mk01::find($idkar);
        $mk01->tbsld = $mk01->tbsld - $niltb;
        $mk01->save();

        Session::flash('tt01_success', 'Data Telah DiHapus!');
        return Redirect::to('inputdata/tabungan');
    }

}
