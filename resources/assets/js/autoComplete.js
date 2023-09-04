class autoComplete {
    static paciente() {
        $("select[name='paciente_id']").select2({
            language: "pt-BR",
            placeholder: "Selecione o Paciente",
            theme: 'bootstrap4',
            minimumInputLength: 3,
            ajax: {
                url: '/autocomplete/pacientes',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    }

    static medico() {
        $( "select[name='medico_id']" ).select2({
            language: "pt-BR",
            placeholder: "Selecione o Médico",
            theme: 'bootstrap4',
            minimumInputLength: 3,
            ajax: {
                url: '/autocomplete/medicos',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    }

    static fisioterapeuta() {
        $( "select[name='fisioterapeuta_id']" ).select2({
            language: "pt-BR",
            placeholder: "Selecione o Fisioterapeuta",
            theme: 'bootstrap4',
            minimumInputLength: 3,
            ajax: {
                url: '/autocomplete/fisioterapeutas',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    }
}

$(document).ready(function () {
    autoComplete.paciente();
    autoComplete.medico();
    autoComplete.fisioterapeuta();
});