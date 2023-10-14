@foreach ($comments as $comment)
    <div class="display-comment" @if($comment->parent_id != null) style="margin-left:30px;" @endif>
        <div style="background-color:#e1e2e3; padding:1%; margin-top:2%">
            <strong>{{ $comment->username }}</strong>
            ({{$comment->email}})
            {{$comment->created_at}}
            @if ($comment->homepage_url != null)
                <a href={{ $comment->homepage_url }}>Home link</a>
            @endif
        </div>
        <div style="padding: 1%; overflow-wrap: break-word;">{!! $comment->text !!}</div>
        @php($arr=explode('.', $comment->file_uri))
        @php($filename=explode('/', $comment->file_uri))
        <div style="padding:1%;">
            @switch($arr[count($arr) - 1])
                @case('jpg')
                    <img src={{$comment->file_uri}}>
                    @break
                @case('jpeg')
                    <img src={{$comment->file_uri}}>
                    @break
                @case('png')
                    <img src={{$comment->file_uri}}>
                    @break
                @case('gif')
                    <img src={{$comment->file_uri}}>
                    @break
                @case('txt')
                    Added file: <a href={{$comment->file_uri}} download>{{$filename[count($filename) - 1]}}</a>
            @endswitch
        </div>
        <a onclick="showReplyForm({{$comment->id}})" href="javascript:void(0);" style="padding: 1%;">Reply</a>
        <form method="post" action={{ route('comments.store') }} style="display: none; margin-top: 2%" id={{$comment->id}} enctype="multipart/form-data">
            @csrf
            <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" />
            @error('username')
                <span style="color: red">Please, type your username</span>
            @enderror<br>
            <input type="text" name="email" class="form-control" placeholder="E-mail" />
            @error('email')
                <span style="color: red">Please, type your email</span>
            @enderror<br>
            <input type="text" name="homepage_url" class="form-control" placeholder="Home page url" /><br>
            <input type="file" name="file" class="form-control" />
            @error('file')
                <span style="color: red">2 MB max, .jpg, .png, .gif, .txt only</span>
            @enderror<br>
            <textarea name="text" class="form-control" placeholder="Text"></textarea>
            @error('text')
                <span style="color: red">Please, type your comment</span>
            @enderror<br>
            <input type="hidden" name="parent_id" value={{ $comment->id }} />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-warning" value="Comment" />
        </div>
        </form>
        @include('comments.index', ['comments' => $comment->replies])
    </div>
@endforeach
