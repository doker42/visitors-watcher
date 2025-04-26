@extends('visitors::visitors.layout')

@section('dashboard')
    <h3>Visitors Dashboard</h3>
@endsection


@push('scripts')
    <script>

        {{--document.addEventListener("DOMContentLoaded", function () {--}}
        {{--    const dropdownItems = document.getElementById("dropdownItems");--}}
        {{--    axios.get("{{route('admin_item_types_data')}}")--}}
        {{--        .then(response => {--}}
        {{--            dropdownItems.innerHTML = ""; // Clear previous items--}}
        {{--            response.data.itemTypes.forEach(type => {--}}
        {{--                const li = document.createElement("li");--}}
        {{--                li.innerHTML = `<a class="dropdown-item" href="#">${type.title}</a>`;--}}
        {{--                dropdownItems.appendChild(li);--}}
        {{--            });--}}
        {{--        })--}}
        {{--        // .then(response => {--}}
        {{--        //     console.log(response.data.itemTypes); // Handle the response data--}}
        {{--        // })--}}
        {{--        .catch(error => {--}}
        {{--            console.error("Error fetching data:", error);--}}
        {{--            dropdownItems.innerHTML = '<li><span class="dropdown-item text-danger">Error loading data</span></li>';--}}
        {{--        });--}}
        {{--});--}}

    </script>
@endpush
