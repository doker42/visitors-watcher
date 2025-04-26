@extends('visitors::visitors.dashboard')

@section('dashboard')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{__('Ignored Ips')}}</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{route('visitors.ignored_ip.create')}}" class="btn btn-sm btn-outline-primary">
                    {{__("Add ip")}}
                </a>
            </div>
        </div>
    </div>

    @php($num = 1)
    @if(count($ignoredIps))
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">{{__('IP')}}</th>
                    <th scope="col">{{__('Created')}}</th>
                    <th scope="col">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ignoredIps as $ip)
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{$ip->id}}</td>
                        <td>{{$ip->ip}}</td>
                        <td>{{$ip->created_at->format('d-m-Y')}}</td>
                        <td>
                            <form action="{{ route('visitors.ignored_ip.destroy', $ip->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-secondary btn-sm">
                                    <svg class="bi"><use xlink:href="#trash"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @php($num++)
                @endforeach
                </tbody>
            </table>
        </div>

    @else
        <h2>{{__('No ignoredIps')}}</h2>
    @endif

    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Prevent form submission
            if (confirm("Are you sure you want to delete this item?")) {
                event.target.submit(); // Submit form if user confirms
            }
        }
    </script>

@endsection
