@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-2">
        <a href="{{ route('createproject') }}" type="button" class="btn btn-primary ml-3">
            Nový projekt
        </button></a>
    </div>
    <div class="row mt-1">
        <div class="col-md-12">
                @if(count($projects) > 0)
                <ul class="list-group m-0">
                    @foreach ($projects as $project)
                    <li class="list-group-item">
                        <span><a href="#">{{ $project->title }}</a> - {{ str_limit($project->description, $limit = 100, $end = '...') }}</span>
                        <span class="float-right text-muted">{{ date('d.m.Y', strtotime($project->updated_at)) }}</span>
                    </li>
                    @endforeach
                </ul>
                {{ $projects->links() }}
            @else
                <p>Nemáte žádný projekt.</p>
            @endif
        </div>
    </div>
</div>
@endsection
