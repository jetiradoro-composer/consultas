{{--botón para añadir nuevo filtro--}}

<div v-if="filter.entity_master" class="row">
    <div v-show="filter.where.length > 0" class="col-sm-2">
        <div class="form-group">
            <label for="">Concatenador</label>
            <select class="form-control" v-model="filter.logical_operator">
                <option value=""></option>
                <option value="AND">AND</option>
                <option value="OR">OR</option>
            </select>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label for="">Select field</label>
            <select class="form-control" v-model="filter.field">
                <option value=""></option>
                <option v-for="(field, key) in filter.entity_master.fields" :value="field">@{{ key }}
                </option>
            </select>
        </div>
    </div>
    <div class="col-sm-1">
        <div class="form-group">
            <label for="">Operator</label>
            <select @change="checkFormValue" class="form-control" v-model="filter.operator">
                <option value=""></option>
                <option value="=">=</option>
                <option value="!=">!=</option>
                <option value=">=">>=</option>
                <option value="<="><=</option>
                <option value="like">contains</option>
                <option value="in">in</option>
                <option value="is null">is null</option>
                <option value="is not null">is not null</option>
                <option value="between dates">between dates</option>
            </select>
        </div>
    </div>
    <div v-show="filter.common_value_visible" class="col-sm-3">
        <div class="form-group">
            <label for="">Value</label>
            <input type="text" class="form-control" v-model="filter.value">
        </div>
    </div>

    <div v-show="filter.dates_value_visible" class="col-sm-6">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">

                    <label for="">Date 1</label>
                    <div class="input-group form-group">
                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                        <input v-model="filter.date1" type="date" class="form-control input-mask " id="Date1" data-mask="00/00/0000"
                               placeholder="eg: 23/05/2014">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">Date 2</label>
                    <div class="input-group form-group">
                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                        <div class="dtp-container">
                            <input v-model="filter.date2" type="date" class="form-control input-mask " id="Date2" data-mask="00/00/0000"
                                   placeholder="eg: 23/05/2014">
                        </div>
                    </div>
                </div>
            </div> {{--end col 6--}}
        </div>
    </div>


    <div class="col-sm-4">
        <span @click="addFilter" style="font-size:1.5em; cursor:pointer">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add Filter
        </span>
    </div>

</div>

<div v-if="filter.where.length > 0">
    <ul>
        <li v-for="(filter, index) in filter.where">@{{ filter.operator +' '+filter.field +' '+ filter.operand +' '+
            filter.value }} <i style="cursor:pointer" @click="removeFilter(index)"
                               class="font-color-red fa fa-trash"></i></li>
    </ul>
</div>