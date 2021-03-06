<?php

/**
 * Fetch books and categories from REST API
 *
 * @link       http://hosseinimh.com
 * @since      1.0.0
 *
 * @package    ApiResource
 * @subpackage ApiResource/includes
 */

/**
 * Fetch books and categories from REST API.
 *
 * @package    ApiResource
 * @subpackage ApiResource/includes
 * @author     Mahmoud Hosseini <hosseinimh@gmail.com>
 */
class ApiResourceFetcher
{
    /**
     * The url which data should be fetched from.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $remoteUrl    Resource API url.
     */
    private $remoteUrl;

    /**
     * Initialize the fetcher.
     *
     * @since    1.0.0
     */
    public function __construct($remoteUrl)
    {
        $this->remoteUrl = $remoteUrl;
    }

    /**
     * Fetch list of books from REST API.
     *
     * @since    1.0.0
     */
    public function fetchBooks()
    {
        return $this->fetch($this->remoteUrl . '/books');
    }

    /**
     * Fetch data from REST API.
     *
     * @since    1.0.0
     */
    private function fetch($url)
    {
        try {
            $args = [
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ];
            $response = wp_remote_get($url, $args);

            if (is_array($response) && !is_wp_error($response)) {
                $body = json_decode($response['body']);

                if ($body && empty($body['_result'])) {
                    return $body;
                }
            }
        } catch (\Error) {
        }

        return null;
    }
}
