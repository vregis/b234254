<?

namespace modules\core\admin\controllers;

use modules\core\admin\base\Controller;
use Yii;
use modules\user\models\User;
use modules\core\models\CoreScenario;
use yii\helpers\Url;
use modules\core\actions\DataTable;

/**
 * Дефолтный контроллер админки
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DefaultController extends Controller
{
    public $layout = 'main';
    /** @inheritdoc */
    public function behaviors()
    {
        // разрешаем гостям и юзерам видеть страницу ошибки
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['error'],
            'roles' => ['?', '@']
        ];
        return $behaviors;
    }

    /** @inheritdoc */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'data-table' => [
                'class' => DataTable::className()
            ],
        ];
    }


    /**
     * Главная страница бэкенда
     *
     * @return string
     */
    public function actionIndex()
    {
        $messages = [];
        // проверяем зависимости модулей
      //  $messages['dependencies'] = $this->module->checkDependencies();

        $scenarios = CoreScenario::find()->all();

        return $this->render(
            'index',
            [
                'scenarios' => $scenarios,
            ]
        );
    }

    public function actionCreate() {

        $scenario = new CoreScenario();
        if ($scenario->load(Yii::$app->request->post())) {
            if($scenario->save()) {
                return $this->redirect(Url::toRoute('/core'));
            }
        }

        return $this->render('form',[
                'scenario' => $scenario,
                'is_create' => true
            ]);
    }
    public function actionUpdate($id) {

        $scenario = CoreScenario::findOne(['id' => $id]);
        if ($scenario->load(Yii::$app->request->post())) {
            if($scenario->save()) {
                return $this->redirect(Url::toRoute('/core'));
            }
        }

        return $this->render('form',[
                'scenario' => $scenario,
                'is_create' => false
            ]);
    }
    public function actionDelete($id) {

        $scenario = CoreScenario::findOne(['id' => $id]);
        $scenario->delete();

        return $this->redirect(Url::toRoute('/core'));
    }
}