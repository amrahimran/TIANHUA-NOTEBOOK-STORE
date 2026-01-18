<?php

namespace App\Models;

use MongoDB\Client;

class AboutUs
{
    protected $collection;

    public function __construct()
    {
        $client = new Client(env('MONGO_DB_CONNECTION_STRING'));
        $this->collection = $client->{env('MONGO_DB_DATABASE')}->{'about-description'};
    }

    // Fetch all documents as objects for Blade
    public function all()
    {
        $docs = $this->collection->find()->toArray();

        return array_map(function ($item) {
            return (object) [
                'title'   => $item['title'] ?? '',
                'content' => $item['content'] ?? '',
                'image'   => $item['image'] ?? '',
            ];
        }, $docs);
    }
}
