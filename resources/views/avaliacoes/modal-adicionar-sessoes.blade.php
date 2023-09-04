<div class="modal fade" id="modalAdicionarSessoes" role="dialog" aria-labelledby="Adicionar Sessões" aria-hidden="true">
    {!! Form::open(array('route' => 'avaliacoes.adicionar-sessoes','method'=>'POST')) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Sessões</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="hidden" name="avaliacao_id" id="adiciona_sessoes_avaliacao_id">
                        <div class="form-group">
                            <label for="data_avaliacao">Número Sessões</label>
                            {!! Form::number('numero_avaliacoes', null, ['placeholder' => 'Número Sessões','class' => "form-control"])!!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="cns">Data Sessão</label>
                            {!! Form::text('data_sessao', null, ['placeholder' => 'Data Sessão','class' => "date form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="dias_semana">Dias na Semana</label>
                            {!! Form::select('dias_semana[]', [1 => 'Segunda-Feira', 2 => 'Terça-Feira', 3 => 'Quarta-Feira', 4 => 'Quinta-Feira', 5 => 'Sexta-Feira',], null,
                            ['multiple' => 'multiple', 'class' => "select-multiple form-control"])!!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="submit" class="btn btn-primary btn-adicionar-sessoes">Sim</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script type="text/javascript" defer>
    $('#modalAdicionarSessoes select').css('width', '100%');
    $('.select-multiple').select2({
        dropdownParent: $('#modalAdicionarSessoes')
    });
    $('#modalAdicionarSessoes').on('show.bs.modal', function (e) {
        let avaliacaoId = $(e.relatedTarget).data('id');
        $('#adiciona_sessoes_avaliacao_id').val(avaliacaoId)
    });
</script>