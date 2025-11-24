<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
enum Section: string
{
    case HOME_BANNER = 'home_banner';
    case HOME_HOW_IT_WORKS = 'home_how_it_works';
    case JOURNAL_BANNER = 'journal_banner';
    case JOURNAL_HOW_IT_WORKS = 'journal_how_it_works';
    case FASHION_BANNER = 'fashion_banner';
    case FASHION_HOW_IT_WORKS = 'fashion_how_it_works';

}
