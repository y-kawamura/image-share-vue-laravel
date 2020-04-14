<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create photo
     * @param StorePhoto $request
     * @return Illuminate\Http\Response
     */
    public function create(StorePhoto $request)
    {
        $photo = new Photo();

        // filename is random id  
        $extension = $request->photo->extension();
        $photo->filename = $photo->id . '.' . $extension;

        // save file to AWS S3
        Storage::cloud()
            ->putFileAs('', $request->photo, $photo->filename, 'public');

        DB::beginTransaction();

        try {
            Auth::user()->photos()->save($photo);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Storage::cloud()->delete($photo->filename);
            throw $exception;
        }

        return response($photo, 201);
    }
}
