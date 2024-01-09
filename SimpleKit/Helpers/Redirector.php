<?php

namespace SimpleKit\Helpers;

/**
 * Global helper function to initiate redirection.
 *
 * @param string $path
 * @return Redirector
 */
function redirect($path)
{
    return new Redirector($path);
}

/**
 * Class to handle redirection and session data.
 */
class Redirector
{
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Set session data (like flash messages).
     *
     * @param array $data
     * @return $this
     */
    public function with(array $data)
    {
        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }
        
        // Perform the actual redirection
        header("Location: {$this->path}");
        exit();
    }

    public function __destruct() {
            header("Location: {$this->path}");
            exit();
    }
    // Redirect if $this->with method is not called
}
