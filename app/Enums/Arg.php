<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * NULL と引数省略を区別するための特別な Enum
 */
enum Arg
{
    /**
     * Repository などで更新系のメソッドの引数のデフォルト値として設置することで
     * Null を入れたいのか，差分更新対象から外すのかを区別する
     */
    case Identity;
}
