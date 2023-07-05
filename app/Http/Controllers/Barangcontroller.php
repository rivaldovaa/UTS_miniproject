<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Barangcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'List Barang';

        $barang = Barang::all();

        return view('barang.index', [
            'pageTitle' => $pageTitle,
            'barang' => $barang
            
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Input Data Barang';
        $units = Unit::all();
        return view('barang.create', compact('pageTitle','units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'numeric' => 'Isi :Attribute dengan angka',
            'unique'=>':Attribute sudah ada'
        ];
        $validator = Validator::make($request->all(), [
            'kodeBarang' => 'required|unique:list,kode_barang',
            'namaBarang' => 'required',
            'harga' => 'required|numeric',
            'deskripsiBarang' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // ELOQUENT
        $barang = new Barang;
        $barang->kode_barang=$request->kodeBarang;
        $barang->nama_barang = $request->namaBarang;
        $barang->price = $request->harga;
        $barang->description = $request->deskripsiBarang;
        $barang->unit_id = $request->satuan;
        $barang->save();
        return redirect()->route('barang.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = ' Detail Barang';
        // ELOQUENT
        $barang = Barang::find($id);
        return view('barang.show', compact('pageTitle', 'barang',));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Barang';
        // ELOQUENT
        $units = Unit::all();
        $barang = Barang::find($id);
        return view(
            'barang.edit',
            compact(
                'pageTitle',
                'units',
                'barang'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'numeric' => 'Isi :attribute dengan angka',
            'unique'=>':Attribute sudah ada'
        ];
        $validator = Validator::make($request->all(), [
            'kodeBarang' => 'required|unique:list,kode_barang,' .$id,
            'namaBarang' => 'required',
            'harga' => 'required|numeric',
            'deskripsiBarang' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // ELOQUENT
        $barang = Barang::find($id);
        $barang->kode_barang = $request->kodeBarang;
        $barang->nama_barang = $request->namaBarang;
        $barang->price = $request->harga;
        $barang->description = $request->deskripsiBarang;
        $barang->unit_id = $request->satuan;
        $barang->save();
        return redirect()->route('barang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Barang::find($id)->delete();
        return redirect()->route('barang.index');
    }
}