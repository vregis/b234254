<div class="modal fade" style="border-radius: 20px">
    <div class="modal-dialog" style="border-radius: 20px">
        <div class="modal-content">
            <div class="modal-header" style="min-height: 50px;">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span><span
                        class="sr-only"><?= Yii::t('core', 'Закрыть') ?></span></button>
            </div>
            <div class="modal-body" style="text-align:center">
                <h3><?= Yii::t('core', 'Вы уверены что хотите очистить кеш?') ?></h3>
            </div>
            <div style="width: 100%;text-align: center;margin-bottom: 20px;">
                <div class="progress" style="width:80%;display:none;margin: 0 auto;">
                    <div class="progress-bar progress-bar-striped active" style="width: 100%;margin: 0 auto;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="Clean.do()"><i
                        class="glyphicon glyphicon-fire"></i> <?= Yii::t('core', 'Очистить кеш') ?>
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="Clean.refresh()">Отмена
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->