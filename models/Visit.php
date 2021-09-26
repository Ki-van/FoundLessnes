<?php

namespace app\models;

use app\core\DbModel;
use app\core\Request;

class Visit extends DbModel
{
    protected string $ip;
    protected string $user_agent;
    protected string $page;

    /**
     * @return mixed|string
     */
    public function getIp(): mixed
    {
        return $this->ip;
    }

    /**
     * @return mixed|string
     */
    public function getUserAgent(): mixed
    {
        return $this->user_agent;
    }

    /**
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
    }



    public function __construct(Request $request)
    {
        $this->ip = $request->getFromServer("REMOTE_ADDR");
        $this->user_agent = $request->getFromServer("HTTP_USER_AGENT");
        $this->page = $request->getPath();
    }

    static public function primaryKey(): string
    {
        return "id";
    }

    static public function tableName(): string
    {
        return "visits";
    }



    public function attributes(): array
    {
        return ["ip", "user_agent", "page"];
    }

    public function rules(): array
    {
        return [];
    }
}