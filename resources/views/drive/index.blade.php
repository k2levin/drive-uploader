@extends('master.master')

@section('content')
    <div class="row">
        <div class="col-md-10">

        </div>
        <div class="col-md-2">
            <a href="{{ route('upload', $file_lists['parent_id']) }}"
                class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Upload to this folder">Upload</a>
        </div>
    </div>

    <br />

    <table class="table">
        <thead>
            <tr>
                <th class="pull-right">#</th>
                <th>Name</th>
                <th class="text-center">Setting</th>
            </tr>
        </thead>
        <tbody>
            <?php $table_id = 1; ?>
            @if (isset($file_lists['folders']))
                @foreach ($file_lists['folders'] as $key => $file_list)
                <tr>
                    <td class="pull-right">{{ $table_id }}</td>
                    <td>
                        <a href="{{ route('list_files.folder', $file_list['id']) }}">
                            <img src="{{ $file_list['iconLink'] }}" alt="icon" /> {{ $file_list['title'] }}
                        </a>
                    </td>
                    <td class="text-center">
                        @if ($file_list['shared'] === false)
                        <a href="{{ route('enable_public', $file_list['id']) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Anyone with the link can view">
                            <i class="fa fa-eye"></i>
                        </a>
                        @else
                        <a href="{{ route('disable_public', $file_list['id']) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Disable anyone with the link can view">
                            <i class="fa fa-eye-slash"></i>
                        </a>
                        @endif
                        <a href="{{ route('delete', $file_list['id']) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Permenantly Delete">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                </tr>
                <?php $table_id++; ?>
                @endforeach
            @endif

            @if (isset($file_lists['files']))
                @foreach ($file_lists['files'] as $key => $file_list)
                    <tr>
                        <td class="pull-right">{{ $table_id }}</td>
                        <td>
                            <a href="https://docs.google.com/uc?id={{ $file_list['id'] }}&export=download" target="_blank">
                                <img src="{{ $file_list['iconLink'] }}" alt="icon" /> {{ $file_list['title'] }}
                            </a>
                        </td>
                        <td class="text-center">
                            @if ($file_list['shared'] === false)
                            <a href="{{ route('enable_public', $file_list['id']) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Anyone with the link can view">
                                <i class="fa fa-eye"></i>
                            </a>
                            @else
                            <a href="{{ route('disable_public', $file_list['id']) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Disable anyone with the link can view">
                                <i class="fa fa-eye-slash"></i>
                            </a>
                            @endif
                            <a href="{{ route('delete', $file_list['id']) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Permenantly Delete">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $table_id++; ?>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
