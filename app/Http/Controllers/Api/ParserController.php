<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->admin===1){
            return Parser::latest()->paginate(20);
        }
        return Parser::where('user_id',Auth::user()->id)->latest()->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'url'=>'required',
            'title'=>'required',
            'text'=>'required',
        ]);
        $request->request->add(['user_id'=>auth('api')->user()->id]);
        return Parser::create($request->except('id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $parser = Parser::find($id);
        return $parser->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Parser::destroy($id);
    }

    public function countparser(){
        return response()->json([
            'countall' => Parser::where('user_id',Auth::user()->id)->count(),
            'countactiv' => Parser::where('user_id',Auth::user()->id)->where('status',1)->count(),
        ]);
    }
}
