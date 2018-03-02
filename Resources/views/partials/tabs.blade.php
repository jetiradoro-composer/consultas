<div class="panel panel-default">
    <div id="Tabs" class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#entity_fields" aria-controls="entity_fields" role="tab" data-toggle="tab">Entity & Fields</a></li>
            <li><a href="#filters" aria-controls="filters" role="tab" data-toggle="tab">Filters</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="entity_fields" >

                {{--ACCIONS--}}

                    <div style="margin-top:15px;" class="col-sm-3">
                        <div class="form-group">
                            <div>
                                <label class="required" for="action">Consulta</label>
                                <div class="select">
                                    <select  @change="setEntity" v-model="filter.entity_master" name="entity" id="action"
                                            class="form-control required select2">
                                        <option v-for="entity of filter.entities" :value="entity">@{{entity.entity}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--fields--}}
                    <div style="margin-top:40px" v-if="filter.entity_master_fields" class="col-sm-9 ">
                        <div class="row">
                            <div style="margin:5px 1px; float:left;" v-for="(field, key) in filter.entity_master_fields" class="" >
                                <label  class="btn btn-sm btn-info" >
                                    <input @click="addFieldSelect(field)" :id="field" type="checkbox">
                                    <label  :for="field" class="ts-label">@{{ key | upper }}</label>
                                </label>
                            </div>

                        </div>
                    </div>





            </div>
            <div class="tab-pane fade" id="filters">
                @include('consultas::partials.filter')
            </div>

        </div>
    </div>
</div>