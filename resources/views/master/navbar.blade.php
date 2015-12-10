<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">Drive</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                @if (strpos(Route::currentRouteName(),'home') !== false)
                <li class="active">
                @else
                <li>
                @endif
                    <a href="{{ route('home') }}">Home</a>
                </li>
                @if (strpos(Route::currentRouteName(),'list_files') !== false)
                <li class="active">
                @else
                <li>
                @endif
                    <a href="{{ route('list_files') }}">List Folders / Files</a>
                </li>
                @if (strpos(Route::currentRouteName(),'about') !== false)
                <li class="active">
                @else
                <li>
                @endif
                    <a href="{{ route('about') }}">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
