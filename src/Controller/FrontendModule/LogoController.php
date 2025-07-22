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
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\FilesModel;
use Contao\ModuleModel;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsFrontendModule(category: 'miscellaneous')]
class LogoController extends AbstractFrontendModuleController
{
    public function __construct(
        private readonly ContentUrlGenerator $urlGenerator,
    ) {
    }

    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        if (!$model->singleSRC) {
            return new Response();
        }

        if (!$file = FilesModel::findByUuid($model->singleSRC)) {
            return new Response();
        }

        if ('svg' === $file->extension && $model->inlineSvg) {
            $svg = file_get_contents($file->path);
        }

        $fileMeta = $file->getMetadata($request->getLocale());

        if (null !== $fileMeta) {
            $template->set('alt', $fileMeta->getAlt());
        }

        $page = PageModel::findById($model->jumpTo);

        if (null !== $page) {
            $url = $this->urlGenerator->generate($page, [], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        $template->set('image', $file->path);
        $template->set('svg', $svg ?? null);

        $template->set('href', $url ?? null);
        $template->set('title', $model->titleText);

        return $template->getResponse();
    }
}
