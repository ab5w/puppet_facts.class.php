puppet_facts.class.php
======================

PHP class to interact with puppetdb

Currently a work in progress as I convert my functions to the class.

#### Usage:

    <?php

    $puppetdb = 'https://puppetserver.hostna.me:8080';

    $facts = new puppet_facts($puppetdb);


##### nodelist

Function to return a list of all hosts that match the value of the fact given.

    $hostlist = $facts->nodelist($fact,$value,$operator);

Operators can be;

    Equals: =
    Less than: <
    More than: >
    Regex: ~

Example:

    $hostlist = $facts->nodelist('uptime_days','1000','>');

The results will be returned as json:

    ["vmhost-01.hostna.me","vmhost-02.hostna.me","vmhost-03.hostna.me"]

If you want the results returned as a PHP array you can specify json to be false:

    $hostlist = $facts->nodelist('uptime_days','1000','>',false);

    Array
    (
        [0] => vmhost-01.hostna.me
        [1] => vmhost-02.hostna.me
        [2] => vmhost-03.hostna.me
    )

##### nodefacts

Function to return the fact values you specify for a single server. Facts can be comma seperated.

    $facts->nodefacts($server,$facts)

Example:

    $serverfacts = $facts->nodefacts($server,"operatingsystem,osfamily,uptime_days,hardwaremodel,physicalprocessorcount,timezone,productname");

The results will be returned as json:

    {"operatingsystem":"CentOS","osfamily":"RedHat","uptime_days":"295","hardwaremodel":"x86_64","physicalprocessorcount":"2","timezone":"GMT","productname":"PowerEdge R610"}

If you want the results returned as a PHP array you can specify json to be false:

    $serverfacts = $facts->nodefacts($server,"operatingsystem,osfamily,uptime_days,hardwaremodel,physicalprocessorcount,timezone,productname",false);

    Array
    (
        [operatingsystem] => CentOS
        [osfamily] => RedHat
        [uptime_days] => 295
        [hardwaremodel] => x86_64
        [physicalprocessorcount] => 2
        [timezone] => GMT
        [productname] => PowerEdge R610
    )

