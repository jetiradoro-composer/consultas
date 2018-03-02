@section('addJs')
    @parent
    <script src="{{Module::asset('consultas:vue/vue.min.js')}}"></script>
    <script src="{{Module::asset('consultas:vue/app.js')}}"></script>
@endsection