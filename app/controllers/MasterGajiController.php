<?php

class MasterGajiController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $GajiModel = new GajiModel();
        $gaji = GajiModel::all();
        $success = Session::get('mg01_success');
        $data = array(
            "gaji" => $GajiModel->find(0),
            "gajis" => $gaji,
            "action" => action("MasterGajiController@create"),
            "mg01_success" => $success
        );        
        return View::make('master.m_jenis_gaji', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "jenis" => "required"), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $gaji = new GajiModel();
            $gaji->jenis = Input::get('jenis');
            $gaji->status = Input::get('status') == "Y" ? "Y" : "N";
            $gaji->save();
            Session::flash('mg01_success', 'Data Telah Ditambahkan!');
            return Redirect::to('jenisgaji');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('jenisgaji')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
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
        $GajiModel = new GajiModel();
        $gaji = GajiModel::all();
        $data = array(
            "gaji" => $GajiModel->find($id),
            "gajis" => $gaji,
            "action" => action("MasterGajiController@update", $id)
        );
        return View::make('master.m_jenis_gaji', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        // 1. setting validasi
        $messages = array(
            'required' => 'Inputan <b>Tidak Boleh Kosong</b>!'
        );

        $validator = Validator::make(
                        Input::all(), array(
                    "jenis" => "required"), $messages
        );

        // 2a. jika semua validasi terpenuhi simpan ke database
        if ($validator->passes()) {
            $GajiModel = new GajiModel();
            $gaji = $GajiModel::find($id);
            $gaji->jenis = Input::get('jenis');
            $gaji->status = Input::get('status') == "Y" ? "Y" : "N";
            $gaji->save();
            Session::flash('mg01_success', 'Data Telah Ditambahkan!');
            return Redirect::to('jenisgaji');
        }
        // 2b. jika tidak, kembali ke halaman form registrasi
        else {
            return Redirect::to('jenisgaji')
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $Gaji = GajiModel::find($id);
        $Gaji->delete();
        Session::flash('mg01_success', 'Data Telah Di-hapus!');
        return Redirect::to('jenisgaji');
    }

}