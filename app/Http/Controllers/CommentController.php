<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreRequest;
use Intervention\Image\Facades\Image;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::where('parent_id', '=', null)->get()->reverse();

        return view('index', ['comments' => $comments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $path = '';
        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            $filename = time() . $file->getClientOriginalName();
            if($file->extension() == 'txt')
            {
                $path = 'storage/' . $file->storeAs('commentFiles/txt', $filename);
            }
            else
            {
                $path = 'storage/' . $file->storeAs('commentFiles/img', $filename);
                $image_resize = Image::make($file->getRealPath());
                $width = $image_resize->width();
                $height = $image_resize->height();
                if($width > 320 || $height > 240)
                {
                    $widthRatio = $width / 320;
                    $heightRatio = $width / 240;
                    $width = (int) ($width / max($widthRatio, $heightRatio));
                    $height = (int) ($height / max($widthRatio, $heightRatio));

                    $image_resize->resize($width, $height);
                    $image_resize->save(public_path('storage/commentFiles/img/' . $filename));
                }
            }
        }
        $data['file_uri'] = $path;
        unset($data['file']);
        $comment = Comment::create($data);
        return redirect()->route('comments.index');
    }
}
