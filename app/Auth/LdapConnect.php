<?php
/**
 * Created by PhpStorm.
 * User: hazem
 * Date: 5/29/16
 * Time: 10:52 AM
 */

namespace App\Auth;


class LdapConnect
{
    protected $link = null;
    protected $baseDN = null;
    protected $domain = null;

    public function __construct($autoBind = false)
    {
        $this->link = ldap_connect(env('LDAP_HOST'));
        ldap_set_option($this->link, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->link, LDAP_OPT_REFERRALS, 0);

        $this->baseDN = env('LDAP_BASEDN');
        $this->domain = env('LDAP_DOMAIN');

        if ($autoBind) {
            $this->bind();
        }
    }

    public function validateLogin($credentials)
    {
        return $this->bind($credentials['login'], $credentials['password']);
    }

    public function bind($user = '', $password = '')
    {
        if (!$this->link) {
            return false;
        }

        $user = $user ?: env('LDAP_USER');
        $password = $password ?: env('LDAP_PASSWORD');

        if (stripos($user, $this->domain) === false) {
            $user .= '@' . $this->domain;
        }

        return @ldap_bind($this->link, $user, $password);
    }

    public function getUserData($username, $attributes = [])
    {
        $attributes = $attributes ?: ['displayName', 'mail', 'sAMAccountName'];

        $entries = $this->fetch('(sAMAccountName=' . $username . ')', $attributes);

        if ($entries) {
            return $entries[0];
        }

        return false;
    }

    public function getUnitsTree($dn = '')
    {
        $dn = $dn ?: $this->baseDN;
        $nodes = $this->fetch('(objectClass=organizationalUnit)', ['name', 'distinguishedName'], $dn, true);

        if ($nodes) {
            foreach ($nodes as $key => $node) {
                $nodes[$key]['children'] = $this->getUnitsTree($node['distinguishedName']);
            }
        }
        return $nodes;
    }

    public function getUnitUsers($unitDN, $attributes = [])
    {
        $attributes = $attributes ?: ['displayName', 'mail', 'sAMAccountName'];

        return $this->fetch('(objectClass=user)', $attributes, $unitDN);
    }

    public function fetch($query, $attributes, $dn = '', $list = false)
    {
        $dn = $dn ?: $this->baseDN;

        $cookie = '';
        $entries = [];

        do {
            ldap_control_paged_result($this->link, 2000, false, $cookie);

            if ($list) {
                $results = ldap_list($this->link, $dn, $query, $attributes, 0);
            } else {
                $results = ldap_search($this->link, $dn, $query, $attributes, 0);
            }

            if (!ldap_count_entries($this->link, $results)) {
                break;
            }

            $entry = ldap_first_entry($this->link, $results);
            do {
                $entries[] = $this->parseEntry($entry);
                $entry = ldap_next_entry($this->link, $entry);
            } while ($entry !== false);

            ldap_control_paged_result_response($this->link, $results, $cookie);
        } while ($cookie !== null && $cookie != '');
        
        return $entries;
    }

    protected function parseEntry($entry)
    {
        $attributes = ldap_get_attributes($this->link, $entry);
        $entity = [];

        for ($i = 0; $i < $attributes['count']; $i++) {
            $attribute = $attributes[$attributes[$i]];
            $name = strtolower($attributes[$i]);

            if ($attribute['count'] == 1) {
                $entity[$name] = $attribute[0];
            } elseif ($attribute['count'] > 1) {
                unset($attribute['count']);
                $entity[$name] = implode(', ', $attribute);
            } else {
                $entity[$name] = '';
            }
        }

        return $entity;
    }
}