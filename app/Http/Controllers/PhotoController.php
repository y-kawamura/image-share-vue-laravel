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
        $this->middleware('auth')->except(['index', 'show', 'download']);
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

    public function index()
    {
        $photos = Photo::with(['owner'])
            ->orderBy(Photo::CREATED_AT, 'desc')
            ->paginate();

        return $photos;
    }

    public function download(Photo $photo)
    {
        // Check if photo exists
        if (!Storage::cloud()->exists($photo->filename)) {
            abort(404);
        }

        // header settings for downlaod
        $disposition = 'attachment; filename="' . $photo->filename . '"';
        $header = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => $disposition,
        ];

        return response(Storage::cloud()->get($photo->filename), 200, $header);
    }

    public function show(string $id)
    {
        $photo = Photo::where('id', $id)->with(['owner'])->first();

        return $photo ?? abort(404);
    }
}
