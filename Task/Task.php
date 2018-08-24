<?php

/**
 * Interface Task
 */
interface Task
{
    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = []);

    /**
     * @param GuzzleClient $client
     */
    public function execute(GuzzleClient $client);
}
