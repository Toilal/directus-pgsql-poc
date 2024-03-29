<?php


$api = [
    'app' => [
        'env' => 'production',
        'timezone' => 'UTC',
    ],

    'settings' => [
        'logger' => [
            'path' => __DIR__ . '/../api/logs',
        ],
    ],

    'database' => [
        'name' => 'directus',
        'username' => 'directus',
        'password' => 'directus',
        // When using unix socket to connect to the database the host attribute should be removed
        // 'socket' => '/var/lib/mysql/mysql.sock',
        'socket' => '',
        // Connect over TLS by using the appropriate PDO_MySQL constants:
        // https://www.php.net/manual/en/ref.pdo-mysql.php#pdo-mysql.constants
        //'driver_options' => [
        //    PDO::MYSQL_ATTR_SSL_CAPATH => '/etc/ssl/certs',
        //]
    ],

    'cache' => [
        'enabled' => false,
        'response_ttl' => 3600, // seconds
        // 'pool' => [
        //    'adapter' => 'apc'
        // ],
        // 'pool' => [
        //    'adapter' => 'apcu'
        // ],
        // 'pool' => [
        //    'adapter' => 'filesystem',
        //    'path' => '../cache/', // relative to the api directory
        // ],
        // 'pool' => [
        //    'adapter'   => 'memcached',
        //    //'url' => 'localhost:11211;localhost:11212'
        //    'host'      => 'localhost',
        //    'port'      => 11211
        // ],
        // 'pool' => [
        //    'adapter'   => 'memcache',
        //    'url' => 'localhost:11211;localhost:11212'
        //    //'host'      => 'localhost',
        //    //'port'      => 11211
        //],
        // 'pool' => [
        //    'adapter'   => 'redis',
        //    'host'      => 'localhost',
        //    'port'      => 6379
        // ],
    ],

    'storage' => [
        'adapter' => 'local',
        // The storage root is the directus root directory.
        // All path are relative to the storage root when the path is not starting with a forward slash.
        // By default the uploads directory is located at the directus public root
        // An absolute path can be used as alternative.
        'root' => 'public/uploads/_/originals',
        // This is the url where all the media will be pointing to
        // here is where Directus will assume all assets will be accessed
        // Ex: (yourdomain)/uploads/_/originals
        'root_url' => '/uploads/_/originals',
        // Same as "root", but for the thumbnails
        'thumb_root' => 'public/uploads/_/thumbnails',
        //   'key'    => 's3-key',
        //   'secret' => 's3-secret',
        //   'region' => 's3-region',
        //   'version' => 's3-version',
        //   'bucket' => 's3-bucket',
        //   'options' => ['ACL' => 'public-read', 'Cache-Control' => 'max-age=604800']
        // Set custom S3 endpoint
        //   'endpoint' => 's3-endpoint',
        //   'OSS_ACCESS_ID' => 'aliyun-oss-id',
        //   'OSS_ACCESS_KEY' => 'aliyun-oss-key',
        //   'OSS_ENDPOINT' => 'aliyun-oss-endpoint',
        //   'OSS_BUCKET' => 'aliyun-oss-bucket'
        // Use an internal proxy for downloading all files
        //'proxy_downloads' => false,
    ],

    'mail' => [
        'default' => [
            'transport' => 'sendmail',
            'from' => 'admin@example.com'
        ],
    ],

    'cors' => [
        'enabled' => true,
        'origin' => ['*'],
        'methods' => [
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
            'HEAD',
        ],
        'headers' => [],
        'exposed_headers' => [],
        'max_age' => null, // in seconds
        'credentials' => false,
    ],

    'rate_limit' => [
        'enabled' => false,
        'limit' => 100, // number of request
        'interval' => 60, // seconds
        'adapter' => 'redis',
        'host' => '127.0.0.1',
        'port' => 6379,
        'timeout' => 10
    ],

    'hooks' => [
        'actions' => [],
        'filters' => [],
    ],

    'feedback' => [
        'token' => 'd7fab1277c22f797b187124eca74ac76635f1f0c',
        'login' => true
    ],

    // These tables will not be loaded in the directus schema
    'tableBlacklist' => [],

    'auth' => [
        'secret_key' => 'KCJY3zKU3TZc5KrkTOi8r2kt47pM3ahs',
        'public_key' => '7590efe7-7117-4b4a-8e3c-4078a0046fef',
        'social_providers' => [
            // 'okta' => [
            //     'client_id' => '',
            //     'client_secret' => '',
            //     'base_url' => 'https://dev-000000.oktapreview.com/oauth2/default'
            // ],
            // 'github' => [
            //     'client_id' => '',
            //     'client_secret' => ''
            // ],
            // 'facebook' => [
            //     'client_id'          => '',
            //     'client_secret'      => '',
            //     'graph_api_version'  => 'v2.8',
            // ],
            // 'google' => [
            //     'client_id'       => '',
            //     'client_secret'   => '',
            //     'hosted_domain'   => '*',
            //     // Uses OpenIDConnect to fetch the email instead of using the Google+ API
            //     // Disabling the OIDC Mode, requires you to enable the Google+ API otherwise it will fail
            //     'use_oidc_mode'   => true,
            // ],
            // 'twitter' => [
            //     'identifier'   => '',
            //     'secret'       => ''
            // ]
        ]
    ],
];

if (array_key_exists('HTTP_HOST', $_SERVER)) {
    if (strpos($_SERVER['HTTP_HOST'], 'mysql.') !== FALSE) {
        $api['database']['type'] = 'mysql';
        $api['database']['host'] = 'db2';
        $api['database']['port'] = 3306;
        $api['database']['engine'] = 'InnoDB';
        $api['database']['charset'] = 'utf8mb4';

        return $api;
    } else if (strpos($_SERVER['HTTP_HOST'], 'pgsql.') !== FALSE) {
        $api['database']['type'] = 'pgsql';
        $api['database']['host'] = 'db';
        $api['database']['port'] = 5432;

        return $api;
    }
}
throw new Exception("Could not load api configuration");
