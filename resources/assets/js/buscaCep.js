export default class BuscaCep {

    constructor() {
        this.enderecoSelector = $( "input[name='logradouro']" );
        this.bairroSelector = $( "input[name='bairro']" );
        this.municipioSelector = $( "input[name='municipio']" );
        this.cepSelector = $( "input[name='cep']" );
        this.estadoSelector = $( "input[name='estado']" );

        this.bindCEP();
    }

    cleanCEP() {
        this.enderecoSelector.val("");
        this.bairroSelector.val("");
        this.municipioSelector.val("");
        this.estadoSelector.val("");
    }

    bindCEP() {
        var that = this;
        this.cepSelector.blur(function() {
            var cep = $(this).val().replace(/\D/g, '');

            if (cep != "") {
                var validacep = /^[0-9]{8}$/;
                if(validacep.test(cep)) {

                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                        if (!("erro" in dados)) {
                            that.municipioSelector.val(dados.localidade);
                            that.estadoSelector.val(dados.uf);
                            that.bairroSelector.val(dados.bairro);
                            that.enderecoSelector.val(dados.logradouro);
                        }
                        else {
                            that.cleanCEP();
                            alert("CEP não encontrado.");
                        }
                    });
                }
                else {
                    this.cleanCEP();
                    alert("Formato de CEP inválido.");
                }
            }
            else {
                this.cleanCEP();
            }
        });
    }
}

window.BuscaCep = BuscaCep;