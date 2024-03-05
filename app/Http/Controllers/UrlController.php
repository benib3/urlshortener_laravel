<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{

    /**
     * Function that generates a shortened url from a given url
     * @param string $url
     * @return string
     */
    function generateShortenedUrl($url)
    {

        //generate a random string
        $random_string = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
        $random_string = 'http://localhost:8000/' . $random_string;
        //check if the random string already exists in the database
        $url = Url::where('shortened_url', $random_string)->first();

        //if the random string already exists, generate a new one
        if ($url) {
            return $this->generateShortenedUrl($url);
        }

        return $random_string;

    }

    function generateShortendUrlV2($ur)
    {
        //using base58 encoding

    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $urls = Url::select('url', 'shortened_url', 'expiration_date', 'visits')
                        ->where('expiration_date', '>', date('Y-m-d H:i:s'))
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        return view('welcome')->with('urls', $urls);


    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create(Request $request)
    {



        DB::beginTransaction();

        try{
            //validate request

            $this->validate($request, [
                'url' => 'required'
            ]);

            $url = Url::create([
                'url' => $request->url,

                'shortened_url' => $this->generateShortenedUrl($request->url), //function that creates shortenl url from url
                'expiration_date' => date('Y-m-d H:i:s', strtotime('+1 week')) //expiration date is 1 week from now,
            ]);
            $url->save();

            DB::commit();

            return redirect()->back()->with('url_generated', $url->shortened_url);

        }catch(\Exception $e){

            DB::rollBack();
            abort(505);
        }



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Url  $url
     *
     */
    public function show($code)
    {

        //redirect to real url
        $find_url = Url::where('shortened_url', 'http://localhost:8000/' . $code)->first();

        $find_url->update([
            'visits' => $find_url->visits + 1,
            'last_visit' => date('Y-m-d H:i:s')
        ]);

        $find_url->save();

        if ($find_url) {
            return redirect($find_url->url);
        }else {
            abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Url $url)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $url)
    {
        //
    }


}
