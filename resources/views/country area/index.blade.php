@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Divisional area') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item active" aria-current="page">Divisional area</li>
        </ol>
    </nav>
@endsection

@section('statusMessage')
    @include('utility.status messages')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Index') }}</div>

        <div class="card-body p-3">
            <div class="mb-3">
                <a class="btn btn-primary" href="{{ route("country.area.add") }}" role="button">Add</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($countryAreas as $countryareaIndex => $countryarea )
                            <tr>
                                <td>{{ $countryareaIndex+1 }}</td>
                                <td>{{ $countryarea->name_en }} ({{ $countryarea->name_bn }})</td>
                                <td>{{ ($countryarea->parent_id == null) ? "Parent" : $countryarea->parent->name_en."(".$countryarea->parent->name_bn.")" }}</td>
                                <td>
                                    <a href="{{ route("country.area.edit",["id"=>$countryarea->id]) }}" class="btn btn-sm btn-primary"> Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger m-1" data-bs-toggle="modal" data-bs-target="#trash{{$countryarea->id}}ConfirmationModal">
                                        Trash
                                    </button>
                                    <div class="modal fade" id="trash{{$countryarea->id}}ConfirmationModal" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">{{ $countryarea->name }} trash confirmation model</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        <ul>
                                                            <li>CountryArea will be delete.</li>
                                                        </ul>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                                                    <form action="{{ route("country.area.delete",["id" => $countryarea->id]) }}" method="POST">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit" class="btn btn-sm btn-success">Yes,Trash</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    No country area added.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="paginationDiv">
                {{ $countryAreas->links() }}
            </div>
        </div>
    </div>
@endsection
