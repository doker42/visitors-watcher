@extends('visitors::visitors.dashboard')

@section('dashboard')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{__('Visitors')}}</h1>
        <div class="btn-group me-2">
            <a href="{{route('visitors.visitor.list')}}" class="btn btn-sm btn-outline-primary">
                {{__("List")}}
            </a>
        </div>
    </div>

    @if(count($visitors))
        <div class="table-responsive small">
            <div class="btn-group me-2">
                <form class="d-flex mb-4 me-2 " role="search" method="GET" action="{{ route('visitors.visitor.list') }}">
                    <input name="ip" class="form-control me-2" type="text" placeholder="Search" aria-label="Search by IP ...">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>

            <form method="GET" action="{{ route('visitors.visitor.list') }}" class="mb-4">
                <input type="hidden" name="sort" value="{{ $sortOrder }}">
                <label for="per_page">{{__('Show by:')}} </label>
                <select name="per_page" id="per_page" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                </select>
            </form>

            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">IP</th>
                    <th scope="col">{{__('Location')}}</th>
                    <th scope="col">{{__('Hits')}}</th>
                    <th scope="col">{{__('Details')}}</th>
                    <th scope="col">{{__('Banned')}}</th>
                    <th>
                        <a href="{{ route('visitors.visitor.list', ['sort' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
                            {{__('VisitedDate')}}
                            @if($sortOrder === 'asc')
                                Old
                            @else
                                Fresh
                            @endif
                        </a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($visitors as $visitor)
                    <tr>
                        <td>
                            {{ ($visitors->currentPage() - 1) * $visitors->perPage() + $loop->iteration }}
                        </td>
                        <td>{{$visitor->id}}</td>
                        <td>{{$visitor->ip}}</td>
                        <td>{{$visitor->location}}</td>
                        <td>{{$visitor->hits}}</td>
                        <td>
                            @php($btnClass = $visitor->hasExtraUri() ? 'btn-outline-danger' : 'btn-outline-secondary')
                            <button class="btn {{$btnClass}} btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#visitorModal{{ $visitor->id }}"
                            >
                                {{__('Details')}}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="visitorModal{{ $visitor->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $visitor->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel{{ $visitor->id }}">Visitor Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p><strong>IP:</strong> {{ $visitor->ip }}</p>
                                            <p><strong>Location:</strong> {{ $visitor->location }}</p>
                                            <p><strong>Hits:</strong> {{ $visitor->hits }}</p>
                                            {{--   visitors urls  --}}
                                            @if(count($visitor->urls))
                                            <ul>
                                                @foreach($visitor->urls as $url)
                                                    @php($color = $url->public ? 'green' : 'red')
                                                    <li><p style="color: {{$color}}"><strong>{{$url->method}}</strong> <strong> {{$url->uri}}</strong></p></li>
                                                @endforeach
                                            </ul>
                                            @endif
                                            {{--   visitors agents  --}}
                                            @if(count($visitor->agents))
                                                <ul>
                                                    @foreach($visitor->agents as $agent)
                                                        <li><p>Agent : <strong>{{ \Illuminate\Support\Str::limit($agent->name, 21, '...') }}</strong></p></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
                        </td>
                        @php($banned   = $visitor->banned ? 'banned' : 'active')
                        @php($btnClass = $visitor->banned ? 'btn-secondary' : 'btn-outline-primary')
                        @php($ban      = $visitor->banned ? 0 : 1)
                        <td>
                            <form id="banned_{{$visitor->id}}" action="{{route('visitors.visitor.ban_update', ['id' => $visitor->id, 'ban' => $ban])}}"  method="POST">
                                @csrf
                                <a class="btn {{$btnClass}} btn-sm" title="Update banned" onclick="document.getElementById('banned_{{$visitor->id}}').submit(); return false;">
                                    {{$banned}}
                                </a>
                            </form>
                        </td>
                        <td>{{$visitor->visited_date}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="mt-4">
                {{ $visitors->appends(['sort' => $sortOrder, 'per_page' => $perPage])->links('pagination::bootstrap-5') }}
            </div>

        </div>

    @else

        <h2>{{__('No visitors')}}</h2>

    @endif

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const searchInput = document.getElementById('ip-search');--}}

{{--            let timeout;--}}
{{--            searchInput.addEventListener('input', function () {--}}
{{--                clearTimeout(timeout);--}}

{{--                const query = this.value;--}}
{{--                if (query.length < 2) return;--}}

{{--                timeout = setTimeout(() => {--}}
{{--                    // fetch(`/ip-search?term=${encodeURIComponent(query)}`)--}}
{{--                    fetch(`{{route('admin.ip.search')}}?query=${encodeURIComponent(query)}`,{--}}
{{--                        headers: {--}}
{{--                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),--}}
{{--                            'Accept': 'application/json'--}}
{{--                        }--}}
{{--                    })--}}
{{--                        .then(res => res.json())--}}
{{--                        .then(data => {--}}
{{--                            const list = document.getElementById('autocomplete-list') || createList();--}}

{{--                            list.innerHTML = '';--}}
{{--                            data.forEach(ip => {--}}
{{--                                console.log(ip.ip);--}}
{{--                                const item = document.createElement('div');--}}
{{--                                item.textContent = ip.ip;--}}
{{--                                item.classList.add('autocomplete-item');--}}
{{--                                item.addEventListener('click', () => {--}}
{{--                                    searchInput.value = ip.ip;--}}
{{--                                    list.innerHTML = '';--}}
{{--                                    filterTable(ip);--}}
{{--                                });--}}
{{--                                list.appendChild(item);--}}
{{--                            });--}}
{{--                        });--}}
{{--                }, 300);--}}
{{--            });--}}

{{--            function createList() {--}}
{{--                const list = document.createElement('div');--}}
{{--                list.id = 'autocomplete-list';--}}
{{--                list.className = 'autocomplete-items';--}}
{{--                searchInput.parentNode.appendChild(list);--}}
{{--                return list;--}}
{{--            }--}}

{{--            function filterTable(ip) {--}}
{{--                console.log(ip);--}}
{{--                const rows = document.querySelectorAll('table tbody tr');--}}
{{--                rows.forEach(row => {--}}
{{--                    const ipCell = row.querySelector('td.ip-cell'); // ensure this class is on your IP column--}}
{{--                    if (ipCell && ipCell.textContent.includes(ip)) {--}}
{{--                        row.style.display = '';--}}
{{--                    } else {--}}
{{--                        row.style.display = 'none';--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}

{{--    <style>--}}
{{--        .autocomplete-items {--}}
{{--            position: absolute;--}}
{{--            border: 1px solid #ddd;--}}
{{--            background-color: #fff;--}}
{{--            z-index: 99;--}}
{{--            max-height: 200px;--}}
{{--            overflow-y: auto;--}}
{{--            width: 100%;--}}
{{--        }--}}
{{--        .autocomplete-item {--}}
{{--            padding: 10px;--}}
{{--            cursor: pointer;--}}
{{--        }--}}
{{--        .autocomplete-item:hover {--}}
{{--            background-color: #f0f0f0;--}}
{{--        }--}}
{{--    </style>--}}

@endsection
