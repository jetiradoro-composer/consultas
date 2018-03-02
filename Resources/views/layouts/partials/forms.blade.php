
@section('addJs')
    @parent
    <script src="{{Module::asset('consultas:js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
    <script src="{{Module::asset('consultas:plugins/datepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{Module::asset('consultas:plugins/jquery_mask/jquery.mask.js')}}"></script>
@endsection
@section('addCss')
    @parent
    <link rel="stylesheet" href="{{Module::asset('consultas:plugins/datepicker/css/bootstrap-datetimepicker.min.css')}}">
@endsection