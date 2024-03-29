<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{

    private $shortener_methods = [
        'generateShortenedUrl' => 'Random String',
        'generateShortenedUrlV2' => 'Base58 Encoding'
    ];


    /**
     * Function that generates a shortened url from a given url
     * @param string $url
     * @return string
     */

    private $main_url;

    public function __construct()
    {
        $this->main_url = env('APP_URL') ? env('APP_URL') . '/' : 'http://localhost:8000/';
    }
    function generateShortenedUrl($url)
    {

        //generate a random string
        $random_string = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
        $random_string = $this->main_url . $random_string;
        //check if the random string already exists in the database
        $url = Url::where('shortened_url', $random_string)->first();

        //if the random string already exists, generate a new one
        if ($url) {
            return $this->generateShortenedUrl($url);
        }

        return $random_string;

    }

    function generateShortenedUrlV2($url)
    {
        //using base58 encoding
        $base58 = new \StephenHill\Base58();
        $encoded = $base58->encode($url);

        $url_encoded = $this->main_url . $encoded;

        $url = Url::where('shortened_url', $encoded)->first();

        //if the random string already exists, generate a new one
        if ($url) {
            return $this->generateShortenedUrlV2($url);
        }
        error_log($url_encoded);
        return $url_encoded;
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
                        ->paginate(5);

        return view('welcome')->with(['urls' => $urls, 'shortener_methods' => $this->shortener_methods]);


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
            $selectedShortener = $request->input('shorteners');
            $shortner_function = array_search(
                $selectedShortener,
                $this->shortener_methods
            );
            $this->validate($request, [
                'url' => 'required',
            ]);



            $url = Url::create([
                'url' => $request->url,
                'shortened_url' => $this->$shortner_function($request->url), //function that creates shortenl url from url
                'expiration_date' => date('Y-m-d H:i:s', strtotime('+1 week')) //expiration date is 1 week from now,
            ]);


            $url->save();

            DB::commit();

            return redirect()->back()->with('url_generated', $url->shortened_url);

        }catch(\Exception $e){
            DB::rollBack();
            //determening the error if its from validation or from the database
            if (strpos($e->getMessage(), 'SQLSTATE') !== false) {
                error_log('Database error');
                return redirect()->back()->with('error', 'Server error.');
            }else {
                error_log('Validation error');
                return redirect()->back()->with('error', 'Invalid url.');
            }



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
        $find_url = Url::where('shortened_url', $this->main_url . $code)->first();

        if ($find_url) {

            $find_url->update([
                'visits' => $find_url->visits + 1,
                'last_visit' => date('Y-m-d H:i:s')
            ]);

            $find_url->save();

            return redirect($find_url->url);
        } else {
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
