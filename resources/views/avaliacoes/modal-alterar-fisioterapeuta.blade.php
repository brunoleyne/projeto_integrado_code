<div class="modal fade" id="modalAlterarFisioterapeuta" role="dialog" aria-labelledby="Alterar Fisioterapeuta"
              aria-hidden="true">
    {!! Form::open(array('route' => 'avaliacoes.alterar-fisioterapeuta','method'=>'POST')) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar Fisioterapeuta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <input type="hidden" name="avaliacao_id" id="avaliacao_id">
                    <div class="form-group">
                        <label for="fisioterapeuta_id">Fisioterapeuta</label>
                        {!! Form::select('fisioterapeuta_id', $fisioterapeutaSelect, null, ['class' => "form-control full".($errors->has('fisioterapeuta_id') ? ' is-invalid' : '' )])!!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="submit" class="btn btn-primary btn-alterar-fisioterapeuta">Sim</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script type="text/javascript" defer>
    $('#modalAlterarFisioterapeuta').on('show.bs.modal', function (e) {
        let avaliacaoId = $(e.relatedTarget).data('id');
        $('#avaliacao_id').val(avaliacaoId)
    });
</script>