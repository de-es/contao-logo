<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Logo extension.
 *
 * (c) [de][es] web solutions
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['logo'] = '
    {title_legend},name,type;
    {source_legend},singleSRC,imgSize;
    {redirect_legend},jumpTo,titleText;
    {template_legend:hide},customTpl;
    {protected_legend:hide},protected;
    {expert_legend:hide},cssID
';

$GLOBALS['TL_DCA']['tl_module']['fields']['titleText'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => ['type' => 'string', 'default' => ''],
];
