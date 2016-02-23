<?php
/**
 * gredu_labs
 * 
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

return [
    'schools' => [
        'file_upload' => [
            'tmp_path'    => 'data/tmp',
            'target_path' => 'data/uploads',
    'acl' => [
        'guards'   => [
            'routes'    => [
                ['/school', ['school'], ['get']],
                ['/school/labs', ['school'], ['get', 'post']],
                ['/school/staff', ['school'], ['get', 'post', 'delete']],
                ['/school/assets', ['school'], ['get', 'post', 'delete']],
                ['/school/software', ['school'], ['get', 'post', 'delete']],
            ],
        ],
    ],
];
