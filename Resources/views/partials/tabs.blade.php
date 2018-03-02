<div class="card-body card-padding">
    <div class="form-wizard-basic fw-container">
        <ul class="tab-nav text-center">
            <li><a href="#entity_fields" data-toggle="tab" aria-expanded="true">Entity & Fields</a></li>
            <li><a href="#filters" data-toggle="tab">Filters</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade" id="entity_fields" >

                {{--ACCIONS--}}
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div>
                                <label class="required" for="action">Consulta</label>
                                <div class="select">
                                    <select  @change="setEntity" v-model="filter.entity_master" name="entity" id="action"
                                            class="form-control required select2">
                                        <option value="0"></option>
                                        <option v-for="entity of filter.entities" :value="entity">@{{entity.entity}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--fields--}}
                    <div v-if="filter.entity_master_fields" class="col-sm-9 ">
                        <div class="row">
                            <div v-for="(field, key) in filter.entity_master_fields" class="col-sm-4 m-b-20">
                                <div  class="toggle-switch" data-ts-color="cyan">
                                    <input @click="addFieldSelect(field)" :id="field" type="checkbox" hidden="hidden">
                                    <label :for="field" class="ts-helper"></label>
                                    <label style="margin-left:10px" :for="field" class="ts-label">@{{ key }}</label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>



            </div>
            <div class="tab-pane fade" id="filters">
                @include('consultas::partials.filter')
            </div>


            <ul class="fw-footer pagination wizard">
                <li class="previous first"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>
                <li class="previous"><a class="a-prevent" href=""><i class="zmdi zmdi-chevron-left"></i></a></li>
                <li class="next"><a class="a-prevent" href=""><i class="zmdi zmdi-chevron-right"></i></a></li>
                <li class="next last"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>
            </ul>
        </div>
    </div>
</div>