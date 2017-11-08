<?php
namespace AppBundle\Security;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Security\Core\User\LdapUserProvider as SymfonyLdapUserProvider;
use Symfony\Component\Security\Core\User\User;
/**
 * Handles the mapping of ldap groups to security roles.
 * Class LdapUserProvider
 * @package AppBundle\Security
 */
class LdapUserProvider extends SymfonyLdapUserProvider
{
    /** @var array maps ldap groups to roles */
    private $groupMapping = [   // Definitely requires modification for your setup
        'forestapp_editor' => 'ROLE_EDITOR',
        'forestapp_admin' => 'ROLE_ADMIN',
        'forestapp_tecnicoregional' => 'ROLE_TECNICO_REGIONAL'
    ];
    /** @var string extracts group name from dn string */
    private $groupNameRegExp = '/^CN=(?P<group>[^,]+),ou.*$/i'; // You might want to change it to match your ldap server
    protected function loadUser($username, Entry $entry)
    {
        $roles = ['ROLE_USER']; // Actually we should be using $this->defaultRoles, but it's private. Has to be redesigned.
        if (!$entry->hasAttribute('memberOf')) { // Check if the entry has attribute with the group
            return new User($username, '', $roles);
        }
        foreach ($entry->getAttribute('memberOf') as $groupLine) { // Iterate through each group entry line
            $groupName = strtolower($this->getGroupName($groupLine)); // Extract and normalize the group name fron the line
            if (array_key_exists($groupName, $this->groupMapping)) { // Check if the group is in the mapping
                $roles[] = $this->groupMapping[$groupName]; // Map the group to the role the user will have
            }
        }
        return new User($username, '', $roles); // Create and return the user object
    }
    /**
     * Get the group name from the DN
     * @param string $dn
     * @return string
     */
    private function getGroupName($dn)
    {
        $matches = [];
        return preg_match($this->groupNameRegExp, $dn, $matches) ? $matches['group'] : '';
    }
}
