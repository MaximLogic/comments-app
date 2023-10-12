@foreach ($comments as $comment)
    <div class="display-comment" @if($comment->parent_id != null) style="margin-left:30px;" @endif>
        <strong>{{ $comment->username }}</strong> {{$comment->created_at}}<br>
        @if ($comment->homepage_url != null)
            <a href="{{ $comment->homepage_url }}">Home link</a>
        @endif
        <p>{{ $comment->text }}<p>
        <form method="post" action="{{ route('comments.store') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" /><br>
                <input type="text" name="email" class="form-control" placeholder="E-mail" /><br>
                <input type="text" name="text" class="form-control" placeholder="Text" /><br>
                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="Reply" />
            </div>
        </form>
        @include('comments.index', ['comments' => $comment->replies])
    </div>
@endforeach
