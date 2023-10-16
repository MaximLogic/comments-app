<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreRequest;
use Intervention\Image\Facades\Image;
use DOMDocument;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderBy = request()->orderby;
        $orderAsc = request()->orderasc;
        $comments = Comment::where('parent_id', '=', null);
        if(in_array($orderBy, ['username', 'email', 'created_at']))
        {
            if($orderAsc == 'desc')
            {
                $comments = $comments->orderByDesc($orderBy)->get();
            }
            else
            {
                $comments = $comments->orderBy($orderBy)->get();
            }
        }
        else if($orderAsc == 'asc')
        {
            $comments = $comments->orderBy('created_at')->get();
        }
        else
        {
            $comments = $comments->orderByDesc('created_at')->get();
        }

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
            $filename = time() . str_replace(' ', '_', $file->getClientOriginalName());
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

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadXML($data['text']);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        if(empty($errors))
        {
            $data['text'] = strip_tags($data['text'], '<a href title><code><i><strong>');
        }
        else
        {
            $data['text'] = strip_tags($data['text'], '');
        }

        $comment = Comment::create($data);
        return redirect()->route('comments.index');
    }
}
