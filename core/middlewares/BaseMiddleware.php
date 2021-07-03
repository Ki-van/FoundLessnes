<?php


namespace app\core\middlewares;


abstract class BaseMiddleware
{
    protected array $actions;
    protected int $restrictFor;
    protected $callback;

    abstract public function __construct(int $restrictFor, array $actions = [], Callable $callback = null);
    abstract public function execute();
}