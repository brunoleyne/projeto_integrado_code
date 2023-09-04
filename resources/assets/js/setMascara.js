export default class SetMascara{

    constructor() {
        this.telefoneSelector = $( "input.telefone" );
        this.cepSelector = $( "input[name='cep']" );
        this.cpfSelector = $( "input[name='cpf']" );
        this.rgSelector = $( "input[name='rg']" );
        this.dateSelector = $( "input.date" );
        this.moneySelector = $( "input.money" );

        this.setMascara();
    }

    setMascara() {
        let TelefoneMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(TelefoneMaskBehavior.apply({}, arguments), options);
                }
            };

        this.telefoneSelector.mask(TelefoneMaskBehavior, spOptions);
        this.cepSelector.mask("99999-999");
        this.cpfSelector.mask("999.999.999-99");
        this.rgSelector.mask("99.999.999-*");
        this.dateSelector.mask("99/99/9999");
        this.moneySelector.mask('#.##0,00', {reverse: true});
    }
}

window.SetMascara = SetMascara;