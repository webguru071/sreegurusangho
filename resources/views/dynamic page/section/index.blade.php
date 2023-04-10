@extends('layouts.auth app')

@section('pageTitle')
    {{ __('Dynamic page section') }}
@endsection

@section('navBreadCrumb')
    <nav aria-label="breadcrumb" class="ms-3">
        <ol class="breadcrumb m-1 mb-2">
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("dynamic.page.index") }}">Page ({{ $dynamicPage->name }})</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route("dynamic.page.section.index",["id" =>$dynamicPage->id]) }}">Section</a></li>
            <li class="breadcrumb-item active" aria-current="page">Index</li>
        </ol>
    </nav>
@endsection

@section('statusMessage')
    @include('utility.status messages')
@endsection

@section('content')
    @php
        $allowAddSection = 1;
        if( $dynamicPage->template == "BoardOfDirectorsOfVariousBranches" ){
            if($dynamicPage->sections->count() == 2){
                $allowAddSection = 0;
            }
        }

        if( $dynamicPage->template == "VariousBranchesForBoardOfDirectors" ){
            if($dynamicPage->sections->count() == 1){
                $allowAddSection = 0;
            }
        }

        if( $dynamicPage->template == "GoverningCouncil" ){
            if($dynamicPage->sections->count() == 1){
                $allowAddSection = 0;
            }
        }


        if( $dynamicPage->template == "GoverningCouncil" ){
            if($dynamicPage->sections->count() == 2){
                $allowAddSection = 0;
            }
        }

        if( $dynamicPage->template == "AshramAndMondir" ){
            if($dynamicPage->sections->count() == 1){
                $allowAddSection = 0;
            }
        }

        if( $dynamicPage->template == "Event" ){
            if($dynamicPage->sections->count() == 1){
                $allowAddSection = 0;
            }
        }
    @endphp
    <div class="card">
        <div class="card-header">{{ __('Index') }}</div>

        <div class="card-body p-3">
            <div class="mb-3">
                @if( $allowAddSection == 1 )
                    <a class="btn btn-primary" href="{{ route("dynamic.page.section.add",["id"=>$dynamicPage->id]) }}" role="button">Add</a>
                @endif

            </div>

            <div class="m-3">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dynamicPageSections as $pageIndex => $page )
                                <tr>
                                    <td>{{ $pageIndex+1 }}</td>
                                    <td>{{ $page->name_en }} ({{ $page->name_bn }})</td>
                                    <td>
                                        <a href="{{ route("dynamic.page.section.edit",["id"=>$dynamicPage->id,"sid"=>$page->id]) }}" class="btn btn-sm btn-primary m-1"> Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger m-1" data-bs-toggle="modal" data-bs-target="#trash{{$page->id}}ConfirmationModal">
                                            Trash
                                        </button>
                                        <div class="modal fade" id="trash{{$page->id}}ConfirmationModal" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">{{ $page->name }} trash confirmation model</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            <ul>
                                                                <li>Page will be delete.</li>
                                                            </ul>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                                                        <form action="{{ route("dynamic.page.section.delete",["id"=>$dynamicPage->id,"sid"=>$page->id]) }}" method="POST">
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
                                    <td colspan="3">
                                        No page added.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div id="dynamicPagePaginationDiv">
                    {{ $dynamicPageSections->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
