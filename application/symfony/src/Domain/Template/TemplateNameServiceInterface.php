<?php

namespace Infinito\Domain\Template;

/**
 * @author kevinfrantz
 */
interface TemplateNameServiceInterface
{
    /**
     * @return string A template inclusiv frame. (Standalone)
     */
    public function getMoleculeTemplateName(): string;

    /**
     * @return string a template without a frame
     */
    public function getAtomTemplateName(): string;

    /**
     * @return bool True if template exists
     */
    public function doesAtomTemplateExist(): bool;

    /**
     * @return bool True if template exists
     */
    public function doesMoleculeTemplateExist(): bool;
}
