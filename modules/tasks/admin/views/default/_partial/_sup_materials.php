<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 11.11.2015
 * Time: 17:52
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile("/metronic/theme/assets/global/plugins/dropzone/dropzone.min.css");

$this->registerJsFile("/metronic/theme/assets/global/plugins/dropzone/dropzone.min.js");
$this->registerJsFile("/js/global/form-dropzone.js");

$this->registerJsFile("/js/global/table-editable.js");


$id = $task->id;
$id_drop_zone = $id;
if(isset($temp_id)) {
    $id = $temp_id;
    $id_drop_zone = 'temp/'.$id;
}
$initJs = <<<JS
    FormDropzone.init('$id_drop_zone');
    TableEditable.init('$id', 'video');
    TableEditable.init('$id', 'link');
    TableEditable.init('$id', 'note');
JS;

$this->registerJs($initJs);
?>

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box blue">
    <div class="portlet-title">
        <ul class="nav nav-tabs pull-left">
            <li class="active">
                <a href="#tab_audios" data-toggle="tab">
                    Audios </a>
            </li>
            <li>
                <a href="#tab_photos" data-toggle="tab">
                    Photos </a>
            </li>
            <li>
                <a href="#tab_archives" data-toggle="tab">
                    Archives </a>
            </li>
            <li>
                <a href="#tab_documents" data-toggle="tab">
                    Documents </a>
            </li>
            <li>
                <a href="#tab_videos" data-toggle="tab">
                    Videos </a>
            </li>
            <li>
                <a href="#tab_links" data-toggle="tab">
                    Links </a>
            </li>
            <li>
                <a href="#tab_notes" data-toggle="tab">
                    Notes </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_audios">
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'dropzone-audio',
                        'options' => [
                            'class' => 'dropzone'
                        ],
                        'action' => 'upload_audio'
                    ]
                ) ?>
                <input type="text" name="id" value="<?= $id_drop_zone ?>" hidden>
                <?php ActiveForm::end() ?>
            </div>
            <div class="tab-pane" id="tab_photos">
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'dropzone-photo',
                        'options' => [
                            'class' => 'dropzone'
                        ],
                        'action' => 'upload_photo'
                    ]
                ) ?>
                <input type="text" name="id" value="<?= $id_drop_zone ?>" hidden>
                <?php ActiveForm::end() ?>
            </div>
            <div class="tab-pane" id="tab_archives">
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'dropzone-archive',
                        'options' => [
                            'class' => 'dropzone'
                        ],
                        'action' => 'upload_archive'
                    ]
                ) ?>
                <input type="text" name="id" value="<?= $id_drop_zone ?>" hidden>
                <?php ActiveForm::end() ?>
            </div>
            <div class="tab-pane" id="tab_documents">
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'dropzone-document',
                        'options' => [
                            'class' => 'dropzone'
                        ],
                        'action' => 'upload_document'
                    ]
                ) ?>
                <input type="text" name="id" value="<?= $id_drop_zone ?>" hidden>
                <?php ActiveForm::end() ?>
            </div>
            <div class="tab-pane" id="tab_videos">
                <button id="video_editable_new" class="btn green">
                    Add New <i class="fa fa-plus"></i>
                </button>
                <table class="table table-striped table-hover table-bordered" id="video_editable">
                    <thead>
                    <tr>
                        <th class="no-sort" width="80%">
                            Video url
                        </th>
                        <th class="no-sort">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach($task_videos as $task_video) : ?>
                        <tr>
                            <td class="editable-field" width="80%">
                                <a href="<?= $task_video->name ?>" onclick="return !window.open(this.href)"><?= $task_video->name ?></a>
                            </td>
                            <td>
                                <a class="btn default btn-xs purple edit"><i class="fa fa-edit"></i> Edit </a><a class="btn btn-danger btn-xs black delete"><i class="fa fa-trash-o"></i> Delete </a>
                            </td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tab_links">

                <button id="link_editable_new" class="btn green">
                    Add New <i class="fa fa-plus"></i>
                </button>
                <table class="table table-striped table-hover table-bordered" id="link_editable">
                    <thead>
                    <tr>
                        <th class="no-sort" width="80%">
                            Links
                        </th>
                        <th class="no-sort">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach($task_links as $task_link) : ?>
                        <tr>
                            <td class="editable-field" width="80%">
                                <a href="<?= $task_link->name ?>" onclick="return !window.open(this.href)"><?= $task_link->name ?></a>
                            </td>
                            <td>
                                <a class="btn default btn-xs purple edit"><i class="fa fa-edit"></i> Edit </a><a class="btn btn-danger btn-xs black delete"><i class="fa fa-trash-o"></i> Delete </a>
                            </td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>

            </div>
            <div class="tab-pane" id="tab_notes">

                <button id="link_editable_new" class="btn green">
                    Add New <i class="fa fa-plus"></i>
                </button>
                <table class="table table-striped table-hover table-bordered" id="link_editable">
                    <thead>
                    <tr>
                        <th class="no-sort" width="80%">
                            Links
                        </th>
                        <th class="no-sort">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach($task_links as $task_link) : ?>
                        <tr>
                            <td class="editable-field" width="80%">
                                <a href="<?= $task_link->name ?>"><?= $task_link->name ?></a>
                            </td>
                            <td>
                                <a class="btn default btn-xs purple edit"><i class="fa fa-edit"></i> Edit </a><a class="btn btn-danger btn-xs black delete"><i class="fa fa-trash-o"></i> Delete </a>
                            </td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>