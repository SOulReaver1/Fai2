<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Base,
    \App\Liste,
    \App\Destinataire;

class BaseController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('destinataires.bases.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Base::create([
              'name' => $request->get('name')
        ]);
        return redirect() ->back()->with('success', 'Your base as been create successfully!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $base_id = Base::where('name', $id)->get('id')->toArray()[0]['id'];

        $list_id = Liste::where('base_id', $base_id)->get('id')->toArray()[0]['id'];

        Base::where('name', $id)->delete();

        Liste::where('base_id', $base_id)->delete();

        Destinataire::where('list_id', $list_id)->delete();

        return redirect('/destinataire');
    }
    public function export()
    {
        $bases = \App\Base::all();
        $fais = \App\Fais::all();
        return view('destinataires/bases.export', ['bases' => $bases, 'fais' => $fais]);
    }

    public function sendExport(Request $request){
        $data = json_decode($request->getContent(), true);

        if($data["baseName"]){
          // echo "<pre>";
          // echo var_dump($request->get("base"));
          // echo "</pre>";
          // exit;
          if ($data["baseBlacklistEnabled"]) {
            $banEmail = [];
            return true;
            $result = Destinataire::where('list_id', $data["baseName"])->whereNotIn('email', Destinataire::where('list_id', 2)->pluck('email')->toArray())->pluck('email');;
            $result = ['banBase', $result];
            return json_encode($result);
          }
          if ($request->get("banFAI")) {

          } else {
            $result = Destinataire::where('list_id', $data["baseName"])->pluck('email');
            $result = ['direct', $result];
            return json_encode($result);
          }
        }
        return redirect() ->back()->with('success', 'Your base as been create successfully!');
    }
}
