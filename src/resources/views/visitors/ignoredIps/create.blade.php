@extends('visitors::visitors.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="h4 content-title">{{__('Settings')}}</h4>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{route('visitors.ignored_ip.list')}}" class="btn btn-sm btn-outline-primary">
                    {{__("List")}}
                </a>
            </div>
        </div>
    </div>

    <!-- right column -->
    <div class="col-md-12">
        <!-- general form elements disabled -->
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title content-title">{{__('Ip creating')}}</h5>
            </div>

            <div class="card-body">

                <form role="form" action="{{ route('visitors.ignored_ip.store') }}" method="post">
                    @csrf
                    <div class="row">
                        {{-- IP --}}
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label>{{__('Ip')}}</label>
                                <input name="ip" type="text" class="form-control" value="{{old('ip')}}" required>
                            </div>
                        </div>
                        {{-- EMPTY --}}
                        <div class="col-sm-6 mb-3"></div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-outline-primary mt-3">Add</button>
                </form>
            </div>
        </div>
    </div>

@endsection