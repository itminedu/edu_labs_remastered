<?php

use GrEduLabs\Schools\InputFilter\School as SchoolInputFilter;
use GrEduLabs\Schools\Service\SchoolServiceInterface;
use SchMM\FetchUnit;
use SchSync\Middleware\CreateSchool;
use SchSync\Middleware\CreateUser;
use Slim\App;
/**
 * gredu_labs.
 * 
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 *
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

return function (App $app) {

    $container = $app->getContainer();
    $events    = $container['events'];

    $events('on', 'app.autoload', function ($stop, $autoloader) {
        $autoloader->addPsr4('SchSync\\', __DIR__ . '/src');
    });

    $events('on', 'app.services', function ($stop, $container) {
        $container[CreateUser::class] = function ($c) {
            return new CreateUser(
                $c->get('authentication_service'),
                $c->get('router')->pathFor('user.login'),
                $c->get('router')->pathFor('user.logout.sso'),
                $c->get('flash'),
                $c->get('logger')
            );
        };
        $container[CreateSchool::class] = function ($c) {
            return new CreateSchool(
                $c->get('ldap'),
                $c->get(FetchUnit::class),
                $c->get('authentication_service'),
                $c->get(SchoolServiceInterface::class),
                $c->get(SchoolInputFilter::class),
                $c->get('router')->pathFor('user.login'),
                $c->get('router')->pathFor('user.logout.sso'),
                $c->get('flash'),
                $c->get('logger')
            );
        };
    });

    $events('on', 'app.bootstrap', function ($stop, $app, $container) {
        foreach ($container->get('router')->getRoutes() as $route) {
            if ('user.login.sso' === $route->getName()) {
                $route->add(CreateUser::class)
                    ->add(CreateSchool::class);
                break;
            }
        }
    }, -10);
};