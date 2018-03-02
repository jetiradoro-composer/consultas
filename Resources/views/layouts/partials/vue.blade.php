@section('addJs')
    @parent
    <script src="{{ asset(env('APP_DEBUG') == true ? 'js/vue.js' : 'js/vue.min.js') }}"></script>
    <script src="{{Module::asset('consultas:vue/app.js')}}"></script>
@endsection