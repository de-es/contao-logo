<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Logo extension.
 *
 * (c) [de][es] web solutions
 *
 * @license LGPL-3.0-or-later
 */

namespace DeEs\ContaoLogo\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Image\Studio\Studio;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ExceptionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsFrontendModule(category: 'miscellaneous')]
class LogoController extends AbstractFrontendModuleController
{
    public function __construct(
        private readonly Studio $studio,
        private readonly ContentUrlGenerator $urlGenerator,
    ) {
    }

    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        if (!$model->singleSRC) {
            return new Response();
        }

        $figureBuilder = $this->studio->createFigureBuilder();

        $figureBuilder
            ->fromUuid($model->singleSRC ?: '')
            ->setSize($model->imgSize)
        ;

        $page = PageModel::findById($model->jumpTo);

        if (null !== $page) {
            try {
                $url = $this->urlGenerator->generate($page, [], UrlGeneratorInterface::ABSOLUTE_URL);
            } catch (ExceptionInterface) {
                return new Response();
            }
            $figureBuilder->setLinkHref($url);
        }

        if (!empty($model->titleText)) {
            $figureBuilder->setLinkAttribute('title', $model->titleText);
        }

        $figure = $figureBuilder->buildIfResourceExists();

        $template->set('image', $figure);

        return $template->getResponse();
    }
}
