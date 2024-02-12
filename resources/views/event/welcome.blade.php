@extends('layouts.structure')

@section('content')

    <script src="{{ URL::asset('theme-assets/js/moment.js') }}"></script>
    <script src="{{ URL::asset('theme-assets/js/Utilities.js') }}"></script>
    <script src="{{ URL::asset('theme-assets/js/moment-jalaali.js') }}"></script>

    <link rel="stylesheet" href="{{ URL::asset('theme-assets/css/bootstrap-material-datetimepicker.css') }}">
    <script src="{{ URL::asset('theme-assets/js/bootstrap-material-datetimepicker.js') }}"></script>

    <script>
        var eventPrefixRoute = '{{ route('event.home') }}' + "/event";
        var launcherPrefixRoute = '{{ route('event.home') }}' + "/launcher";
    </script>

    @include('event.layouts.slider')
    @include('event.layouts.searchbar')
    @include('event.layouts.box', [
        'id' => 'most_seen_events_when_not_filled',
        'title' => 'پر فروش ترین ها',
    ])
    @include('event.layouts.box', ['id' => 'latest_events_when_not_filled', 'title' => 'درزمینه'])
    @include('event.layouts.box', [
        'id' => 'most_like_launchers_when_not_filled',
        'title' => 'بهترین برگزار کننده',
    ])

    @include('sections.top_events_slider', [
        'id' => 'most_seen_events_when_filled',
        'searchKey' => 'seen',
        'key' => 'mostSeenEvent',
        'href' => route('event.category.list', ['orderBy', 'price']),
        'title' => 'پر فروش ترین ها',
        'not_fill_id' => 'most_seen_events_when_not_filled',
    ])

    @include('layouts.banner')

    @include('sections.top_events_slider', [
        'id' => 'latest_events_when_filled',
        'searchKey' => 'createdAt',
        'key' => 'latestEvent',
        'title' => 'درزمینه',
        'not_fill_id' => 'latest_events_when_not_filled',
        'fill_input' => 'eventType',
    ])

    @include('sections.top_launchers_slider', [
        'id' => 'most_like_launchers_when_filled',
        'href' => route('launcher-list', ['orderBy' => 'rate']),
        'api' => route('api.launcher.top'),
        'key' => 'mostLikeLauncher',
        'title' => 'بهترین برگزار کننده',
        'not_fill_id' => 'most_like_launchers_when_not_filled',
    ])

    {{-- @include('sections.top_events_slider', ['id' => 'most_like_launchers_when_filled', 'searchKey' => 'rate', 
        'key' => 'mostLikeLauncher', 'title' => 'بهترین برگزار کننده', 'not_fill_id' => 'most_like_launchers_when_not_filled']) --}}

    @include('layouts.news')

    {{-- @include('sections.top_categories_events') --}}

@stop

@section('footer')
    @include('layouts.faq')
    @parent
@stop

@section('extraJS')
    @parent
    <script src="{{ asset('theme-assets/js/event.js') }}"></script>
    <script src="{{ asset('theme-assets/js/home.js') }}"></script>
@stop
