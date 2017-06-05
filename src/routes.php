<?php
/**
 * User: Jonty
 * Date: 6/5/2017
 */

return [
    ['GET', '/hello-world', function () {
        echo 'Hello World';
    }],
    ['GET', '/another-route', function () {
        echo 'This works too';
    }],
];