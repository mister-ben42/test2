<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appTestDebugProjectContainerUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appTestDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        if (0 === strpos($pathinfo, '/qu')) {
            if (0 === strpos($pathinfo, '/question')) {
                // mdqquestion_ajouterQ
                if ($pathinfo === '/question/ajouterQ') {
                    return array (  '_controller' => 'MDQ\\QuestionBundle\\Controller\\QuestionController::ajouterQAction',  '_route' => 'mdqquestion_ajouterQ',);
                }

                // mdqquestion_modifQaval
                if (0 === strpos($pathinfo, '/question/modifQaval') && preg_match('#^/question/modifQaval/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqquestion_modifQaval')), array (  '_controller' => 'MDQ\\QuestionBundle\\Controller\\QuestionController::modifQavalAction',));
                }

                // mdqquestion_adaptForm
                if ($pathinfo === '/question/adaptForm') {
                    return array (  '_controller' => 'MDQ\\QuestionBundle\\Controller\\QuestionController::adaptFormAction',  '_route' => 'mdqquestion_adaptForm',);
                }

                // mdqquestion_signalError
                if ($pathinfo === '/question/signalError') {
                    return array (  '_controller' => 'MDQ\\QuestionBundle\\Controller\\QuestionController::signalErrorAction',  '_route' => 'mdqquestion_signalError',);
                }

            }

            if (0 === strpos($pathinfo, '/quizz')) {
                // mdqquizz_preGame
                if (0 === strpos($pathinfo, '/quizz/preGame') && preg_match('#^/quizz/preGame/(?P<game>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqquizz_preGame')), array (  '_controller' => 'MDQ\\QuizzBundle\\Controller\\QuizzController::preGameAction',));
                }

                // mdqquizz_accueil
                if (0 === strpos($pathinfo, '/quizz/accueil') && preg_match('#^/quizz/accueil/(?P<game>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqquizz_accueil')), array (  '_controller' => 'MDQ\\QuizzBundle\\Controller\\QuizzController::newGameAction',));
                }

                // mdqquizz_jeu
                if (0 === strpos($pathinfo, '/quizz/jeu') && preg_match('#^/quizz/jeu/(?P<game>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqquizz_jeu')), array (  '_controller' => 'MDQ\\QuizzBundle\\Controller\\QuizzController::jeuQuizzAction',));
                }

                // mdqquizz_editQuestion
                if ($pathinfo === '/quizz/editQuestion') {
                    return array (  '_controller' => 'MDQ\\QuizzBundle\\Controller\\QuizzController::editQuestionAction',  '_route' => 'mdqquizz_editQuestion',);
                }

                // mdqquizz_verifReponse
                if ($pathinfo === '/quizz/verifReponse') {
                    return array (  '_controller' => 'MDQ\\QuizzBundle\\Controller\\QuizzController::verifReponseAction',  '_route' => 'mdqquizz_verifReponse',);
                }

                // mdqquizz_finPartie
                if ($pathinfo === '/quizz/finPartie') {
                    return array (  '_controller' => 'MDQ\\QuizzBundle\\Controller\\QuizzController::finPartieAction',  '_route' => 'mdqquizz_finPartie',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/user/profileU')) {
            // mdquser_profileU
            if (preg_match('#^/user/profileU/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdquser_profileU')), array (  '_controller' => 'MDQ\\UserBundle\\Controller\\UserController::profileUAction',));
            }

            if (0 === strpos($pathinfo, '/user/profileUAuto')) {
                // mdquser_profileUAuto
                if ($pathinfo === '/user/profileUAuto') {
                    return array (  '_controller' => 'MDQ\\UserBundle\\Controller\\UserController::profileUAutoAction',  '_route' => 'mdquser_profileUAuto',);
                }

                // mdquser_profileUAutoEdit
                if ($pathinfo === '/user/profileUAutoEdit') {
                    return array (  '_controller' => 'MDQ\\UserBundle\\Controller\\UserController::profileUAutoEditAction',  '_route' => 'mdquser_profileUAutoEdit',);
                }

            }

            // mdquser_profileUPassword
            if ($pathinfo === '/user/profileUPassword') {
                return array (  '_controller' => 'MDQ\\UserBundle\\Controller\\UserController::profileUPasswordAction',  '_route' => 'mdquser_profileUPassword',);
            }

        }

        // mdqgene_accueil
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'mdqgene_accueil');
            }

            return array (  '_controller' => 'MDQ\\GeneBundle\\Controller\\GeneController::accueilAction',  '_route' => 'mdqgene_accueil',);
        }

        if (0 === strpos($pathinfo, '/accueil')) {
            // mdqgene_accueilJeu
            if ($pathinfo === '/accueilJeu') {
                return array (  '_controller' => 'MDQ\\GeneBundle\\Controller\\GeneController::accueilJeuAction',  '_route' => 'mdqgene_accueilJeu',);
            }

            // mdqgene_accueilHighScore
            if ($pathinfo === '/accueilHighScore') {
                return array (  '_controller' => 'MDQ\\GeneBundle\\Controller\\GeneController::accueilHighScoreAction',  '_route' => 'mdqgene_accueilHighScore',);
            }

        }

        // mdqgene_highScore
        if (0 === strpos($pathinfo, '/highScore') && preg_match('#^/highScore(?:/(?P<crit>[^/]++)(?:/(?P<page>[^/]++)(?:/(?P<id>[^/]++))?)?)?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqgene_highScore')), array (  '_controller' => 'MDQ\\GeneBundle\\Controller\\GeneController::highScoreAction',  'crit' => 'none',  'page' => 1,  'id' => 0,));
        }

        // mdqgene_regleJeu
        if ($pathinfo === '/regleJeu') {
            return array (  '_controller' => 'MDQ\\GeneBundle\\Controller\\GeneController::regleJeuAction',  '_route' => 'mdqgene_regleJeu',);
        }

        // mdqgene_news
        if ($pathinfo === '/news') {
            return array (  '_controller' => 'MDQ\\GeneBundle\\Controller\\GeneController::afficheNewsAction',  '_route' => 'mdqgene_news',);
        }

        if (0 === strpos($pathinfo, '/admin')) {
            // mdqadmin_accueilAdmin
            if (rtrim($pathinfo, '/') === '/admin') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'mdqadmin_accueilAdmin');
                }

                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::accueilAdminAction',  '_route' => 'mdqadmin_accueilAdmin',);
            }

            // mdqadmin_profileUAdmin
            if (0 === strpos($pathinfo, '/admin/profileUAdmin') && preg_match('#^/admin/profileUAdmin/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqadmin_profileUAdmin')), array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::profileUAdminAction',));
            }

            // mdqadmin_voirU
            if (0 === strpos($pathinfo, '/admin/voirU') && preg_match('#^/admin/voirU/(?P<type>[^/]++)/(?P<compte>[^/]++)/(?P<sexe>[^/]++)/(?P<departement>[^/]++)/(?P<age>[^/]++)/(?P<last_login>[^/]++)/(?P<role>[^/]++)/(?P<nbP>[^/]++)/(?P<triUser>[^/]++)/(?P<triStats>[^/]++)/(?P<sens>[^/]++)/(?P<nbdeU>[^/]++)/(?P<nbmin>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqadmin_voirU')), array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::voirUAction',));
            }

            // mdqadmin_critvoirU
            if ($pathinfo === '/admin/critvoirU') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::critvoirUAction',  '_route' => 'mdqadmin_critvoirU',);
            }

            // mdqadmin_newNews
            if ($pathinfo === '/admin/newNews') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::newNewsAction',  '_route' => 'mdqadmin_newNews',);
            }

            // mdqadmin_listNews
            if ($pathinfo === '/admin/listNews') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::listNewsAction',  '_route' => 'mdqadmin_listNews',);
            }

            // mdqadmin_modifNews
            if (0 === strpos($pathinfo, '/admin/modifNews') && preg_match('#^/admin/modifNews/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqadmin_modifNews')), array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::modifNewsAction',));
            }

            // mdqadmin_formListNews
            if ($pathinfo === '/admin/formListNews') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::formListNewsAction',  '_route' => 'mdqadmin_formListNews',);
            }

            // mdqadmin_testQdouble
            if ($pathinfo === '/admin/testQdouble') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::testQdoubleAction',  '_route' => 'mdqadmin_testQdouble',);
            }

            // mdqadmin_voirQ
            if (0 === strpos($pathinfo, '/admin/voirQ') && preg_match('#^/admin/voirQ(?:/(?P<choice>[^/]++)(?:/(?P<page>[^/]++)(?:/(?P<error>[^/]++)(?:/(?P<valid>[^/]++)(?:/(?P<diff>[^/]++)(?:/(?P<game>[^/]++)(?:/(?P<dom1>[^/]++)(?:/(?P<theme>[^/]++)(?:/(?P<crit>[^/]++)(?:/(?P<sens>[^/]++)(?:/(?P<nbdeQ>[^/]++)(?:/(?P<nbmin>[^/]++))?)?)?)?)?)?)?)?)?)?)?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqadmin_voirQ')), array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::voirQAction',  'choice' => 'list',  'page' => 1,  'error' => 0,  'valid' => 3,  'diff' => 0,  'game' => 'none',  'dom1' => 'none',  'theme' => 'none',  'crit' => 'id',  'sens' => 'ASC',  'nbdeQ' => 0,  'nbmin' => 1,));
            }

            // mdqadmin_critvoirQ
            if (0 === strpos($pathinfo, '/admin/critvoirQ') && preg_match('#^/admin/critvoirQ(?:/(?P<choice>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqadmin_critvoirQ')), array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::critvoirQAction',  'choice' => 'list',));
            }

            if (0 === strpos($pathinfo, '/admin/modifQ')) {
                // mdqadmin_modifQ
                if (preg_match('#^/admin/modifQ/(?P<id>\\d+)(?:/(?P<choice>[^/]++)(?:/(?P<error>[^/]++)(?:/(?P<valid>[^/]++)(?:/(?P<diff>[^/]++)(?:/(?P<dom1>[^/]++)(?:/(?P<theme>[^/]++)(?:/(?P<crit>[^/]++)(?:/(?P<sens>[^/]++)(?:/(?P<nbdeQ>[^/]++)(?:/(?P<nbmin>[^/]++))?)?)?)?)?)?)?)?)?)?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqadmin_modifQ')), array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::modifQAction',  'choice' => 'list',  'error' => 0,  'valid' => 3,  'diff' => 0,  'dom1' => 'none',  'theme' => 'none',  'crit' => 'id',  'sens' => 'ASC',  'nbdeQ' => 0,  'nbmin' => 1,));
                }

                // mdqadmin_modifQajax
                if ($pathinfo === '/admin/modifQajax') {
                    return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::modifQajaxAction',  '_route' => 'mdqadmin_modifQajax',);
                }

            }

            // mdqadmin_critvoirQaVal
            if ($pathinfo === '/admin/critvoirQaVal') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::critvoirQaValAction',  '_route' => 'mdqadmin_critvoirQaVal',);
            }

            // mdqadmin_voirQaVal
            if (0 === strpos($pathinfo, '/admin/voirQaVal') && preg_match('#^/admin/voirQaVal(?:/(?P<page>[^/]++)(?:/(?P<repAdmin>[^/]++)(?:/(?P<diff>[^/]++)(?:/(?P<dom1>[^/]++)(?:/(?P<crit>[^/]++)(?:/(?P<sens>[^/]++)(?:/(?P<nbdeQ>[^/]++)(?:/(?P<nbmin>[^/]++))?)?)?)?)?)?)?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqadmin_voirQaVal')), array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::voirQaValAction',  'page' => 1,  'repAdmin' => 4,  'diff' => 0,  'dom1' => 'none',  'crit' => 'id',  'sens' => 'ASC',  'nbdeQ' => 0,  'nbmin' => 1,));
            }

            // mdqadmin_retourQaValajax
            if ($pathinfo === '/admin/retourQaValajax') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::retourQaValajaxAction',  '_route' => 'mdqadmin_retourQaValajax',);
            }

            // mdqadmin_insertQaValajax
            if ($pathinfo === '/admin/insertQaValajax') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::insertQaValajaxAction',  '_route' => 'mdqadmin_insertQaValajax',);
            }

            // mdqadmin_statQ
            if ($pathinfo === '/admin/statQ') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::statQAction',  '_route' => 'mdqadmin_statQ',);
            }

            // mdqadmin_botGame
            if (0 === strpos($pathinfo, '/admin/botGame') && preg_match('#^/admin/botGame(?:/(?P<nbBots>[^/]++)(?:/(?P<djajoue>[^/]++)(?:/(?P<type>[^/]++))?)?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqadmin_botGame')), array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::botPartieAction',  'nbBots' => 1,  'djajoue' => 1,  'type' => 'Tous',));
            }

            // mdqadmin_resetTheme
            if ($pathinfo === '/admin/resetTheme') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::resetThemeAction',  '_route' => 'mdqadmin_resetTheme',);
            }

            // mdqadmin_listeTheme
            if ($pathinfo === '/admin/listeTheme') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::listeThemeAction',  '_route' => 'mdqadmin_listeTheme',);
            }

            // mdqadmin_resetError
            if ($pathinfo === '/admin/resetError') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::resetErrorAction',  '_route' => 'mdqadmin_resetError',);
            }

            // mdqadmin_gestion
            if (0 === strpos($pathinfo, '/admin/gestion') && preg_match('#^/admin/gestion(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqadmin_gestion')), array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::gestionAction',  'id' => 1,));
            }

            // mdqadmin_arbratheme
            if (0 === strpos($pathinfo, '/admin/arbratheme') && preg_match('#^/admin/arbratheme(?:/(?P<dom1>[^/]++)(?:/(?P<entete>[^/]++)(?:/(?P<viewDom2>[^/]++))?)?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mdqadmin_arbratheme')), array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::arbrathemeAction',  'dom1' => 'none',  'entete' => 1,  'viewDom2' => 0,));
            }

            // mdqadmin_mail
            if ($pathinfo === '/admin/mail') {
                return array (  '_controller' => 'MDQ\\AdminBundle\\Controller\\AdminController::mailAction',  '_route' => 'mdqadmin_mail',);
            }

        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ($pathinfo === '/login') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_security_login;
                    }

                    return array (  '_controller' => 'MDQ\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                }
                not_fos_user_security_login:

                // fos_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'MDQ\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ($pathinfo === '/logout') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_security_logout;
                }

                return array (  '_controller' => 'MDQ\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
            }
            not_fos_user_security_logout:

        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ($pathinfo === '/profile/edit') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_profile_edit;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::editAction',  '_route' => 'fos_user_profile_edit',);
            }
            not_fos_user_profile_edit:

        }

        if (0 === strpos($pathinfo, '/re')) {
            if (0 === strpos($pathinfo, '/register')) {
                // fos_user_registration_register
                if (rtrim($pathinfo, '/') === '/register') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_registration_register;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                    }

                    return array (  '_controller' => 'MDQ\\UserBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
                }
                not_fos_user_registration_register:

                if (0 === strpos($pathinfo, '/register/c')) {
                    // fos_user_registration_check_email
                    if ($pathinfo === '/register/check-email') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_check_email;
                        }

                        return array (  '_controller' => 'MDQ\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                    }
                    not_fos_user_registration_check_email:

                    if (0 === strpos($pathinfo, '/register/confirm')) {
                        // fos_user_registration_confirm
                        if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirm;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'MDQ\\UserBundle\\Controller\\RegistrationController::confirmAction',));
                        }
                        not_fos_user_registration_confirm:

                        // fos_user_registration_confirmed
                        if ($pathinfo === '/register/confirmed') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirmed;
                            }

                            return array (  '_controller' => 'MDQ\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                        }
                        not_fos_user_registration_confirmed:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/resetting')) {
                // fos_user_resetting_request
                if ($pathinfo === '/resetting/request') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_request;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
                }
                not_fos_user_resetting_request:

                // fos_user_resetting_send_email
                if ($pathinfo === '/resetting/send-email') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_resetting_send_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                }
                not_fos_user_resetting_send_email:

                // fos_user_resetting_check_email
                if ($pathinfo === '/resetting/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_check_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                }
                not_fos_user_resetting_check_email:

                // fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_resetting_reset;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::resetAction',));
                }
                not_fos_user_resetting_reset:

            }

        }

        // fos_user_change_password
        if ($pathinfo === '/profile/change-password') {
            if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                goto not_fos_user_change_password;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',  '_route' => 'fos_user_change_password',);
        }
        not_fos_user_change_password:

        // gregwar_captcha.generate_captcha
        if (0 === strpos($pathinfo, '/generate-captcha') && preg_match('#^/generate\\-captcha/(?P<key>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'gregwar_captcha.generate_captcha')), array (  '_controller' => 'Gregwar\\CaptchaBundle\\Controller\\CaptchaController::generateCaptchaAction',));
        }

        if (0 === strpos($pathinfo, '/_console')) {
            // console
            if (rtrim($pathinfo, '/') === '/_console') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_console;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'console');
                }

                return array (  '_controller' => 'CoreSphere\\ConsoleBundle\\Controller\\ConsoleController::consoleAction',  '_route' => 'console',);
            }
            not_console:

            // console_exec
            if (0 === strpos($pathinfo, '/_console/commands') && preg_match('#^/_console/commands(?:\\.(?P<_format>json))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_console_exec;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'console_exec')), array (  '_controller' => 'CoreSphere\\ConsoleBundle\\Controller\\ConsoleController::execAction',  '_format' => 'json',));
            }
            not_console_exec:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
