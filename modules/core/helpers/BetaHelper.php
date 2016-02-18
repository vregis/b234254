<?php

namespace modules\core\helpers;

use Yii;

/**
 * Хелпер для бета теста
 *
 * @property string $urlPattern
 *
 * @author MrArthur
 * @since 1.0.0
 */
class BetaHelper
{
    /**
     * Steam ID разработчиков (чтобы не мешать с бета тестерами)
     *
     * @return array
     */
    public static function getDevUsersSteamId()
    {
        return [
            'MirProst.jorjik' => '76561198082594131',
            'MirProst.Ivan' => '76561198084735964',
            'Валентин' => '76561198083023740',
            'Артур' => '76561198117140879',
            'Кирилл' => '76561198131155136',
            'Костя' => '76561198142506452',
            'Олег' => '76561198130533909',
            'Лешка' => '76561198081412560',
            'Нуб криворукий' => '76561198054081982',
            'RealWeb'=>'76561198013157081'
        ];
    }

    /**
     * Пользователь входит в состав разработчиков
     *
     * @return bool
     */
    public static function getIsDeveloper()
    {
        return true;

//        if (!Yii::$app->user->isGuest
//            && in_array(Yii::$app->user->identity->profile->steam_id, self::getDevUsersSteamId())
//        ) {
//            return true;
//        }
//        return false;
    }
}