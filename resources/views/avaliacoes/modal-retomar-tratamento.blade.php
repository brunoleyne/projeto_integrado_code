<div class="modal fade" id="modalRetomarTratamento" role="dialog" aria-labelledby="Retomar Tratamento" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Retomar Tratamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja retomar o Tratamento deste Paciente?</p>
                <input type="hidden" name="avaliacao_id" id="retomar_paciente_avaliacao_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="submit" class="btn btn-warning" id="retomar-tratamento-action">Sim</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" defer>
    $('#modalRetomarTratamento').on('show.bs.modal', function (e) {
        let avaliacaoId = $(e.relatedTarget).data('id');
        $('#retomar_paciente_avaliacao_id').val(avaliacaoId)
    });


    $("#retomar-tratamento-action").click(function () {
        let avaliacaoId =  $('#retomar_paciente_avaliacao_id').val();
        $.ajax(
            {
                url: "avaliacoes/retomar/tratamento/" + avaliacaoId,
                type: 'get',
                dataType: "JSON",
                success: function (response) {
                    $('#modalRetomarTratamento').modal('hide');
                }
            });
    });
</script>