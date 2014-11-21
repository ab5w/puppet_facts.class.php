puppet_facts.class.php
======================

PHP class to interact with puppetdb

Currently a work in progress as I convert my functions to the class.

#### Usage:

    <?php
    
    $puppetdb = 'https://puppetserver.hostna.me:8080';
    
    $facts = new puppet_facts($puppetdb);

##### nodefacts

Function to ruturn the values for the facts you specify, for a single server.

Facts can be comma seperated.

    $server = 'example.hostna.me';
    
    $serverfacts = $facts->nodefacts($server,"operatingsystem,osfamily,uptime_days,hardwaremodel,physicalprocessorcount,timezone,productname");

The results will be returned in an array:

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
