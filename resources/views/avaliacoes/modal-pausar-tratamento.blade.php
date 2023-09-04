<div class="modal fade" id="modalPausarTratamento" role="dialog" aria-labelledby="Pausar Tratamento" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pausar Tratamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja pausar o Tratamento deste Paciente?</p>
                <input type="hidden" name="avaliacao_id" id="pausa_paciente_avaliacao_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="submit" class="btn btn-warning" id="pausar-tratamento-action">Sim</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" defer>
    $('#modalPausarTratamento').on('show.bs.modal', function (e) {
        let avaliacaoId = $(e.relatedTarget).data('id');
        $('#pausa_paciente_avaliacao_id').val(avaliacaoId)
    });


    $("#pausar-tratamento-action").click(function () {
        let avaliacaoId =  $('#pausa_paciente_avaliacao_id').val();
        $.ajax(
            {
                url: "avaliacoes/pausar/tratamento/" + avaliacaoId,
                type: 'get',
                dataType: "JSON",
                success: function (response) {
                    $('#modalPausarTratamento').modal('hide');
                }
            });
    });
</script>