<?php

class puppet_facts {

    private $puppetdb;

    public function __construct($dbserver) {

        $this->puppetdb = $dbserver;

    }

    private function puppetdb_query($query) {

        $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $this->puppetdb . "/v3/" . $query);

        $result = curl_exec($curl);

        $result = json_decode($result,true);

        return $result;

    }

    public function nodelist($fact,$value,$operator,$json = true) {

        $query = '["and", ["=", "name", "fqdn"], ["in", "certname", ["extract", "certname", ["select-facts", ["and", ["=", "name", "'. $fact .'"], ["'. $operator .'", "value", "'. $value .'"]]]]]]';
        $query = "facts?query=" . urlencode($query);

        $results = $this->puppetdb_query($query);

        foreach($results as $host) {

            $hosts[] = $host['certname'];

        }

        if ($json) {

            return json_encode($hosts);

        } else {

            return $hosts;

        }

    }

    public function nodefacts($server,$facts,$json = true) {

        $facts = explode(",", $facts);
        $facts = array_filter($facts);

        $query = "nodes/" . $server . "/facts";

        $results = $this->puppetdb_query($query);

        foreach($results as $factname => $fact) {

            $allNodeFacts[$fact['name']] = $fact;

        }

        foreach($facts as $fact) {

            $allnodefacts[] = $allNodeFacts[$fact];

        }

        foreach($allnodefacts as $nodefact) {

            $nodefacts[] = $nodefact['value'];

        }

        $nodefacts = array_combine($facts, $nodefacts);

        if ($json) {

            return json_encode($nodefacts);

        } else {

            return $nodefacts;

        }

    }

}