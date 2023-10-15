@vite(['resources/sass/app.scss', 'resources/js/app.js'])
<div class="w-50" style="margin: auto; margin-top: 2%">
    <h1>Leave comment</h1>
    <form method="post" action={{ route('comments.store') }} enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" />
            @error('username')
                <span style="color: red">Please, type valid username</span>
            @enderror
            <br>
            <input type="text" name="email" class="form-control" placeholder="E-mail" />
            @error('email')
                <span style="color: red">Please, type valid email</span>
            @enderror
            <br>
            <input type="text" name="homepage_url" class="form-control" placeholder="Home page url" /><br>
            <input type="file" name="file" class="form-control" />
            @error('file')
                <span style="color: red">2 MB max, .jpg, .png, .gif, .txt only</span>
            @enderror
            <br>
            <textarea name="text" class="form-control" placeholder="Text"></textarea>
            @error('text')
                <span style="color: red">Please, type your comment</span>
            @enderror
            <br>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Comment" />
        </div>
    </form>

    <button class="btn btn-outline-secondary" onclick="changeSortOrder()">Sort order</button>
    <button class="btn btn-outline-secondary" onclick="changeSortBy('username')">Sort by Username</button>
    <button class="btn btn-outline-secondary" onclick="changeSortBy('email')">Sort by E-mail</button>
    <button class="btn btn-outline-secondary" onclick="changeSortBy('created_at')">Sort by Date</button>

    @include('comments.index', ['comments' => $comments])
</div>
<script>
    function showReplyForm(id) {
        form = document.getElementById(id);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
    function changeSortOrder(){
        let url = new URL(window.location.href);
        let searchParams = url.searchParams;
        if(searchParams.has('orderasc'))
        {
            if(searchParams.get('orderasc') === 'asc')
            {
                searchParams.set('orderasc', 'desc');
            }
            else
            {
                searchParams.set('orderasc', 'asc');
            }
        }
        else
        {
            searchParams.append('orderasc', 'asc');
        }
        url.search = searchParams.toString();
        window.location.href = url.toString();

    }

    function changeSortBy(param)
    {
        let url = new URL(window.location.href);
        let searchParams = url.searchParams;
        if(searchParams.has('orderby'))
        {
           searchParams.set('orderby', param);
        }
        else
        {
            searchParams.append('orderby', param);
        }
        url.search = searchParams.toString();
        window.location.href = url.toString();
    }
</script>
