<?php

namespace Framework;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface FormInterface
 * @package Framework
 */
interface FormInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return FormInterface
     */
    public function handle(ServerRequestInterface $request): self;

    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @return bool
     */
    public function isSubmitted(): bool;

    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @return ModelInterface
     */
    public function getData(): ModelInterface;
}
