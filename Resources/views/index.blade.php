@extends('consultas::layouts.master')

@section('addCss')
    @parent
    <link rel="stylesheet" href="{{Module::asset('consultas:css/consultas_style.css')}}">
@endsection


@section('content')
    <div id="app">
        <div class="card">
            <div class=" bgm-cyan pd-3">
                <h4 class="font-color-white ml-40">Filtros de búsqueda</h4>
            </div>
            <div class="card-body card-padding">


                @include('consultas::partials.message')

                <form  id="filter-form" class="smart-form" method="post"
                      action="{{route('consultas.set-query',['excel'=>true])}}">
                    {{csrf_field()}}

                    <input type="hidden" name="table" :value="filter.entity_master.table">
                    <input type="hidden" name="select" :value="filter.select">
                    <input type="hidden" name="where" :value=" JSON.stringify(filter.where)">

                    <div class="form-group">
                        <button @click.prevent="sendRequest('#sendForm')" id="sendForm" action="{{route('consultas.set-query',['excel'=>false])}}" type="submit"
                                class="btn btn-primary btn-filter ">Buscar
                        </button>
                        <button type="submit"  class="btn btn-success">Exportar a Excel</button>
                    </div>

                    <div class="row margin-bottom-40">
                        @include('consultas::partials.tabs')
                    </div>
                </form>
            </div>
        </div>

        {{--TABLE RESULTS--}}
        <div v-show="result.status == 'success'" class="card">
            <div class=" bgm-cyan pd-3">
                <h4 class="font-color-white ml-40">(@{{ result.total }}) Resultados de la consulta</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped  table-hover nowrap">
                    <thead>
                    <tr>
                        <th v-for="column in result.headers" >@{{column}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in result.data">
                        <td v-for="value in item">@{{ value }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection

@include('consultas::layouts.partials.vue')
@include('consultas::layouts.partials.forms')


@section('addJs')
    @parent
    <script>
        let $entities = JSON.parse('{!! $entities !!}');
        let $csrf = "{{csrf_token()}}";
        $(function(){
            $('#Tabs a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            })
        });
    </script>

@endsection
