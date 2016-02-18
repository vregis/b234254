<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 13.01.2016
 * Time: 15:33
 */

namespace modules\core\site\profile;

use modules\core\ajaxModel\DynamicData;
use modules\departments\models\Department;
use modules\departments\models\Specialization;
use modules\tasks\models\Task;
use modules\user\models\Skilllist;
use modules\user\models\UserSpecialization;
use Yii;

class EducationData extends DynamicData
{
    public $main_class = 'education';
    public $main_title = 'Education';
    public $main_content = '';
    public $main_model = '\modules\user\models\Education';

    public $data_block_view = 'blocks/education_row_block';
}