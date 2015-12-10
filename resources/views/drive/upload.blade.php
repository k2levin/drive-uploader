@extends('master.master')

@section('content')
    <h1>Upload</h1>

    <hr />

    <form class="form-horizontal" action="{{ route('post.upload', $folder_id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name: </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="name" id="name" placeholder="Use original file name if leave this field blank">
            </div>
        </div>

        <div class="form-group">
            <label for="file" class="col-sm-2 control-label">File: </label>
            <div class="col-sm-10">
                <input type="file" id="file" name="file">
            </div>
        </div>

        <br />

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
@endsection
