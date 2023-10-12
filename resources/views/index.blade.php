<h1>Leave comment</h1>
<form method="post" action="{{ route('comments.store') }}">
    @csrf
    <div class="form-group">
        <input type="text" name="username" class="form-control" placeholder="Username" /><br>
        <input type="text" name="email" class="form-control" placeholder="E-mail" /><br>
        <input type="text" name="text" class="form-control" placeholder="Text" /><br>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-warning" value="Comment" />
    </div>
</form>
@include('comments.index', ['comments' => $comments])
