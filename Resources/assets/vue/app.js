let vm = new Vue({
    el: '#app',
    data: {
        filter: {
            entities: $entities,
            entity_master: false,
            entity_master_fields: null,
            add_new: false,
            operator: null,
            value: null,
            date1: null, //model de dates per al formulari
            date2: null, //model de dates per al formulari
            field: null,
            where: [],
            select: [],
            logical_operator: null,
            common_value_visible: true, //comproba que el camp de filtre estándar sigui visible
            dates_value_visible: false, //controla si els camps de filtre de dates son visibles
        },
        message: {
            type: 'danger',
            text: [],
            visible: false
        },

        result: {
            headers: [],
            data: null,
            status: '',
            total: 0,
            query: '',
        }
    },
    methods: {
        /**
         * Afegeix un nou filtre al constructor del WHERE
         */
        addFilter: function () {
            //treiem els espais en blanc als costats del value

            let val = this.filter.value;

            if(val != null) val= val.trim();


            switch (this.filter.operator) {
                case 'like' :
                    val = "%" + val + "%";
                    break;
                case 'is null' :
                case 'is not null':
                    val = 'null';
                    break;
                case 'between dates':
                    val = this.filter.date1+'||'+this.filter.date2;
                    break;
            }

            if (this.filter.field && this.filter.operator && val) {
                if(val=='null'){ val = ''}

                let filter = {
                    field: this.filter.field,
                    operand: this.filter.operator,
                    value: val
                };
                if (this.filter.where.length == 0) {
                    filter.operator = 'WHERE ';
                } else {
                    filter.operator = ' ' + this.filter.logical_operator;
                }

                this.filter.where.push(filter);
                this.filter.value = null;
                this.filter.operator = null;
                this.filter.fields = null;
                this.filter.field = null;
                this.filter.date1 = '';
                this.filter.date2 = '';
                this.showFormValue();
            }

        },

        checkFormValue: function(){
            switch(this.filter.operator){
                case 'is null':
                case 'is not null':
                    this.hideFormValue();
                break;
                case 'between dates':
                    this.showFormDates();

                    break;
                default: this.showFormValue();
            }
        },

        hideFormValue: function () {
            this.filter.common_value_visible = false;
            this.filter.dates_value_visible = false;
        },
        showFormValue: function () {
            this.filter.common_value_visible = true;
            this.filter.dates_value_visible = false;
        },

        showFormDates: function () {
            this.filter.common_value_visible = false;
            this.filter.dates_value_visible = true;
            $(".datepicker").datetimepicker({
                format:'DD/MM/YYYY',
                locale:'ca',

            });


            $(".input-mask").mask('00/00/0000');

        },


        removeFilter: function (index) {
            this.filter.where.splice(index, 1);
        },

        /**
         * Affegeix o treu una columna del SELECT
         * @param field
         */
        addFieldSelect: function (field) {
            let index = this.filter.select.indexOf(field);
            if (index > -1) {
                this.filter.select.splice(index, 1);
            } else {
                this.filter.select.push(field);
            }

        },

        /**
         * recupera les dades de la consulta
         * Envia la consulta per ajax
         * Mostra el resultat per pantalla
         */
        sendRequest: function (e) {
            if (this.checkRequest()) {

                let url = $(e).attr('action');

                // defineixo els camps per passar per post al controlador de la API
                let params = {
                    'table': this.filter.entity_master.table,
                    'select': this.filter.select,
                    'where': this.filter.where
                };

                vm.showLoading();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: params,
                    success: function (data) {
                        if (data.status == 'success') {
                            // consulta amb dades correctes
                            // console.log(data);
                            vm.result.total = data.message.length;
                            vm.result.headers = vm.filter.select;
                            vm.result.status = data.status;
                            vm.result.data = data.message;
                            vm.result.query = data.query;
                            vm.hideLoading();
                        } else {
                            // error en la consulta però amb estat 200 al ajax
                            // console.log(data);
                            vm.resetFilterSelect();
                            vm.showMessage('danger', [data.message]);
                            vm.hideLoading();
                        }
                    },
                    // error a la consulta, ajax error
                    error: function (data) {
                        // console.log(data);
                        vm.resetFilterSelect();
                        vm.showMessage('danger', [data.message]);
                        vm.hideLoading();
                    },
                });
            }

        },

        /**
         * Buida la informació de resultats per fer una nova consulta
         */
        resetFilterSelect: function () {
            vm.result.status = null;
            vm.result.headers = [];
            vm.result.total = 0;
            vm.result.data = null;
        },

        /**
         * Comprobacions a passar abans de llençar la consulta a la API
         * @returns {boolean}
         */
        checkRequest: function () {
            let errors = false;
            let text = [];

            if (this.filter.entity_master == false) {
                errors = true;
                text.push("Selecciona una entitat obligatòriament");
            }
            if (this.filter.select.length == 0) {
                errors = true;
                text.push("Has de seleccionar les columnes que vols mostrar");
            }

            if (errors == false) {
                return true;
            } else {
                this.showMessage('danger', text);
                return false;
            }

        },

        checkRequestExcel: function () {
            if (this.checkRequest()) {
                $('form').submit();
            }
        },

        /**
         * Carrega la informació de la entitat seleccionada
         */
        setEntity: function () {
            this.resetData();
            this.filter.entity_master_fields = this.filter.entity_master.fields;
            //borrar los checks
            $('input[type="checkbox"]').removeAttr('checked');

        },

        /**
         * Buida tot el formulari
         */
        resetData: function () {
            this.filter.entity_master_fields = null;
            this.filter.add_new = false;
            this.filter.operator = null;
            this.filter.value = null;
            this.filter.field = null;
            this.filter.date1 = '';
            this.filter.date2 = '';
            this.filter.where = [];
            this.filter.select = [];
            this.filter.logical_operator = null;
        },

        /**
         * Carrega missatge a mostrar en cas d'error
         * @param status
         * @param msg
         * @returns {boolean}
         */
        showMessage(status, msg) {
            vm.message.text = [];
            msg.forEach(function (text) {
                vm.message.text.push(text);
            });
            this.message.visible = true;
            setTimeout(function () {
                // $(".AlertMsg").slideUp('slow');
                // delay(1000);
                vm.message.visible = false
            }, 5000);
            return false;
        },

        /**
         * Carrega el gif loading
         */
        showLoading: function () {

            block = $("<div>");
            block.attr("id", "loader");
            block.addClass("hidden");
            img = $("<img>");
            img.attr("src", "/modules/consultas/img/ajax-loader.gif");
            block.append(img);
            $("body").append(block);
            block.removeClass("hidden");
        },

        hideLoading: function () {
            $('body #loader').remove();
        },

    }
});

